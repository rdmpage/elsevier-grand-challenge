<?php

/**
 * @file utils.php
 *
 */

//------------------------------------------------------------------------------
/**
 * @brief Convert a decimal latitude or longitude to deg min sec format
 *
 * @param decimal Latitude or longitude as a decimal number
 *
 * @return Degree format
 */
function decimal_to_degrees($decimal)
{
	$decimal = abs($decimal);
	$degrees = floor($decimal);
	$minutes = floor(60 * ($decimal - $degrees));
	$seconds = round(60 * (60 * ($decimal - $degrees) - $minutes));
	
	// &#176;
	$result = $degrees . '&deg;' . $minutes . '&rsquo;' . $seconds . '&rdquo;';
	return $result;
}

//------------------------------------------------------------------------------
function format_decimal_latlon($latitude, $longitude)
{
	$html = decimal_to_degrees($latitude);
	$html .= ($latitude < 0.0 ? 'S' : 'N');
	$html .= '&nbsp;';
	$html .= decimal_to_degrees($longitude);
	$html .= ($latitude < 0.0 ? 'W' : 'E');
	return $html;
}

//------------------------------------------------------------------------------
// from http://phpsense.com/php/php-word-splitter.html
function word_split($str,$words=15) {
	$arr = preg_split("/[\s]+/", $str,$words+1);
	$arr = array_slice($arr,0,$words);
	return join(' ',$arr);
}	

//------------------------------------------------------------------------------
function trim_text($str, $words=10)
{
	$s = word_split($str, $words);
	if (strlen($s) < strlen($str))
	{
		$s .= '...';
	}
	return $s;
}


 
//------------------------------------------------------------------------------
/**
 * @brief Format an arbitrary date as YYYY-MM-DD
 *
 * @param date A string representation of a date
 *
 * @return Date in YYYY-MM-DD format
 */
function format_date($date)
{
	$formatted_date = '';
	
	// Dates like 2006-8-7T15:47:36.000Z break PHP strtotime, so
	// replace the T with a space.
	$date = preg_replace('/-([0-9]{1,2})T([0-9]{1,2}):/', '-$1 $2:', $date);
	
	if (PHP_VERSION < 5.0)
	{
		if (-1 != strtotime($date))
		{
			$formatted_date = date("Y-m-d", strtotime($date));
		}		
	}
	else
	{
		if (false != strtotime($date))
		{
			$formatted_date = date("Y-m-d", strtotime($date));
		}
	}
	return $formatted_date;
}


//------------------------------------------------------------------------------
/**
 * @brief Extract the year from a date
 *
 * @param date A string representation of a date in YYYY-MM-DD format
 * @return Year in YYYY format
 */
function year_from_date($date)
{
	$year = 'YYYY';
	$matches = array();
	if (preg_match("/([0-9]{4})(\-[0-9]{1,2})?(\-[0-9]{1,2})?/", $date, $matches))
	{
		$year = $matches[1];
	}
	return $year;
}




?>