<?php

// Caching image search, supports Flickr


require_once('../config.inc.php');
require_once($config['adodb_dir']);
require_once('../lib.php');

global $config;

$db = NewADOConnection('mysql');
$db->Connect("localhost", 
	$config['db_user'], $config['db_passwd'], $config['db_name']);

// Ensure fields are (only) indexed by column name
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

$debug = 0;


//--------------------------------------------------------------------------------------------------
function get_image_details($id)
{
	global $db;
	$details = array();
	
	$sql = 'SELECT * FROM images 
	WHERE (object_id = ' . $db->Quote($id) . ') LIMIT 1';
	
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
		
	if ($result->NumRows() == 1)
	{
		$details['width'] = $result->fields['width'];
		$details['height'] = $result->fields['height'];
		$details['title'] = $result->fields['title'];
		$details['description'] = $result->fields['description'];
		$details['url'] = $result->fields['url'];
		$details['flickr_username'] = $result->fields['flickr_username'];
		$details['flickr_owner'] = $result->fields['flickr_owner'];
	}
	return $details;
}

//--------------------------------------------------------------------------------------------------
// Image search 
function local_search($search_term)
{
	global $db;
	$ids = array();
	
	$search_term = trim($search_term);
	
	$sql = 'SELECT * FROM image_tag_joiner 
	INNER JOIN images USING(object_id)
	WHERE (tag = ' . $db->Quote($search_term) . ')';
	
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
		
	while (!$result->EOF) 
	{
		array_push($ids, $result->fields['object_id']);
		$result->MoveNext();	
	}
	return $ids;
}

//--------------------------------------------------------------------------------------------------
// Image search 
function local_machine_search($search_term, $namespace='taxonomy', $predicate='binomial')
{
	global $db;
	$ids = array();
	
	$search_term = trim($search_term);
	
	$sql = 'SELECT * FROM image_tag_joiner 
	INNER JOIN images USING(object_id)	
	WHERE (tag = ' . $db->Quote($search_term) . ') 
	AND (namespace = ' . $db->Quote($match['namespace']) . ')
	AND (predicate = ' . $db->Quote($match['predicate']) . ')
	LIMIT 1';
	
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
		
	while (!$result->EOF) 
	{
		array_push($ids, $result->fields['object_id']);
		$result->MoveNext();	
	}
	return $ids;
}

//--------------------------------------------------------------------------------------------------
// Image search 
function local_search_fragment($search_term)
{
	global $db;
	$ids = array();
	
	$search_term = trim($search_term);
	
	$sql = 'SELECT * FROM image_tag_joiner 
	INNER JOIN images USING(object_id)
	WHERE (tag LIKE ' . $db->Quote($search_term . ' %') . ')';
	
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
		
	while (!$result->EOF) 
	{
		array_push($ids, $result->fields['object_id']);
		$result->MoveNext();	
	}
	return $ids;
}

