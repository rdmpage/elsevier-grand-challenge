<?php

require_once('../config.inc.php');

function XSLT_File ($xmlfilename, $xsltfilename, $resultfilename = '', $params = '')
{
	global $config; 
	
	$outputfilename = "";
	
	$parameters = '';
	
	if ($params != '')
	{
		foreach ($params as $key=>$value)
		{
			$parameters .= " \\$" . $key . "=\"" . $value . "\"";
		}
	}

	$id = uniqid ('');
	if ($resultfilename == '')
	{
		$outfilename = $config['tmp_dir'] . "/" . $id . ".out";
	}
	else
	{
		$outfilename = $resultfilename;
	}
	if ($config['sabcmd'] != '')
	{	
		$logfilename = $config['tmp_dir'] . "/" . $id . ".log";
	
		// Transform XML, result written to $outfilename. STDERR redirected to a temporay log file so
		// that we can trap error messages.
		$commandline = $config['sabcmd'] . " $xsltfilename $xmlfilename $parameters 2>$logfilename > $outfilename";
		$return_code = 0;
		$err = system ($commandline, $return_code);
		
		if ($return_code != 0)
		{
			// Get the error message 
			$mylog = @fopen($logfilename, "r") or die("could't open file \"$logfilename\"");
			$msg = @fread($mylog, filesize ($logfilename));
			fclose($mylog);
			return $msg;	
		}	
		
		// Read results from file into xpresult
		// We could capture the output to stdout, but if the output text has line breaks
		// then we need to iterate over the result array
		$myfile = @fopen($outfilename, "r") or die("could't open file \"$outfilename\"");
		$xpresult = @fread($myfile, filesize ($outfilename));
		fclose($myfile);
		
		if ($resultfilename == '')
		{
			return $xpresult;
		}
	}
	else
	{
		// Use PHP extension
		$xpresult = "";
		$xslt_processor = xslt_create();
		$xslt = join ("", file($xsltfilename));
		$xml = join ("", file($xmlfilename));
		$arg_buffer = array("/xml" => $xml, "/xslt" => $xslt);
		$xp = xslt_create() or die ("Could not create XSLT processor");
		if ($xpresult = xslt_process($xp, "arg:/xml", "arg:/xslt", NULL, $arg_buffer, $params))
		{
		}
		else
		{
			$xpresult = "An error occurred: " . xslt_error($xp) . " (error code " . xslt_errno($xp) . ")";
		}
		xslt_free($xp);
		
		return $xpresult;
	}
}

function XSLT_Buffer ($xml, $xsltfilename, $resultfilename = '', $params = '')
{
	
		global $config; 
		
		if ($config['sabcmd'] != '')
		{	
			// Store XML to a temporary disk file
			$xmlfilename = $config['tmp_dir'] . "/" . uniqid ('') . ".xml";
			$myfile = @fopen($xmlfilename, "w+") or die("could't open file \"$xmlfilename\"");
			@fwrite($myfile, $xml);
			fclose($myfile);
			
			return XSLT_File ($xmlfilename, $xsltfilename, $resultfilename, $params);
		}
		else
		{
			$xpresult = "";
			$xslt_processor = xslt_create();
			$xslt = join ("", file($xsltfilename));
			$arg_buffer = array("/xml" => $xml, "/xslt" => $xslt);
			$xp = xslt_create() or die ("Could not create XSLT processor");
			if ($xpresult = xslt_process($xp, "arg:/xml", "arg:/xslt", NULL, $arg_buffer, $params))
			{
				if ($resultfilename != '')
				{
					// Write to temporary file
					$myfile = @fopen($resultfilename, "w+") or die("could't open file \"$resultfilename\"");
					@fwrite($myfile, $xpresult);
					fclose($myfile);
				}
			}
			else
			{
				$xpresult =  "An error occurred: " . xslt_error($xp) . "(error code " . xslt_errno($xp) . ")";
			}
			xslt_free($xp);
			return $xpresult;
		
		}
	
}



?>