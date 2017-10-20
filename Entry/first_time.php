<?php

require_once('eav/eav.php');
//require_once('class_object.php');
//require_once('class_reference.php');


// eav test

db_object_insert(
	md5('rdmpage@gmail.com'),
	1,
	'rdmpage',
	'',
	md5('rdmpage@gmail.com'),
	'127.0.0.1',
	'Root user');
	
// Yahoo Geo service
db_object_insert(
	md5('http://developer.yahoo.com/geo/'),
	1,
	'Yahoo! GeoPlanet',
	'',
	md5('http://developer.yahoo.com/geo/'),
	'127.0.0.1',
	'Root user');	
	
?>