//--------------------------------------------------------------------------------------------------
// Yahoo image search
function yahoo_search($search_term)
{
	global $db;
	global $debug;
	global $config;
	
	$search_term = trim($search_term);
	
	$url = "http://api.search.yahoo.com/ImageSearchService/V1/imageSearch?" 
		. "appid=" . $config['Yahoo_application_id']
		. "&adult_ok=0"
		. "&query=" . str_replace (" ", "+", $search_term)
		. "&output=json"
		. "&results=5";
		
	//echo $url;
		
	$j = get($url);
	$o = json_decode($j);

	//print_r($o);
	
	if ($o->ResultSet->totalResultsReturned > 0)
	{
		foreach ($o->ResultSet->Result as $r)
		{
			#print_r($r->Title);
			
			//$guid = md5($r->Url);
			
			//echo '<img src="' . $r->Thumbnail->Url . '" />';
			
			
			$guid = md5($r->Thumbnail->Url);
			
			// Do we have this image already?
			$sql = 'SELECT * FROM images WHERE (object_id=' . $db->Quote($guid) . ') LIMIT 1';
			$result = $db->Execute($sql);
			if ($result == false) die("failed: " . $sql);
			
			if ($result->NumRows() == 0)
			{
				// We don't have this image
				$insert = 'object_id';
				$values = $db->Quote($guid);
				
				$insert .= ',title';	
				$values .= ',' . $db->Quote($r->Title);
				
				
				$insert .= ',thumbnail_url';	
				$values .= ',' . $db->Quote($r->Thumbnail->Url);
				
				$insert .= ',url';	
				$values .= ',' . $db->Quote($r->RefererUrl);
			
			
				// Dimensions
				$insert .= ',width';	
				$values .= ',' . $db->Quote($r->Thumbnail->Width);
				
				$insert .= ',height';	
				$values .= ',' . $db->Quote($r->Thumbnail->Height);
				
				$insert .= ',mimetype';	
				$values .= ',' . $db->Quote('image/jpeg');
	
				$insert .= ',description';	
				$values .= ',' . $db->Quote($r->Summary);
				
				// Image
				// Store thumbnail
				$thumb= get($r->Thumbnail->Url);
				
				$insert .= ',`blob`';	
				$values .= ',' . $db->Quote($thumb);
				
				
				$sql = 'INSERT INTO images (' . $insert . ') VALUES (' . $values . ')';
				
				//echo $sql;
					
				$result = $db->Execute($sql);
				if ($result == false) die("failed: " . $sql);
			
			}
			
			
			// Link to tags
			
			// Link to the search term
			$sql = 'SELECT * FROM image_tag_joiner 
			WHERE (tag = ' . $db->Quote($search_term) . ') 
			AND (object_id=' . $db->Quote($guid) . ') 
			LIMIT 1';
			
			$result = $db->Execute($sql);
			if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
			
			if ($result->NumRows() == 0)
			{
				$sql = 'INSERT INTO image_tag_joiner(object_id, tag) VALUES('
				 . $db->Quote($guid) . ',' . $db->Quote($search_term) .')';
				 
				$result = $db->Execute($sql);
				if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
			}
			
			
		}
	}
	
	
}



