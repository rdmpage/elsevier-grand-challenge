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

global $_GET;

$lat = 0;
$long = 0;

if (isset($_GET['lat'])) { $lat = $_GET['lat']; }
if (isset($_GET['long'])) { $long = $_GET['long']; }

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns:xlink="http://www.w3.org/1999/xlink" 
xmlns="http://www.w3.org/2000/svg" 
width="360px" height="180px">
  <rect id="dot" x="0" y="0" width="8" height="8" style="stroke:black; stroke-width:1; fill:white"/>
 <image x="0" y="0" width="360" height="180" xlink:href="' . $config['webroot'] . 'images/mape.png"/>

 <g transform="translate(180,90) scale(1,-1)">
    <use xlink:href="#dot" transform="translate(' . $long . ',' . $lat . ')"/>
	</g>
	</svg>';
	
	
header("Content-type: image/svg+xml");

echo $xml;

?>

