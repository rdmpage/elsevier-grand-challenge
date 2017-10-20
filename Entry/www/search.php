<?php

require_once('../config.inc.php');
require_once($config['adodb_dir']);
require_once('../eav/eav.php');
require_once('html.php');
require_once('../query.php');
//require_once('searchClassify.php');

$list = array();
$min_score = 1000;
$max_score = 0;


define('SEARCH_LITERAL', 				0);	// Fulltext search
define('SEARCH_GEOGRAPHIC_OVERLAP', 	1);	// Geographic overlap
define('SEARCH_COUNTRY', 				2);	// Geographic overlap using country name

//--------------------------------------------------------------------------------------------------
function GetSearchTypeMsg ($type)
{
	switch ($type)
	{
		case SEARCH_LITERAL:
			$msg = 'literal';
			break;

/*		case SEARCH_GEOGRAPHIC_OVERLAP:
			$msg = 'geographic overlap';
			break;		*/	
			
		case SEARCH_COUNTRY:
			$msg = 'Studies that intersect the bounding box of country';
			break;			
			
			
/*		case SEARCH_URI:
			$msg = 'search for a Uniform Resource Identifier (URI)';
			break;
		case SEARCH_LSID:
			$msg = 'search for a Life Sciences Identifier (LSID)';
			break;
		case SEARCH_DOI:
			$msg = 'search for Digital Object Identifier (DOI)';
			break;
		case SEARCH_SPECIMEN:
			$msg = 'search for specimen identifier';
			break;*/

		default:
			$msg = 'unknown search type';
			break;
	}
	return $msg;
	
}


//--------------------------------------------------------------------------------------------------
// Return geonameId if term is a country name otherwise 0
function term_is_country($query_string)
{
	global $db;
	
	$geonameId = 0;
	
	$sql = 'SELECT * FROM country WHERE (countryName = ' . $db->Quote($query_string) . ') LIMIT 1';
	$result = $db->Execute($sql);
	if ($result == false) die("failed $sql");  
	
	if (1 == $result->NumRows())
	{
		$geonameId = $result->fields['geonameId'];
	}
	
	return $geonameId;
}

//--------------------------------------------------------------------------------------------------
function search_geographic_feature($geonameId)
{
	global $db;
	global $list;
	
	// Get bounding box of country
	$sql = 'SELECT * FROM country WHERE (geonameId = ' . $geonameId . ') LIMIT 1';
	$result = $db->Execute($sql);
	if ($result == false) die("failed $sql");  
	
	//echo $sql;
	
	if (1 == $result->NumRows())
	{
	
		//echo "search poly";
		
		$poly = array();
		array_push($poly, array($result->fields['bBoxWest'], $result->fields['bBoxNorth']));
		array_push($poly, array($result->fields['bBoxWest'], $result->fields['bBoxSouth']));
		array_push($poly, array($result->fields['bBoxEast'], $result->fields['bBoxSouth']));
		array_push($poly, array($result->fields['bBoxEast'], $result->fields['bBoxNorth']));
		
		//echo polygon_to_mysql($poly);
		
		$list = objects_in_polygon(polygon_to_mysql($poly, false));
	
	
//		$list = inBoundingBox($result->fields['bBoxWest'], $result->fields['bBoxNorth'], $result->fields['bBoxEast'], $result->fields['bBoxSouth']);
	}
	
	//print_r($list);
	
	return $list;
	
}


	

//--------------------------------------------------------------------------------------------------
function f_search($query_string, $table, $field)
{
	global $db;
	
	global $list;
	global $min_score;
	global $max_score;
	
	if ('object' == $table)
	{
		$sql = 'SELECT *, MATCH ('. $field . ') AGAINST ("' . $query_string . '") AS score 
		FROM ' . $table . '
		WHERE MATCH(' . $field . ') AGAINST ("' . $query_string . '" IN BOOLEAN MODE)';
	}
	else
	{
		$sql = 'SELECT *, MATCH ('. $field . ') AGAINST ("' . $query_string . '") AS score 
		FROM ' . $table . '
		INNER JOIN object ON object.object_id = ' . $table . '.object_id
		WHERE MATCH(' . $field . ') AGAINST ("' . $query_string . '" IN BOOLEAN MODE)';		
	}
	
	
	// test
	//$sql .= ' LIMIT 10';
	
	//echo $sql;
	

	$result = $db->Execute($sql);
	if ($result == false) die("failed $sql");  
	
	while (!$result->EOF) 
	{
		if ('object' == $table)
		{
			$object = $result->fields['object_id'];
		}
		else
		{
			$object = $result->fields['object_id'];
		}
		
		if (isset($list[$object]))
		{
			$list[$object]['score'] += $result->fields['score'];

			$list[$object]['name'] = $result->fields['name'];
			$list[$object]['description'] = $result->fields['description'];

			$max_score = max($result->fields['score'], $max_score);
		}
		else
		{
			$list[$object] = array(
				'object_id' => $object,
				'score' => $result->fields['score']
			);
			$list[$object]['name'] = $result->fields['name'];
			$list[$object]['description'] = $result->fields['description'];
			$max_score = max($result->fields['score'], $max_score);
			$min_score = min($result->fields['score'], $min_score);
		}

		$result->MoveNext();
	}
	
}


