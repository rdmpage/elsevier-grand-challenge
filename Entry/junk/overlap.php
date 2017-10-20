<?php


// $Id:  $

/**
 * @file overlap.php
 *
 *
  */
  
$rootdir = dirname(__FILE__) . '/';

require_once($rootdir . 'eav/eav.php');
require_once($rootdir . 'spatial.php');

//--------------------------------------------------------------------------------------------------
function overlap($id)
{
	$list = array();
	
	$A = 0;
	$B = array();

	// Get localities for this object
	$points = db_get_localities_for_object($id, 2);

	$A = count($points);

	$polygonA = array();
	foreach($points as $p)
	{
		array_push($polygonA, $p['pt']);
	}
	$polygonAMySQL = polygon_to_mysql($polygonA);


	// Studies (need to generalise this to other object types, and perhaps filtered taxonomcially...)

	// find studies with polygons overlapping A
	$insideA = db_get_objects_in_polygon($polygonAMySQL, $id);

	echo '<pre>';
	print_r($insideA);

	//echo $polygonAMySQL;

	$insideB = array();

	// Find how many of A's localities are in B's polygon
	foreach ($insideA as $k => $v)
	{
//		echo $k, '<br/>';
	
		// Polygon B
		$points = db_get_localities_for_object($k, 2);
	
		$B[$k] = count($points);
	
		$polygonB = array();
		foreach($points as $p)
		{
			array_push($polygonB, $p['pt']);
		}
	
		$polygonBMySQL = polygon_to_mysql($polygonB);
	
		// Count localities
		$inside = db_get_objects_in_polygon($polygonBMySQL, '', $id);
	
		print_r($inside);
		
		$insideB[$k] = $inside[$id];
	}

	print_r($insideB);


	// Compute a version of the DICE measure
	// i.e., similarity is the 
	// (number of A's localities inside polygon B + number of B's localities inside polygon A) 
	// / (number of localities for A + number of localities for B)
	$dice = array();

	foreach ($insideA as $k => $v)
	{
	
		$dsc = ($insideA[$k] + $insideB[$k])/($A + $B[$k]);
	
		$dice[$k] = $dsc;
	}

	// Ok, here's the final list

	array_multisort($dice, SORT_DESC, $insideA, SORT_DESC);
//	echo "<h3>Studies overlapping $id</h3>";

/*	foreach ($dice as $k => $v)
	{
		echo '<a href="get.php?id=' . $k . '">' .  $k . '</a> [' . $v .']<br />';
	}*/
	
	// make list
	foreach ($dice as $k => $v)
	{
		$list[$k] = array(
			'object_id' => $k,
			'score' => $v
		);
	}
	
	return $list;

}

//--------------------------------------------------------------------------------------------------
function inBoundingBox($bBoxWest, $bBoxNorth, $bBoxEast, $bBoxSouth)
{
	// Polygon A (typically a country)
	$polygonA = array(
		array($bBoxWest, $bBoxNorth),
		array($bBoxWest, $bBoxSouth),
		array($bBoxEast, $bBoxSouth),
		array($bBoxEast, $bBoxNorth)
		);
	$polygonAMySQL = polygon_to_mysql($polygonA);
	
	//echo $polygonAMySQL, '<br/>';
	
	// Find studies with linked objects in polygon A
	$insideA = db_get_objects_in_polygon($polygonAMySQL);

	echo '<h3>Inside A</h3>';
	echo '<pre>';
	print_r($insideA);
	echo '</pre>';
	
	// Polgon representing whole world
	$polygonB = array(
		array(-180, 90),
		array(-180, -90),
		array(180, -90),
		array(180, 90)
		);
	$polygonBMySQL = polygon_to_mysql($polygonB);
		
	$within = array();
	$proportion = array();
		
	// Now we know objects that are in this area. What we need now is what fraction of the total
	// number of georeferenced objects this represents.

	// Find how many of A's localities are in polygon
	foreach ($insideA as $k => $v)
	{				
		$within[$k] = $v;
		
		$localities = db_get_objects_in_polygon($polygonBMySQL, '', $k);
		
		$totalLocalities = $localities[$k];
		$fraction = $v / $totalLocalities;
		
		$proportion[$k] = $fraction;
	}
	
	echo '<h3>Objects within A</h3>';
	echo '<pre>';
	print_r($within);
	echo '</pre>';
	echo '<h3>Proportion inside A</h3>';
	echo '<pre>';
	print_r($proportion);
	echo '</pre>';
	
	// Sort
	array_multisort($proportion, SORT_NUMERIC, SORT_DESC, $within, SORT_NUMERIC, SORT_DESC);
	
	// make list
	$list = array();
	foreach ($proportion as $k => $v)
	{
		$list[$k] = array(
			'object_id' => $k,
			'score' => $v
		);
	}
	
	return $list;


/*	echo '<pre>';
	print_r($proportion);
	echo '</pre>';*/
	
	// Compute fraction
	
	// Order
	
}

/*global $_GET;

$id = $_GET['id'];

print_r(overlap($id)); */

// Find objects in polygon

// madagascar
//inBoundingBox(43.2248687744141,-11.9454317092896,50.4837875366211,-25.6089553833008);

// Philiip
/*<bBoxWest>116.931549072266</bBoxWest>
<bBoxNorth>21.1206130981445</bBoxNorth>
<bBoxEast>126.601531982422</bBoxEast>
<bBoxSouth>4.64330530166626</bBoxSouth>*/

//inBoundingBox(116.931549072266,21.1206130981445,126.601531982422,4.64330530166626);





?>
