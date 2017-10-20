<?php

// display an object something

require_once('../config.inc.php');
require_once('../object_factory.php');
require_once('../query.php');



//------------------------------------------------------------------------------
/**
 * @brief RDF as RSS 1.0
 */
/*
function display_object_rdf($id)
{
	global $config;
	
	$feed = new DomDocument('1.0');
	$rdf = $feed->createElement('rdf:RDF');
	
	// namespaces
	$rdf->setAttribute('xmlns',         'http://purl.org/rss/1.0/');
	$rdf->setAttribute('xmlns:rdf',     'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
	$rdf->setAttribute('xmlns:foaf',    'http://xmlns.com/foaf/0.1/');
	$rdf->setAttribute('xmlns:dc',      'http://purl.org/dc/elements/1.1/');
	$rdf->setAttribute('xmlns:dcterms', 'http://purl.org/dc/terms/');
	$rdf->setAttribute('xmlns:prism',   'http://prismstandard.org/namespaces/1.2/basic/');
	$rdf->setAttribute('xmlns:tag',   	'http://www.holygoat.co.uk/owl/redwood/0.1/tags/');
	
	$rdf = $feed->appendChild($rdf);
	
	// Channel
	$channel = $feed->createElement('channel');
	$channel->setAttribute('rdf:about', $config['webroot'] . 'uri/' . $id . '&amp;format=rdf');
	$channel = $rdf->appendChild($channel);

	$o = object_factory($id);
	if ('' != $o)
	{	
		$o->Retrieve($id);
		
		// Title
		$title = $feed->createElement('title');
		$title = $channel->appendChild($title);
		$value = $feed->createTextNode($o->GetTitle());
		$value = $title->appendChild($value);

		// Link
		$link = $feed->createElement('link');
		$link = $channel->appendChild($link);
		$value = $feed->createTextNode($config['webroot'] . 'uri/' . $id );
		$value = $link->appendChild($value);

		// Description
		$description = $feed->createElement('description');
		$description = $channel->appendChild($description);
		$value = $feed->createTextNode($o->GetDescription());
		$value = $description->appendChild($value);
		
		// Items
		$items = $feed->createElement('items');
		$items = $channel->appendChild($items);

		$seq = $feed->createElement('rdf:Seq');
		$seq = $items->appendChild($seq);

		$li = $feed->createElement('rdf:li');
		$li = $seq->appendChild($li);
		$li->setAttribute('rdf:resource', $config['webroot'] . 'uri/' . $id );
		
				
		switch ($o->GetType())
		{				
			default:
				$item = $feed->createElement('item');
				$item = $rdf->appendChild($item);
				$item->setAttribute('rdf:about', $config['webroot'] . 'uri/' . $id );
			
				$title = $feed->createElement('title');
				$title = $item->appendChild($title);
				$value = $feed->createTextNode($o->GetTitle());
				$value = $title->appendChild($value);
				
				// link 
				$link = $feed->createElement('link');
				$link = $item->appendChild($link);
				$value = $feed->createTextNode($config['webroot'] . 'uri/' . $id );
				$value = $link->appendChild($value);

				// Description
				$description = $feed->createElement('description');
				$description = $item->appendChild($description);
				$value = $feed->createTextNode($o->GetDescription());
				$value = $description->appendChild($value);
			
				// Get object-specific RDF
				$o->GetRdf($feed, $item);
				break;
		
		}
	}
	
	header("Content-type: text/xml");
	echo $feed->saveXML();
}



*/


