<?php

// $Id: $

require_once('../config.inc.php');

function html_html_open()
{
	return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">' 
		. "\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">' . "\n";
}

function html_html_close()
{
	return '</html>';
}

function html_head_open()
{
	global $config;
	
	$html = '<head>' . "\n"
		. '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\n";
		
		
	// Base URL for all links on page
	// This is very useful because we use Apache mod_rewrite extensively, and this ensures
	// image URLs can still be written as relative addresses
	$html .= '<base href="' . $config['webroot'] . '" />' . "\n";
		
		
	$html .= '<style type="text/css">
	
	body 
	{
		background: url(images/gradientbg.png) no-repeat;
		
		padding: 0;
		margin: 0;
		font-family: Arial, Helvetica, Verdana, sans-serif;
		font-size: 14px;
	}
	
	h1
	{
		color: rgb(32,32,32);
		font-size:24px;
	}


	h3
	{
		border-top: 1px dotted rgb(190,190,190);
		color: rgb(32,32,32);
		font-size:16px;
	}

	h4
	{
		color: rgb(32,32,32);
		font-size:14px;
	}
	
	p
	{
		color:rgb(48,48,48);
		font-size:14px;
	}
	
	tbody
	{
		font-size:12px;
	}
	
	.even
	{
		background-color: rgb(240,240,240);
	}
	
		
	
	.explain
	{
		color: rgb(128,128,128);
		font-size:12px;
	}
	
	/* Default for all images. We do this in CSS because
	   border="0" is deprecated in XHTML. Without a 0 width
	   border we get a blue box around images in Firefox and IE */
	img
	{
		border: 0px;
	}
	
	a:link
	{
		color: rgb(64,64,255);
		text-decoration: none;
	}
	
	a:active
	{
		text-decoration: none;	
	}

	a:visited
	{
		text-decoration: none;
	}

	/* Note: a:hover MUST come after a:link and a:visited in the CSS definition in order to be effective!!
	   http://www.w3schools.com/CSS/css_pseudo_classes.asp */
	   
	a:hover
	{
		color: black;
		text-decoration: none;
	}
	
	.search-form {
		font-size:18px;
	}
	
	#logo {
		display:block;
		position: absolute;
		left: 0;
		top: 0;
		width: 100%;
		height: 60px;
		padding: 0;
		margin: 0;
/*		background-color: green; */
		border-bottom: 3px solid rgb(82,169, 212);
	}	


	#main-content-container
	{
		position: absolute;
		width: auto;
		/*min-width:400px; */
		top: 63px;
		left: auto;
		z-index: 2;
	/*	padding: 4px 380px 0px 4px;*/ /* 370 wide */
		padding: 4px 430px 0px 4px; /* 370 wide */
		margin: 0 0 0 0;
	 /*	border: 1px solid blue; */
	}
	
	
	  /* right nav style */
	#rightnav {
		border-left: 1px dotted rgb(190,190,190);
		position: absolute;
		top: 63px;
		right: 0px;
		width: 420px;
		height: auto;
		color: #39392a;
		/*background-color: rgb(240,240,240);*/
/*		font-size: 10px;*/
		margin-left: 10px;
		padding: 4px;
		z-index: 5;
		/*border: 1px solid red; */
	}
	
	.rightnav-box {
		margin:10px;
		background-color:white;
/*		border:4px solid rgb(235, 242, 238);
		-webkit-border-bottom-left-radius: 9px 9px;
		-webkit-border-bottom-right-radius: 9px 9px;
		-webkit-border-top-left-radius: 9px 9px;
		-webkit-border-top-right-radius: 9px 9px;*/
	}

	.rightnavbox-content {
/*		border:1px solid rgb(192, 204,196);
		padding: 4px;
		-webkit-border-bottom-left-radius: 5px 5px;
		-webkit-border-bottom-right-radius: 5px 5px;
		-webkit-border-top-left-radius: 5px 5px;
		-webkit-border-top-right-radius: 5px 5px;*/
	}
	
	/* Fisheye table */
	
	/* Spacer to ensure table cells always at least 100px wide */
	.cell_image_spacer
	{
		margin:0px;
		padding:0px;
		height:1px;
		width:100px;
		/*border:1px solid blue; */
		display:block; /* ensures text appears on next line below image */
	}
	      
      td.fisheye, td.fisheye_data
      {
      	width: 10px;
      	height: 5px;
		border-left: 1px rgb(192,192,192) solid;
		border-top: 1px rgb(192,192,192) solid;      	
      	background-color: white;
      }      

      td.fisheye
      {
      	background-color: white;
      }      
      
      td.fisheye_data 
      {
       	background-color: rgb(181,213,255);
      }

      td.fisheye_header 
      {
      	width:100px;
      	height: 5px;
     	background-color: rgb(240,240,240);
      }

      td.fisheye_selected_header 
      {
      	background-color: rgb(255,192,192);
      }


      td.selected_left_header 
      {
     	 width:100px;
     	 background-color: rgb(228,228,228);
      }
      
      
     td.fisheye_data:hover 
      {
      	color:white;
      	background-color: rgb(90,106,255);
      	cursor:pointer;
      }

	
</style>';	





		
	return $html;
	
}

function html_head_close()
{
	return '</head>' . "\n";
}

function html_body_open()
{
	return '<body>' . "\n";
}

function html_body_close()
{
	return '</body>' . "\n";
}


function html_title($str)
{
	return '<title>' . $str . '</title>' . "\n";
}

// Absolutely vital to write this in the form <script></script>, otherwise
// Firefox breaks badly
function html_include_script($script_path)
{
	global $config;
	return '<script type="text/javascript" src="' . $config['webroot'] . $script_path . '"></script>' . "\n";
}

function html_include_css($css_path)
{
	global $config;
	return '<link type="text/css" href="' . $config['webroot'] . $css_path . '" rel="stylesheet" />' . "\n";
}

function html_image($image_name)
{
	global $config;
//	return '<img border="0" src="' . $config['image_root'] . $image_name . '" />';
	return '<img  src="images/' . $image_name . '" alt="" />';
}

function html_search_box($query = '')
{
	global $config;
	
	// Note use of <div> around <input>, in XHTML we can't have a naked <input> element
	$html = '<form  method="get" action="' . $config['webroot'] . 'search.php" onsubmit="return validateTextSearch(this);">
		<div >
		<input  class="search-form" name="q" type="text" size="20" value="' . $query . '"/>
		<input  class="search-form" name="submit" type="submit" value="Search" />
		</div>
	</form>';
	
	return $html;
}


function html_top($query = '')
{
	global $config;
	
	$html = '<div id="logo">';
	$html .= '<div style="float:left;padding:4px;font-size:24px;"><a href="' . $config['webroot'] . '">Challenge demo</a><br/>';
	$html .= '<span style="font-size:12px"><a href="http://iphylo.blogspot.com/search?q=challenge" target="_new">Blog</a>&nbsp;|&nbsp;<a href="http://www.elseviergrandchallenge.com/" target="_new">Challenge web site</a></span>';
	$html .= '</div>';
	$html .= '<div style="float:right;padding:4px;margin-top:5px;">';
	$html .= html_search_box($query);
	$html .= '</div>';
	$html .= '</div>';
	return $html;
}

?>