<?php

// $Id: //

/**
 * @file config.php
 *
 * Global configuration variables (may be added to by other modules).
 *
 */

global $config;

// Server-------------------------------------------------------------------------------------------
$config['server']   = 'http://iphylo.org';
$config['webroot'] 	= $config['server']  . '/~rpage/challenge/www/';
$config['web_dir']	= dirname(__FILE__) . '/www/';


$config['tmp_dir'] = '/tmp';

// Database-----------------------------------------------------------------------------------------
$config['adodb_dir'] 	= dirname(__FILE__).'/adodb5/adodb.inc.php'; 
$config['db_user'] 	    = 'root';
$config['db_passwd'] 	= '';
$config['db_name'] 	    = 'challenge';

// Default object ids
$config['owner_id']			= md5('rdmpage@gmail.com');

// Graphiz------------------------------------------------------------------------------------------
$config['webdot']		= $config['server'] . '/cgi-bin/neato.cgi';
$config['neato']		= '/usr/local/bin/neato';


// Proxy settings for connecting to the web---------------------------------------------------------

// Set these if you access the web through a proxy server. This
// is necessary if you are going to use external services such
// as PubMed.
$config['proxy_name'] 	= '';
$config['proxy_port'] 	= '';

$config['proxy_name'] 	= 'wwwcache.gla.ac.uk';
$config['proxy_port'] 	= '8080';

// XSLT installation--------------------------------------------------------------------------------

// If your PHP installation has XSLT support built in leave as ''. 
// If not (such as RedHat 8), set to the path to your copy of sabcmd (e.g.,
// '/usr/local/bin/sabcmd'). To get the path, type 
// 'locate sabcmd' at the system prompt.

$config['sabcmd'] 	= '/usr/local/bin/sabcmd';
//$config['sabcmd'] 	= '';


// Web service keys---------------------------------------------------------------------------------
$config['Yahoo_application_id']	= 'iphylobeta';
$config['uBio_key'] 		='b751aac2219cf30bcf3190d607d7c9494d87b77c'; 



	
?>