function main()
{
	global $config;
	
	$object_id = '';
	
	
	// Has user supplied a GUID?
	if (isset($_GET['guid']))
	{
		$guid = $_GET['guid'];
		$namespace = $_GET['namespace'];
		$object_id = db_find_object_with_guid($namespace, $guid);
		
		if ($object_id == '')
		{
			echo 'guid not found';
			exit();
		}
	}	
	else
	{
		if (isset($_GET['id']))
		{
			$object_id = $_GET['id'];
		}
		else
		{
			echo 'No id';
			exit();
		}
	}
	
	
	
	$o = object_factory($object_id);
	$o->Retrieve();
	
	echo '<html>';
	echo '<head>';
	echo '<title>' . $o->GetTitle() . '</title>';
	echo '</head>';
	echo '<body>';
	
	echo '<h1>' . $o->GetTitle() . '</h1>';
	
	echo '<h3>Object class</h3>';
	echo $o->GetType();
	
	echo '<h3>Attributes</h3>';
	echo $o->GetAttributesAsHtmlTable();
	
	// show identifiers
	echo '<h3>GUIDs</h3>';
	echo '<pre>';
	print_r(db_retrieve_guids($object_id));
	echo '</pre>';
	
	echo '<h3>Map</h3>';
	// map
	
	
	
/*	// Could cache this to build a spatial index
	
	//for a publication
	
	$locs = db_get_localities_for_object($object_id);
	
	// sequences 
	$incoming = db_outgoing_links($object_id, RELATION_REFERENCES, CLASS_GENBANK);
	foreach ($incoming as $link)
	{
		$l = db_get_localities_for_object($link['object_id']);
		$locs = array_merge($locs, $l);
	}
	
	echo '<pre>';
	print_r($locs);
	echo '</pre>';

	
	
	
	
	
	
	$locs = db_get_localities_for_object($object_id);
	
	
	if (count($locs) > 0)
	{
		
		$xy = $locs[0][xy];
		//print_r($xy);
		$latitude = $xy[1];
		$longitude = $xy[0];
		
		echo '
<!--[if IE]>
<embed width="360" height="180" src="map.php?lat=' . $latitude . '&long=' . $longitude . '">
</embed>
<![endif]-->
<![if !IE]>
<object id="mysvg" type="image/svg+xml" width="360" height="180" data="map.php?lat=' . $latitude . '&long=' . $longitude . '">
<p>Error, browser must support "SVG"</p>
</object>
<![endif]>	';
		
	
	}
	
*/

		echo '
<!--[if IE]>
<embed width="360" height="180" src="map_object.php?id=' . $object_id . '">
</embed>
<![endif]-->
<![if !IE]>
<object id="mysvg" type="image/svg+xml" width="360" height="180" data="map_object.php?id=' . $object_id . '">
<p>Error, browser must support "SVG"</p>
</object>
<![endif]>	';
	
	
	// links 
	echo '<h3>Links</h3>';
	
	
	// object specific
	
	if ($o->GetType() == CLASS_REFERENCE)
	{
		$cited_by = db_incoming_links($object_id, RELATION_REFERENCES, CLASS_REFERENCE);
	
		echo '<h4>Cited by ' . count($cited_by) . '</h4>';
		echo '<ul>';
		foreach ($cited_by as $link)
		{
			echo '<li>' . '<a href="get.php?id=' . $link['object_id'] . '">' . $link['name'] . '</a></li>';
		}
		echo '</ul>';
		
		
		// Data links (what papers use data cited in this study)?
		// == bibliographic coupling
		
		// data coupling
		// what data does this paper use
		// what other papers cite these data?
		
		$data_coupling = query_colinks($object_id, RELATION_REFERENCES, CLASS_REFERENCE, CLASS_GENBANK);
		echo '<h4>Data coupling ' . count($data_coupling) . '</h4>';
		
		echo '<pre>';
		print_r($data_coupling);
		echo '</pre>';
		
	}

	
	
	
	// generic
	echo '<table>';
	$incoming = db_incoming_links($object_id);
	foreach ($incoming as $link)
	{
		echo '<tr>';
		echo '<td>' . $link['type'] . ' &lt;-- </td>';
		echo '<td>' . '<a href="get.php?id=' . $link['object_id'] . '">' . $link['name'] . '</a></td>';
		echo '</tr>';
	}
	$outgoing = db_outgoing_links($object_id);
	foreach ($outgoing as $link)
	{
		echo '<tr>';
		echo '<td>' . $link['type'] . ' --&gt; </td>';
		echo '<td>' . '<a href="get.php?id=' . $link['object_id'] . '">' . $link['name'] . '</a></td>';
		echo '</tr>';
	}
	echo '</table>';
	

	
	// graphs
	if ($o->GetType() == CLASS_PERSON)
	{
		// author stuff
		$f = query_colinks($object_id);//, RELATION_AUTHOR_OF, CLASS_PERSON);
		echo '<pre>';
		print_r($f);
		echo '</pre>';
		
		// Make graph
		$G = new Graph();
		$c = count($f);
		
		for ($i = 0; $i < $c; $i++)
		{
			$sourceNode = $G->AddNode($f[$i]['object_id'], $f[$i]['name']);
			
			for ($j = $i+1; $j < $c; $j++)
			{
				if (query_coauthored($f[$i]['object_id'], $f[$j]['object_id']))
				{
					$targetNode = $G->AddNode($f[$j]['object_id'], $f[$j]['name']);
					$G->AddEdge($sourceNode, $targetNode);
					
				}
			}
		}
		echo '<h3>Coauthors</h3>';
		$filename = "tmp/" . $object_id . "_coauthors" . ".dot";
		$G->WriteDotToFile($filename);	
		
		$html = '<img src="' . $config['webdot'] . '/' . $config['webroot'] . $filename . '.png" usemap="#G" border="0" alt="graph"/>';
		echo $html;
	}
	
	
	// show graph
	echo '<h3>Graph (all relationships)</h3>';
	$G = $o->GetGraph();
	
	$filename = "tmp/" . $object_id . ".dot";
	$G->WriteDotToFile($filename);	
	
	$html = '<img src="' . $config['webdot'] . '/' . $config['webroot'] . $filename . '.png" usemap="#G" border="0" alt="graph"/>';
	echo $html;

	echo '</body>';
	echo '</html>';

}

main();

?>

