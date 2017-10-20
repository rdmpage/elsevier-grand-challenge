<?php

// Create fulltext index on studies for simple searching

// Build search index

require_once('../query.php');

function main()
{
	global $config;
	global $db;
	
	// Clear table
	$sql = 'DELETE FROM object_text';
	$result = $db->Execute($sql);
	if ($result == false) die("failed $sql");  
	

	$sql = 'SELECT object_id FROM object
	WHERE (class_id = 2)';
	
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
		
		
		$o = object_factory($object_id);
		$o->Retrieve();
		
		
		$text = $o->GetAttributeValue('atitle') . ' ' . $o->GetAttributeValue('abstract');

		echo $text;
		echo "\n";
				
		$sql = 'INSERT INTO object_text(object_id, object_text) VALUES(' . $db->Quote($object_id) . ',' . $db->Quote($text) . ')';
		$result = $db->Execute($sql);
		if ($result == false) die("failed $sql");  
			

	}

	
	

}

main();
	

?>