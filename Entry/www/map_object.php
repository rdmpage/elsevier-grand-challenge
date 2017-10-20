<?php


// $Id: map.php,v 1.1 2007/03/16 21:37:12 rdmp1c Exp $

/**
 * @file map.php
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


$xml = '<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns:xlink="http://www.w3.org/1999/xlink" 
xmlns="http://www.w3.org/2000/svg" 
width="360px" height="180px">
   <style type="text/css">
      <![CDATA[     
      .region 
      { 
        fill:blue; 
        opacity:0.4; 
        stroke:blue;
      }
      ]]>
   </style>
  <rect id="dot" x="-3" y="-3" width="6" height="6" style="stroke:black; stroke-width:1; fill:white"/>
 <image x="0" y="0" width="360" height="180" xlink:href="' . $config['webroot'] . 'images/mape.png"/>

 <g transform="translate(180,90) scale(1,-1)">';
 
	$just_points = array();
	foreach($locs as $loc)
	{
		array_push($just_points, $loc['xy']);
	}
	// hull

	if (count($just_points) > 2)
	{
		//print_r($just_points);
		$hull = convex_hull($just_points);

		$xml .= '<polygon class="region" points="';
		foreach ($hull as $p)
		{
			$xml .= $p[0] . ',' . $p[1] . ' ';
		}
		$xml .= '" />'; 
	}

 
foreach($locs as $loc)
{

	$xml .= '<a xlink:href="' . $config['webroot'] . 'uri/' . $loc['object_id'] . '" title="' . $loc['name'] . '" target="_parent" >';
	$xml .= '   <use xlink:href="#dot" transform="translate(' . $loc['xy'][0] . ',' . $loc['xy'][1] . ')" />';
	$xml .= '</a>';
}

$xml .= '
      </g>
	</svg>';
	
	
header("Content-type: image/svg+xml");

echo $xml;

?>

