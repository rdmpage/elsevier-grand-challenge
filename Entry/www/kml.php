<?php


// $Id:  $

/**
 * @file kml.php
 *
 * @brief Display a pair of latlong co-ordinates on a SVG map
 *
 * The idea is described on my SemAnt blog: http://semant.blogspot.com/2006/11/svg-specimen-maps-from-sparql-results.html
 *
 */
 
require_once('../config.inc.php');
require_once('../eav/eav.php');
require_once('../object_factory.php');
require_once('../query.php');
require_once('../spatial.php');


global $_GET;



$id = $_GET['id'];
$locs = object_localities($id);

$o = object_factory($id);
$o->Retrieve();

$xml = 
'<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://earth.google.com/kml/2.1">
    <Document>
        <name>' . $o->GetTitle() . '</name>
        <open>1</open>
        <description></description>';

$xml .= '<Style id="whiteBall">	       
<IconStyle>
	<Icon>
		<href>http://bioguid.info/images/whiteBall.png</href>
	</Icon>
</IconStyle>
</Style>';

foreach($locs as $p)
{
	$xml .= '<Placemark>';
	$xml .= '<styleUrl>#whiteBall</styleUrl>';
	$xml .= '<name>' . $p['name'] . '</name>';
	
	$o = object_factory($p['object_id']);
	$o->Retrieve();
	
	$description = '<p>' .  $o->GetHtmlSnippet() . '</p>' . '<p>' . '<a href="' . $config['webroot'] . 'uri/' . $p['object_id'] . '">' . 'View record' . '</a></strong>' . '</p>';
	
	$xml .= '<description><![CDATA[' . $description . ']]></description>';
	$xml .= '<Point><extrude>0</extrude><altitudeMode>absolute</altitudeMode>';
	$xml .= '<coordinates>';
	$xml .= $p['xy'][0] . ',' . $p['xy'][1];
	$xml .= '</coordinates>
	</Point>
	</Placemark>';
}

$xml .= '</Document>
</kml>';

	
header('Content-type: application/vnd.google-earth.kml+xml');
header("Content-Disposition: attachment; filename=" . $id . ".kml");

echo $xml;

?>