//--------------------------------------------------------------------------------------------------
// Flickr image search
function flickr_search($search_term)
{
	global $db;
	global $debug;

	$api_key = '39180c247ea391fba0f6ace7ec33dc4c';
	
	$search_term = trim($search_term);
	$tag = str_replace(' ', '', $search_term);
	$tag = str_replace('_', '', $tag);
	$tag = str_replace('+', '', $tag);
	
	
	$url = 'http://api.flickr.com/services/rest/?method=flickr.photos.search&safe_search=1&per_page=5'
	//. '&license=' . $license 
	//. '&group_id=' . $group_id 
	. '&api_key=' . $api_key . '&sort=relevance&format=json&jsoncallback=&tags=' . urlencode($tag);
	
	//echo $url . '<br/>';
	
	
	$j = get($url);
	
	// Strip callback
	$j = str_replace("jsonFlickrApi(", '', $j);
	$j = str_replace(")", '', $j);
	
	$o = json_decode($j);
	
	
	
	// Print first photo
	/*echo '<pre>';
	$p = $o->photos->photo[0];
	echo '</pre>';*/
	
	// Process photos
	foreach ($o->photos->photo as $p)
	{
	
		//print_r($p);
		
	   $thumbnail_url = "http://farm" . $p->farm . ".static.flickr.com/"
		. $p->server . "/" . $p->id . "_" . $p->secret . "_s.jpg";
		
		if ($debug)
		{
			echo '<img src="' . $thumbnail_url . '" />';
		}
		
		// get details
		
		
		$url = 'http://api.flickr.com/services/rest/?method=flickr.photos.getInfo&api_key=' . $api_key . '&photo_id=' . $p->id . '&format=json&jsoncallback=';

		if ($debug)
		{
			echo $url;
		}
		
		
		$j = get($url);
		// Strip callback
		$j = str_replace("jsonFlickrApi(", '', $j);
		$j = str_replace(")", '', $j);
		
		$photo_info = json_decode($j);
		
		if ($debug)
		{
			echo '<pre>';
			print_r($photo_info->photo);
			echo '</pre>';
		}
		
		// Machine tags?
		$machine_tag = '';
		
		foreach($photo_info->photo->tags->tag as $t)
		{
			if ($t->machine_tag == 1)
			{
				if (strpos($t->raw, 'taxonomy:binomial=') !== false)
				{
					$machine_tag = $t->raw;
				}
			}
		}
		if ($debug)
		{
			echo "tag=$machine_tag<br/>";
		}
		
		// store?
		$insert = '';
		$values = '';	
		
		$guid = md5($thumbnail_url);
		
		// Do we have this image already?
		$sql = 'SELECT * FROM images WHERE (object_id=' . $db->Quote($guid) . ') LIMIT 1';
		$result = $db->Execute($sql);
		if ($result == false) die("failed: " . $sql);
		
		if ($result->NumRows() == 0)
		{
			// We don't have this image
			$insert = 'object_id';
			$values = $db->Quote($guid);
			
			$insert .= ',title';	
			$values .= ',' . $db->Quote($p->title);
			
			
			$insert .= ',thumbnail_url';	
			$values .= ',' . $db->Quote($thumbnail_url);
			
			$insert .= ',url';	
			$values .= ',' . $db->Quote('http://www.flickr.com/photos/' . $p->owner  . '/' . $p->id);
		
			// Flickr-specific
			$insert .= ',flickr_id';	
			$values .= ',' . $db->Quote($p->id);
		
			$insert .= ',flickr_owner';	
			$values .= ',' . $db->Quote($p->owner);

			$insert .= ',flickr_username';	
			$values .= ',' . $db->Quote($photo_info->photo->owner->username);

			$insert .= ',flickr_secret';	
			$values .= ',' . $db->Quote($p->secret);
		
			$insert .= ',flickr_farm';	
			$values .= ',' . $db->Quote($p->farm);
		
			$insert .= ',flickr_license';	
			$values .= ',' . $photo_info->photo->license;
			
			// Geotagged?
			if (isset($photo_info->photo->location))
			{
				if (isset($photo_info->photo->location->latitude))
				{
					$insert .= ',latitude';	
					$values .= ',' . $db->Quote($photo_info->photo->location->latitude);
					
					$insert .= ',longitude';	
					$values .= ',' . $db->Quote($photo_info->photo->location->longitude);
				}
			}					
		
			// Dimensions
			$insert .= ',width';	
			$values .= ',' . '75';
			
			$insert .= ',height';	
			$values .= ',' . '75';
			
			$insert .= ',mimetype';	
			$values .= ',' . $db->Quote('image/jpeg');

			$insert .= ',description';	
			$values .= ',' . $db->Quote($photo_info->photo->description->_content);
			
			// Image
			// Store thumbnail
			$thumb= get($thumbnail_url);
			
			$insert .= ',`blob`';	
			$values .= ',' . $db->Quote($thumb);
			
			
			$sql = 'INSERT INTO images (' . $insert . ') VALUES (' . $values . ')';
			
			//echo $sql;
				
			$result = $db->Execute($sql);
			if ($result == false) die("failed: " . $sql);
		
		}
		
		
		// Link to tags
		
		// Link to the search term
		$sql = 'SELECT * FROM image_tag_joiner 
		WHERE (tag = ' . $db->Quote($search_term) . ') 
		AND (object_id=' . $db->Quote($guid) . ') 
		LIMIT 1';
		
		$result = $db->Execute($sql);
		if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
		
		if ($result->NumRows() == 0)
		{
			$sql = 'INSERT INTO image_tag_joiner(object_id, tag) VALUES('
			 . $db->Quote($guid) . ',' . $db->Quote($search_term) .')';
			 
			$result = $db->Execute($sql);
			if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
		}
		
		// Link to machine tag
		if ($machine_tag != '')
		{
			$match = array();
			if (preg_match('/(?<namespace>(.*)):(?<predicate>(.*))=(?<value>(.*))/', $machine_tag, $match))
			{
				if ($debug)
				{
					echo '<pre>';
					print_r($match);
					echo '</pre>';
				}
				
				$sql = 'SELECT * FROM image_tag_joiner 
				WHERE (tag = ' . $db->Quote($match['value']) . ') 
				AND (namespace = ' . $db->Quote($match['namespace']) . ')
				AND (predicate = ' . $db->Quote($match['predicate']) . ')
				AND (object_id=' . $db->Quote($guid) . ') 
				LIMIT 1';
				
				$result = $db->Execute($sql);
				if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
				
				if ($result->NumRows() == 0)
				{
					$sql = 'INSERT INTO image_tag_joiner(object_id, tag, namespace, predicate) VALUES('
					 . $db->Quote($guid) . ',' . $db->Quote($match['value']) . ',' .  $db->Quote($match['namespace']) . ',' .  $db->Quote($match['predicate']) . ')';
					 
					 //echo $sql;
					 
					$result = $db->Execute($sql);
					if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
				}
				
				
				
			}
		}
		
		
		
		$sql = 'SELECT * FROM image_tag_joiner 
		INNER JOIN images USING(object_id)
		WHERE (tag = ' . $db->Quote($search_term) . ') 
		AND (object_id=' . $db->Quote($guid) . ') 
		LIMIT 1';
		
		$result = $db->Execute($sql);
		if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
		
		if ($result->NumRows() == 0)
		{
			$sql = 'INSERT INTO image_tag_joiner(object_id, tag) VALUES('
			 . $db->Quote($guid) . ',' . $db->Quote($search_term) .')';
			 
			$result = $db->Execute($sql);
			if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
		}
		
		
		
		
		
	}		
}


