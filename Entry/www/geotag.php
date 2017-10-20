<?php

// Geotag item using Yahoo...

require_once('../config.inc.php');
require_once('../lib.php');
require_once('../object_factory.php');

function main()
{
	global $config;
	global $db;
	
	$sql = 'SELECT * FROM object
INNER JOIN EAV_String USING(object_id)
LEFT JOIN locality USING (object_id)
WHERE locality.loc IS NULL
AND EAV_String.attribute_id = 71
AND (object.class_id = 9)';
//LIMIT 10';

	$objects = array();

	$result = $db->Execute($sql);
	if ($result == false) die("failed $sql");  
	
	while (!$result->EOF) 
	{
		array_push($objects, $result->fields['object_id']);
		

		$result->MoveNext();
	}
	
	$objects = array_reverse($objects);
	print_r($objects);
	
	
	
	// Compute polygons
	foreach ($objects as $object_id)
	{
		echo "$object_id ";
		
		$o = object_factory($object_id);
		$o->Retrieve();
		
		
		$place = $o->GetAttributeValue('country');
		$loc = $o->GetAttributeValue('locality');
		if ($loc != '')
		{
			$place .= ', ' . $loc;
		}
		
		if ($place != '')
		{	
			echo "$place\n";
		
		
			sleep(10);

			$url = "http://where.yahooapis.com/v1/places.q('" . urlencode($place) . "')?format=json&appid=v5NLgAjV34HJOvOqjnU6HoLlBx_NHrc0P03uYepNniPsN2ZdrEE9zuWUyiNiuuR.LYA-";
			
			echo $url;
			
			$j = get($url);
			
			echo $j;
			
			$o = json_decode($j);
			
			print_r($o);
			
			if (isset($o->places->place))
			{
				$p = $o->places->place[0];
				echo $p->woeid . "\n";
				echo $p->centroid->latitude . "\n";
				echo $p->centroid->longitude . "\n";
				
				// insert
				
				$source_object_id = md5('http://developer.yahoo.com/geo/');
				
				db_store_object_point_locality($object_id, $p->centroid->latitude, $p->centroid->longitude,
	$source_object_id,  -1, md5('rdmpage@gmail.com'), '127.0.0.1', '', $p->woeid);
			}
			

		}
			echo "\n";

	}
}

main();

?>

