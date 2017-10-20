<?php

// Test whether image exists

require_once('../config.inc.php');

function issn_image($issn)
{
	global $config;

	// Possible image extensions
	$extensions = array('gif', 'jpg', 'png', 'jpeg');
	
	// Where we look
	$dir = $config['web_dir'] . 'images/issn';
	$base_name = str_replace('-', '', $issn);
	
	$found = false;
	$filename = '';
	$image_url = '';
	
	foreach ($extensions as $extension)
	{
		$filename = $dir . '/' . $base_name . '.' . $extension;
		if (file_exists($filename))
		{
			$found = true;
			$image_url .= 'images/issn/' . $base_name . '.' . $extension;
			break;
		}
	}
	return $image_url;
}	

?>