//--------------------------------------------------------------------------------------------------
function get_one_image_id($search_term, $do_search = false)
{
	global $debug;
	global $db;
	
	$result = '';
	
	// 1. Machine tag search first
	$ids = local_machine_search($search_term);
	if (count($ids) > 0)
	{
		$result = $ids[0];
	}
	else
	{
		// 2. Exact match
		$ids = local_search($search_term);
		if (count($ids) > 0)
		{
			$result = $ids[0];
		}
		else
		{
			// 3. Match fragment (genus name)
			$parts = split(" ", $search_term);
//			$ids = local_search_fragment($parts[0]);
			if (count($ids) > 0)
			{
				$result = $ids[0];
			}
			else
			{
				
				if ($do_search)
				{
//					echo '<h1>Do search</h1>';

					// get some images from Flickr
//					flickr_search($search_term);
					yahoo_search($search_term);


					//echo '<h1>Done search</h1>';
					
					$result = get_one_image_id($search_term);
					
					if ($result == '')
					{
						// store link to blank image to avoid researching for image every time
						
						$sql = 'INSERT INTO image_tag_joiner(object_id, tag) VALUES('
						 . $db->Quote('blank') . ',' . $db->Quote($search_term) .')';
						
						$r = $db->Execute($sql);
						if ($r == false) die("failed [" . __LINE__ . "]: " . $sql);
						
						$result = 'blank';
						
						
					}
				}
			}
		}
	}
	
	if ($result != '')
	{
		
		if ($debug)
		{
			echo '<pre>';
			print_r($ids);
			echo '</pre>';
			
			foreach ($ids as $id)
			{
				echo '<img src="media.php?id=' . $id . '"/>';
			}
		}
	}
	return $result;
}


//--------------------------------------------------------------------------------------------------


if (0)
{
	// blank image (do this once to help speed up display of images)
	$url = 'http://127.0.0.1/~rpage/challenge/www/images/blank100x100.png';
	$thumb = get($url);
	
	echo $url . "\n";
	echo "thumb=" . $thumb . "\n";
	$sql = 'INSERT INTO images(object_id, title, thumbnail_url, url, width, height, mimetype, `blob`) VALUES (' 
	. $db->Quote('blank')
	. ',' . $db->Quote('blank')
	. ',' . $db->Quote($url)
	. ',' . $db->Quote('')
	. ',' . $db->Quote('100')
	. ',' . $db->Quote('100')
	. ',' . $db->Quote('image/jpeg')
	. ',' . $db->Quote($thumb)
	. ')';	
	
	echo $sql;
	
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
}	

