<?php

// HTML snippet

require_once('../config.inc.php');
require_once('../object_factory.php');



function main()
{
	global $config;
	
	$object_id = '';
	if (isset($_GET['id']))
	{
		$object_id = $_GET['id'];
	}
	else
	{
		echo 'No id';
		exit();
	}
	
	$o = object_factory($object_id);
	$o->Retrieve();
	
	// snippet...
	
	
	$snip = new stdClass;
	
	$snip->html = $o->GetHtmlSnippet();
	$snip->object_id = $object_id;
	
	header("Content-type: text/plain; charset=utf-8\n\n");
	echo 'snippet(' . json_encode($snip) . ')';
	


}

main();

?>

