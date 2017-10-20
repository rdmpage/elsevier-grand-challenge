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

    foreach ($locs as &$myvalue){ 
        $myvalue=serialize($myvalue); 
    } 
echo '<pre>';
print_r($locs);
echo '</pre>';

    $locs=array_unique($locs); 

    foreach ($locs as &$myvalue){ 
        $myvalue=unserialize($myvalue); 
    } 

echo '<pre>';
print_r($locs);
echo '</pre>';


?>