if (0)
{
	// prepopulate with Flicr images that match bionomial tags
	
	$names = array(
'Acanthognathus ocellatus',
'Vollenhovia emeryi',
'Trachymyrmex arizonensis',
'Tetramorium validiusculum',
'Terataner sp. MAD02',
'Technomyrmex difficilis',
'Technomyrmex sp. MAD05',
'Tatuidris sp. ECU01',
'Strumigenys dicomas',
'Stenamma dyscheres',
'Scolia verticalis',
'Rhytidoponera chalybaea',
'Rhopalomastix rothneyi',
'Pyramica hoplites',
'Pseudolasius australis',
'Protanilla sp. JAP01',
'Procryptocerus scabriusculus',
'Proceratium sp. MAD08',
'Probolomyrmex tani',
'Prionopelta sp. MAD01',
'Prenolepis albimaculata',
'Polyrhachis sp. Hagio01',
'Polyrhachis sp. Cyrto01',
'Plectroctena ugandensis',
'Pheidologeton affinis',
'Pheidole hyatti',
'Pheidole clydei',
'Paratrechina hystrix',
'Pachycondyla sikorae',
'Notoncus capitatus',
'Myrmicocrypta cf. infuscata CASENT0010123',
'Myrmicaria exigua',
'Myrmica striolagaster',
'Myrmelachista sp. JTL01',
'Monomorium ergatogyna',
'Messor denticornis',
'Messor andrei',
'Meranoplus cf. radamae CASENT0486686',
'Mayriella ebbei',
'Manica bradleyi',
'Loboponera politula',
'Liometopum apiculatum',
'Leptothorax cf. muscorum CASENT0106029',
'Leptomyrmex sp. AUS01',
'Leptogenys diminuta',
'Leptanilla sp. RSA01',
'Leptanilla sp. GRE01',
'Forelius pruinosus',
'Eutetramorium mocquerysi',
'Eurhopalothrix bolaui',
'Dorymyrmex bicolor',
'Dolichoderus scabridus',
'Discothyrea sp. MAD07',
'Dasymutilla aureola',
'Cheliomyrmex cf. morosus CASENT0007006',
'Cerapachys sexspinus',
'Centromyrmex sellaris',
'Cataulacus sp. MAD02',
'Camponotus maritimus',
'Camponotus conithorax',
'Camponotus sp. BCA01',
'Calomyrmex albertisi',
'Azteca ovaticeps',
'Aphaenogaster swammerdami',
'Aphaenogaster albisetosa',
'Anonychomyrma gilberti',
'Adetomyrma sp. MAD02',
'Acromyrmex versicolor',
'Acanthoponera minor',
'Turneria bidentata',
'Thaumatomyrmex atrox',
'Solenopsis molesta',
'Simopelta cf. pergandei CASENT0052744',
'Sapyga pumila',
'Pristocera sp. CASENT0006958',
'Pilotrochus besmerus',
'Orectognathus versicolor',
'Notostigma carazzii',
'Nesomyrmex echinatinodis',
'Microdaceton tibialis',
'Crematogaster emeryana',
'Chalybion californicum',
'Basiceros manni',
'Aporus niger',
'Aglyptacros cf. sulcatus CASENT0106122',
'Aenictogiton sp. ZAM02',
'Psalidomyrmex procerus',
'Odontomachus coquereli',
'Mystrium mysticum',
'Xenomyrmex floridanus',
'Philidris cordatus',
'Papyrius nitidus',
'Odontoponera transversa',
'Metapone madagascarica',
'Leptanilloides nomada',
'Heteroponera panamensis',
'Aneuretus simoni',
'Myrmecina graminicola',
'Opisthopsis respiciens',
'Anoplolepis gracilipes',
'Acropyga acutiventris',
'Brachymyrmex depilis',
'Cardiocondyla mauritanica',
'Solenopsis xyloni',
'Aphaenogaster occidentalis',
'Camponotus sp. near vicinus 15202',
'Simopone marleyi',
'Leptanilloides mckennae',
'Leptanilloides sp. EC1',
'Cerapachys augustae',
'Platythyrea mocquerysi',
'Acanthostichus kirbyi',
'Leptanilla sp. D233',
'Chyphotes mellipes',
'Tetraponera punctulata',
'Leptomyrmex erythrocephalus',
'Ectatomma opaciventre',
'Proceratium stictum',
'Hypoponera opacior',
'Myrmecocystus flaviceps',
'Anochetus madagascarensis',
'Prenolepis imparis',
'Lasius californicus',
'Apterostigma auriculatum',
'Tetramorium caespitum',
'Daceton armigerum',
'Polyergus breviceps',
'Apomyrma stygia',
'Myrmoteras iriodum',
'Typhlomyrmex rogenhoferi',
'Hypoponera sakalava',
'Concoctio concenta',
'Onychomyrmex hedleyi',
'Amblyopone mutica',
'Cylindromyrmex striatus',
'Cerapachys larvatus',
'Eciton vagans',
'Sphinctomyrmex steinheili',
'Neivamyrmex nigrescens',
'Dorylus helvolus',
'Aenictus ceylonicus',
'Aenictus eugenii',
'Amblyopone pallipes',
'Pogonomyrmex subdentatus',
'Mischocyttarus flavitarsis',
'Myrmecia pyriformis',
'Dorylus laevigatus',
'Pseudomyrmex gracilis',
'Myrcidris epicharis',
'Temnothorax rugatulus',
'Camponotus hyatti',
'Formica moki',
'Nothomyrmecia macrops',
'Gnamptogenys striatula',
'Liometopum occidentale',
'Metapolybia cingulata',
'Oecophylla smaragdina',
'Linepithema humile',
'Platythyrea punctata',
'Wasmannia auropunctata',
'Paraponera clavata',
'Tapinoma sessile (odorous house ant)',
'Tetraponera rufonigra',
'Myrmica tahoensis',
'Apis mellifera'		);

$names=array(
'Duellmanohyla rufioculis',
'Hypsiboas albomarginatus',
'Hypsiboas albopunctatus',
'Hypsiboas andinus',
'Hyloscirtus armatus',
'Bokermannohyla astartea',
'Hypsiboas balzani',
'Hypsiboas bischoffi',
'Hypsiboas caingua',
'Hyla cinerea',
'Bokermannohyla circumdata',
'Hypsiboas cordobae',
'Hypsiboas ericae',
'Hypsiboas faber',
'Hypsiboas fasciatus',
'Hypsiboas granosus',
'Hypsiboas guentheri',
'Bokermannohyla hylax',
'Hypsiboas joaquini',
'Hypsiboas leptolineatus',
'Hypsiboas marginatus',
'Hypsiboas marianitae',
'Dendropsophus minutus',
'Dendropsophus nanus',
'Hypsiboas prasinus',
'Hypsiboas pulchellus',
'Hypsiboas punctatus',
'Hypsiboas riojanus',
'Hypsiboas semiguttatus',
'Hypsiboas sp. MA37793',
'Hypsiboas latistriatus',
'Hyloscirtus tapichalaca',
'Osteocephalus leprieurii',
'Trachycephalus venulosus',
'Phyllomedusa vaillanti',
'Pseudis paradoxa',
'Scinax rubra',
'Smilisca baudinii',
'Sphaenorhynchus lacteus'
);

// weevils
$names=array(
'Curculio undulatus',
'Curculio sp. 55',
'Curculio salicivorus',
'Curculio scutellaris',
'Curculio pardalis',
'Curculio proboscideus',
'Curculio nucum',
'Curculio sp. 27',
'Curculio sp. A8',
'Curculio camelliae',
'Curculio elephas',
'Curculio longidens',
'Curculio victoriensis',
'Curculio confusor',
'Curculio sulcatulus',
'Curculio iowensis',
'Curculio nasicus',
'Curculio humeralis',
'Curculio pellitus',
'Curculio venosus',
'Curculio pyrrhoceras',
'Curculio glandium',
'Curculio caryae');
		
$names=array(
'Amphiprion ocellaris',
'Amphiprion sandaracinos',
'Amphiprion perideraion',
'Amphiprion akallopisos',
'Amphiprion percula');

		
	$debug = 1;

	foreach ($names as $name)
	{
//		$tag = 'taxonomy:binomial=' . $name;
		$tag = $name;
		flickr_search($tag);
	}
		
		
}

