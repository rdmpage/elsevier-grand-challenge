<?php

// Add DOIs to database

require_once('../config.inc.php');
require_once('../class_reference.php');
require_once('../lib.php');

$dois=array(
/*'10.1016/j.ympev.2006.10.008',
'10.1080/10635159950173834',*/
/*'10.1016/j.ympev.2008.05.023',*/
//'10.1016/j.ympev.2006.05.026'
//'10.1016/j.ympev.2006.05.017'
//'10.1016/j.ympev.2007.11.011'
//'10.1111/j.1365-294X.2008.03721.x'
'10.1006/mpev.2001.0990'
);

foreach ($dois as $doi)
{

	$url = 'http://bioguid.info/doi/' . $doi . '.json';
	echo $url;
	
	
	$j = get($url);
	
	$o = json_decode($j);

	$j = new Reference();
	$j->SetData($o);
	$j->Dump();
	$j->Store();		
	echo "<br/><b>" . $j->GetObjectId() . "</b>";
}
?>