//--------------------------------------------------------------------------------------------------
/**
 * Search attributes using MySQL full text search.
*/
function fullTextSearch($q)
{
	global $db;
	$list = array();
	
	// Search
	$query_string = $q;

	// We do the simplest thing and look for all occurrences of terms in the string
	$query_string = str_replace (" ", " +", $query_string);
	$query_string = '+' . $query_string;
	
	$sql = 'SELECT *, MATCH (object_text) AGAINST ("' . $query_string . '") AS score 
	FROM object_text
	INNER JOIN object USING(object_id)
	WHERE MATCH(object_text) AGAINST ("' . $query_string . '" IN BOOLEAN MODE)
	ORDER BY score DESC';
	
	//echo $sql;
	
	$result = $db->Execute($sql);
	if ($result == false) die("failed $sql");  
	
	while (!$result->EOF) 
	{
		$link = array(
			'object_id' => $result->fields['object_id'],
			'name' => $result->fields['name'],
			'score' => $result->fields['score']
			);
			
		array_push($list, $link);
		$result->MoveNext();
	}
	
	
	
	return $list;

}



if (isset($_GET['id']))
{
	$query_object = $_GET['id'];
}



$query = $_GET['q'];

$query_type = SEARCH_LITERAL;
$query_object = '';

if (isset($_GET['type']))
{
	switch($_GET['type'])
	{
		case 'overlap':
			$query_type = SEARCH_GEOGRAPHIC_OVERLAP;
			break;
			
		default:
			$query_type = SEARCH_LITERAL;
			break;
	}
		
}
else
{
	// Try to work out what user wants....
	
	if (0 <> term_is_country($query))
	{
		$query_type = SEARCH_COUNTRY;		
	}
	
}


$results = array();

// do search

switch ($query_type)
{
	case SEARCH_LITERAL:
		$results = fullTextSearch ($query);
		break;

/*	case SEARCH_GEOGRAPHIC_OVERLAP:
		$results = overlap ($query_object);
		break;*/
		
	case SEARCH_COUNTRY:
		$results = search_geographic_feature (term_is_country($query));
		break;

		
	default:
		break;
}



// html

if (1)
{
	global $config;
	
	echo html_html_open();
	echo html_head_open();
	echo html_title($query);
		
	echo  "<!-- Prototype -->\n";
	echo html_include_script('prototype.js');

	
	echo 	'<script type="text/javascript">
function snippet(obj) 
{
	var pattern = \'li[id^="\' + obj.object_id + \'"]\';
	var elements = $$(pattern);
	elements.each( function(dis) { dis.innerHTML= obj.html } );

}</script>';	
	
	
	echo html_head_close();
	echo html_body_open();
	echo html_top($query);
	echo '<div id="main-content-container">';
	echo '<h1>Searching on &quot;' . $query . '&quot;</h1>';
	echo '<p class="explain">' . GetSearchTypeMsg($query_type) . '</p>';
	
	$ref_count = 0;
	
		
	echo '<ol>';
	foreach ($results as $r)
	{
		echo  '<li id="' . $r['object_id'] . '_' . $ref_count++ . '"><a href="uri/' . $r['object_id'] . '">' . $r['name'] . '</a></li>';
	}
	echo '</ol>';
	echo '<div>';
	
	foreach ($results as $r)
	{
		echo '<script type="text/javascript" src="snippet.php?id=' . $r['object_id']. '"></script>';
	}

	echo html_body_close();
	echo html_html_close();
}

?>