if (0)
{
	print_r(get_one_image_id('Panthera leo'));
}

if(0)
{
// tests	
	
	$tag = 'Diomedea bulleri';
	$tag = 'Diomedea exulans';
//	$tag = 'taxonomy:binomial=Bufo marinus';
/*	$tag = 'Testudo marginata';*/
//	$tag = 'Geochelone pardalis';
	
	$tag = 'Chrysotoxum bicinctum';
//	$tag = 'Uca tangeri';

//$tag='Sphaerophoria scripta';
//$tag='Leptograpsus variegatus';

//$tag='Psammobates pardalis';

//$tag='Manouria emys';

//$tag = 'Indotestudo elongata';

$tag = 'Apus apus';
//$tag = 'Morus basanus';

//$tag = 'Allobates nidicola';

//$tag = 'Blaesodactylus';


//flickr_search('Syrphus ribesii');

$tag = 'Zacco platypus';

echo $tag;
echo get_one_image_id($tag, true);

//yahoo_search($tag);


/*

$ids = local_search_fragment($tag);

if (count($ids) == 0)
{
	flickr_search($tag);
}
$ids = local_search_fragment($tag);

if (count($ids) > 0)
{
	echo '<pre>';
	print_r($ids);
	echo '</pre>';
	
	foreach ($ids as $id)
	{
		echo '<img src="media.php?id=' . $id . '"/>';
	}
}

*/
// store this image in a simple lookup table

/*tag/url

				.       $db->Quote($guid)
				. ',' . $db->Quote($r->Title)
				. ',' . $db->Quote($r->Summary)
				. ',' . $db->Quote($r->Url)
				. ',' . $db->Quote($r->RefererUrl)
				. ',' . $r->FileSize
				. ',' . $db->Quote($r->FileFormat)
				. ',' . $r->Height
				. ',' . $r->Width
				. ')';

*/

}

?>



