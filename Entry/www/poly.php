<?php

// Create polygons for each object so we can do quick spatial queries...

// Build search index

require_once('../query.php');

function main()
{
	global $config;
	global $db;
	
	// Clear table
	$sql = 'DELETE FROM object_polygon';
	$result = $db->Execute($sql);
	if ($result == false) die("failed $sql");  
	
	
	$sql = 'SELECT object_id FROM object
	WHERE (class_id = 2)';
//	LIMIT 100';
	
	$objects = array();

	$result = $db->Execute($sql);
	if ($result == false) die("failed $sql");  
	
	while (!$result->EOF) 
	{
		array_push($objects, $result->fields['object_id']);
		

		$result->MoveNext();
	}
	
	print_r($objects);
	
	
	
	// Compute polygons
	foreach ($objects as $object_id)
	{
		echo "$object_id ";
		
		$polygon = array();
		
		$just_points = array();
		$locs = object_localities($object_id);
		foreach($locs as $loc)
		{
			array_push($just_points, $loc['xy']);
		}
	
		if (count($just_points) > 2)
		{
			$polygon = convex_hull($just_points);
			
			print_r($polygon);
			echo polygon_to_mysql($polygon, true);
			
			$sql = 'INSERT INTO object_polygon(object_id, extent) VALUES(' . $db->Quote($object_id) . ',' . polygon_to_mysql($polygon, true) . ')';
			$result = $db->Execute($sql);
			if ($result == false) die("failed $sql");  
			

		}
		echo "\n";
	}
	
/*	// Compute intersections and scores
	// disable for now...
	foreach ($objects as $object_id)
	{
		echo "$object_id ";


		extent_intersects($object_id);
	}*/

}

main();
	
/*	$object_id = '';
	
	
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


require_once('../query.php');


//$locs = db_object_polygon('4209ae4fb601d583042f3185aec5e4bf');

// spiders with geotagged sequences..
//$locs = db_object_polygon('b2c6e10a0c03aec4f95a156a823c7c4e');

// salamanders from specimens linked to sequences
$id = '16a254c7b1bb1dfcf24dea7c7b7af70c';


// spiders with geotagged sequences..
//$id = 'b2c6e10a0c03aec4f95a156a823c7c4e';

$hull = object_bounding_polygon($id);
echo polygon_to_mysql($hull);*/

?>