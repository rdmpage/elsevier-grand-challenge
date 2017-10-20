<?php

require_once('latlong.php');


// Interpret column headers

define(TYPE_UNKNOWN, 						0);
define(TYPE_LATITUDE, 						1);
define(TYPE_LONGITUDE, 						2);
define(TYPE_LATITUDE_LONGITUDE, 			3);
define(TYPE_ALTERNATING_LATITUDE_LONGITUDE, 4);
define(TYPE_VOUCHER, 						5);
define(TYPE_GENBANK, 						6);
define(TYPE_LOCALITY, 						7);

//--------------------------------------------------------------------------------------------------
function list_to_array($str)
{	
	$result = array();
	
	// Standard delimiters
	
	$str = str_replace(",", "|", $str);
	$str = str_replace(";", "|", $str);
	$str = str_replace(". ", "|", $str);
	
	$result = explode("|", $str);
	for ($i = 0; $i < count($result); $i++)
	{
		$result[$i] = trim($result[$i]);
	}
	return $result;
}


//--------------------------------------------------------------------------------------------------
function type_to_str($type)
{
	$str = '';
	
	switch ($type)
	{
		case TYPE_LATITUDE:
			$str = "latitude";
			break;
		case TYPE_LONGITUDE:
			$str = "longitude";
			break;
		case TYPE_LATITUDE_LONGITUDE:
			$str = "latitude-longitude";
			break;
		case TYPE_ALTERNATING_LATITUDE_LONGITUDE:
			$str = "alternating latitude-longitude";
			break;
		case TYPE_VOUCHER:
			$str = "voucher";
			break;
		case TYPE_GENBANK:
			$str = "GenBank";
			break;
		case TYPE_LOCALITY:
			$str = "locality";
			break;
		default:
			$str = '?';
			break;
	}
	return $str;
}
			

//--------------------------------------------------------------------------------------------------
function IsAccessionNumber($str)
{
	$result = false;
	if (preg_match('/([A-Z][A-Z]?[0-9]{6}|NC_[0-9]{6})/', $str))
	{
		$result = true;
	}
	return $result;
}



class TableHeader
{
	var $headers = array();
	var $rows = array();
	var $column_types = array();
	var $column_multipliers = array();
	var $row_parent = array();
	var $caption;
	var $label;
	var $hasHeaderRow;
	
	//----------------------------------------------------------------------------------------------
	function TableHeader($original)
	{
		$this->label = $original->label;
		$this->caption = $original->caption;
		
		// Do we have a header row (version 4.5.2 doesn't)
		$this->hasHeaderRow = false;
		if (isset($original->header[0]))
		{
			$this->hasHeaderRow = true;
			$this->headers[0] = $original->header[0];
		}
				
		// Handle second row of header (bit crude, assumes only 1-2 rows for header)
		if (isset($original->header[1]))
		{
			$r = array();
			$column_counter = 0;
			foreach ($original->header[0] as $h)
			{
				if (preg_match('/{@m(\d+)}$/', $h, $matches))
				{
					//print_r($matches);
					array_push($r, "-");
					// remove '@m';
					$this->headers[0][$column_counter] = preg_replace('/{@m(\d+)}$/', '', $h);
				}
				else
				{
					array_push($r, array_shift($original->header[1]));
				}
				$column_counter++;
			}
			//print_r($r);
			$this->headers[1] = $r;
		}	
		
		//------------------------------------------------------------------------------------------
		// Set column types to unknown
		if ($this->hasHeaderRow)
		{
			for($i = 0; $i < count($this->headers[0]); $i++)
			{
				$this->column_types[$i] = TYPE_UNKNOWN;
				$this->column_multipliers[$i] = 1;
			}
		}
		else
		{
			for($i = 0; $i < count($original->rows[0]); $i++)
			{
				$this->column_types[$i] = TYPE_UNKNOWN;
				$this->column_multipliers[$i] = 1;
			}
		}
		
		// Data
		
		//------------------------------------------------------------------------------------------
		// Create empty array of rows, each of which is an array
		for ($i = 0; $i < count($original->rows); $i++)
		{
			array_push($this->rows, array());
		}
		
		//print_r($this->rows);
		
		$row_counter = 0;
		foreach ($original->rows as $r)
		{
			$this->row_parent[$row_counter] = $row_counter;
			$row_counter++;
		}
		
		// Copy rows
		$this->rows = $original->rows;
		
		// Pad rows by going down each column
		for($i = 0; $i < count($this->headers[0]); $i++)
		{
			for($j = 0; $j < count($this->rows); $j++)
			{
				$cell = $this->rows[$j][$i];
				
				if (preg_match('/{@m(\d+)}$/', $cell, $matches))
				{
					// How many rows down do we pad?
					$morerows = $matches[1];

					// Pad rows
					$start_row = $j+1;
					$end_row = $j+$morerows;
				
					for ($k= $start_row; $k <= $end_row; $k++)
					{
						array_splice($this->rows[$k], $i, 0, "-");
						
						// Store the "parent" row
						$this->row_parent[$k] = $j;
					}
					
					// remove '@m';
					$cell = preg_replace('/{@m(\d+)}$/', '', $cell);
					$this->rows[$j][$i] = $cell;
					
				}
			}
		}
		
		
		
		
		/*
		
		$row_counter = 0;
		foreach ($original->rows as $r)
		{
			
			$column_counter = 0;
			foreach ($r as $cell)
			{
				//echo $cell . " ";

				// Check for columns spanning multiple rows. If so,
				// we need to pad these out. These cases are flagged by
				// '{@m\d+} in the JSON, which corresponds to morerows
				// attribute in XML. I'm assuming that padding is only
				// needed at front of table row. BAD IDEA!!!
				if (preg_match('/{@m(\d+)}$/', $cell, $matches))
				{
					//print_r($matches);
					
					// How many rows down do we pad?
					$morerows = $matches[1];
					
					// Pad rows
					$start_row = $row_counter+1;
					$end_row = $row_counter+$morerows;
					
					for ($i = $start_row; $i <= $end_row; $i++)
					{
						array_push($this->rows[$i], "-");
						
						// Store the "parent" row
						$this->row_parent[$i] = $row_counter;
						
					}
					// remove '@m';
					$cell = preg_replace('/{@m(\d+)}$/', '', $cell);
				}
				// Store data
				array_push($this->rows[$row_counter], $cell);
				
				
				$column_counter++;
			}
			//echo "\n";
			
			$row_counter++;
		}
		
		*/
		
		//print_r($this->rows);
		
				
		
			
	}
	

	
	//----------------------------------------------------------------------------------------------
	function Dump()
	{
		echo "Dump------------------\n";
		echo $this->label . "\n";
		echo $this->caption . "\n";
		echo "Column headings:\n";
		print_r($this->headers);
		echo "Data\n";
		print_r($this->rows);

		echo "Column types:\n";
		foreach ($this->column_types as $c)
		{
			echo type_to_str($c) . "\n";
		}
		foreach ($this->column_multipliers as $c)
		{
			echo $c . "\n";
		}
		//print_r($this->row_parent);
		
	}
	
	//----------------------------------------------------------------------------------------------
	function GetColumnType($i)
	{
		return $this->column_types[$i];
	}
		
	//----------------------------------------------------------------------------------------------
	// Classify column based on heading text
	function ClassifyHeader($h, $column_counter)
	{
		echo "|$h|\n";
		$matches = array();
		
		// Locality
		if (preg_match('/location/i', $h))
		{
			$this->column_types[$column_counter] = TYPE_LOCALITY;
		}
		if (preg_match('/locality/i', $h))
		{
			if (!preg_match('/code/', $h))
			{
				$this->column_types[$column_counter] = TYPE_LOCALITY;
			}
		}
		
		
		// Lat 
		if (preg_match('/^Latitude(\s*\((?<hemisphere>[S|N])\))?$/', $h, $matches))
		{
			if (isset($matches['hemisphere']))
			{
				if ($matches['hemisphere'] == 'S')
				{
					$this->column_multipliers[$column_counter] = -1.0;
				}
			}
					
			$this->column_types[$column_counter] = TYPE_LATITUDE;
			
		}
		// Long
		if (preg_match('/^Longitude(\s*\((?<hemisphere>[W|E])\))?$/', $h, $matches))
		{
			//print_r($matches); 
			if (isset($matches['hemisphere']))
			{
				if ($matches['hemisphere'] == 'W')
				{
					$this->column_multipliers[$column_counter] = -1.0;
					//echo 'boo'; exit();
				}
			}
			$this->column_types[$column_counter] = TYPE_LONGITUDE;
		}
		
		if (preg_match('/Lat(itude)?(\/|,)\s*long(itude)?/i', $h))
		{
			$this->column_types[$column_counter] = TYPE_LATITUDE_LONGITUDE;
		}

		if (preg_match('/^GPS (position|coordinates)/i', $h))
		{
			$this->column_types[$column_counter] = TYPE_LATITUDE_LONGITUDE;
		}
		if (preg_match('/^Coordinates/i', $h))
		{
			$this->column_types[$column_counter] = TYPE_LATITUDE_LONGITUDE;
		}
		

		// Voucher
		if (preg_match('/voucher/i', $h))
		{
			$this->column_types[$column_counter] = TYPE_VOUCHER;
		}
		if (preg_match('/museum/i', $h))
		{
			$this->column_types[$column_counter] = TYPE_VOUCHER;
		}
		if (preg_match('/collection number/i', $h))
		{
			$this->column_types[$column_counter] = TYPE_VOUCHER;
		}
		if (preg_match('/catalog(ue)?/i', $h))
		{
			$this->column_types[$column_counter] = TYPE_VOUCHER;
		}
		if (preg_match('/specimen/i', $h))
		{
			$this->column_types[$column_counter] = TYPE_VOUCHER;
		}
		
		if ($this->column_types[$column_counter] == TYPE_UNKNOWN)
		{
			
			// GenBank
			if (preg_match('/accession/i', $h))
			{
				$this->column_types[$column_counter] = TYPE_GENBANK;
			}	
		}
	}
	
	//----------------------------------------------------------------------------------------------
	function ClassifyColumns()
	{
	
		$column_counter = 0;
		
		if ($this->hasHeaderRow)
		{		
			// Use first row of table
			foreach ($this->headers[0] as $h)
			{
				$this->ClassifyHeader($h, $column_counter);
				$column_counter++;
			}
			
			// Use second row
			$column_counter = 0;
			if (isset($this->headers[1]))
			{
				foreach ($this->headers[1] as $h)
				{
					$this->ClassifyHeader($h, $column_counter);
					$column_counter++;
				}
			}
		}
		else
		{
			// Use first row of table as header row_counter
			foreach ($this->rows[0] as $h)
			{
				$this->ClassifyHeader($h, $column_counter);
				$column_counter++;
			}
			
			
		}
		
		//print_r($this->column_types);
	
	}
	
	//----------------------------------------------------------------------------------------------
	// For each column that we've classified based on the text heading,
	// double check by looking at the data itself
	function CheckColumnClassification()
	{
		echo "---CheckColumnClassification---\n";
		echo "Before:\n";
		print_r($this->column_types);
		
		$column_counter = 0;
		foreach ($this->column_types as $c)
		{
			switch($c)
			{
				case TYPE_LATITUDE_LONGITUDE:
					// Are they really lat/long?
					$n = 10;
					$col = $this->GetFirstNRows($column_counter, $n);
					
					//print_r($col);

					$n = count($col);
					$blank_count = 0;
					$count = 0;
					foreach ($col as $c)
					{
						echo "$c\n";
						if (IsLatLong($c, $loc))
						{
							$count++;
						}
						if ($c == '' || $c == '-')
						{
							$blank_count++;
						}
					}
					
					//echo $count . " " . $blank_count . " n=$n " . ($count + $blank_colums)/$n . "\n";
					//exit();
					
					
					if (($count + $blank_count)/$n  < 0.5)
					{
						// Check whether it is alternating lat/long pairs
						$lat_count = 0;
						$long_count = 0;
						for($i = 0; $i < $n; $i++)
						{
							if (IsLatitude($col[$i], $loc))
							{
								$lat_count++;
							}
							if (IsLongitude($col[$i], $loc))
							{
								$long_count++;
							}
								
						}
						//echo $lat_count . " " . $long_count . "\n";
						
						if ($lat_count/$n > 0.2 && $long_count/$n > 0.2)
						{
							$this->column_types[$column_counter] = TYPE_ALTERNATING_LATITUDE_LONGITUDE;							
						}
						else
						{
							$this->column_types[$column_counter] = TYPE_UNKNOWN;
						}
					}
					break;

				case TYPE_LATITUDE:
				case TYPE_LONGITUDE:
					$n = 10;
					$col = $this->GetFirstNRows($column_counter, $n);
					$n = count($col);
					//print_r($col);
					
					// check data type...
					break;
					
				case TYPE_VOUCHER:
				case TYPE_GENBANK:
					break;
					
				default:
					// Unclassified column
					$n = 10;
					$col = $this->GetFirstNRows($column_counter, $n);
					$n = count($col);
					
					//print_r($col); 
					$count = 0;
					foreach ($col as $c)
					{
						if (IsAccessionNumber($c))
						{
							$count++;
						}
					}
					if ($count/$n > 0.2)
					{
						$this->column_types[$column_counter] = TYPE_GENBANK;
					}
					
					
					// Not GenBank, look for coordinates
					if ($this->column_types[$column_counter] == TYPE_UNKNOWN)
					{
						$latcount = 0;
						$longcount = 0;
						foreach ($col as $c)
						{
							$l = array();
							if (IsLatLong($c, $l))
							{
								//print_r($l);
								if (isset($l['latitude'])) $latcount++;
								if (isset($l['longitude'])) $longcount++;
							}
						}
						//echo "$column_counter n=$n $latcount " . $latcount/$n . "\n";
						if (($latcount/$n > 0.2) && ($longcount/$n > 0.2))
						{
							$this->column_types[$column_counter] = TYPE_LATITUDE_LONGITUDE;
						}
					}
					
					
					
				
					break;
			}
			$column_counter++;
		}
		echo "After:\n";
		print_r($this->column_types);
	
		
	}
	
	//----------------------------------------------------------------------------------------------
	// Return first n rows of a given column
	function GetFirstNRows($column_index, $n=10)
	{
		$c = array();
		$i = 0;
		// ensure we don't overun the end of the table
		$n = min($n, count($this->rows));
		while ($i < $n)
		{
			array_push($c, $this->rows[$i][$column_index]);
			$i++;
		}
		//print_r($c);
		return $c;
	}
	
	//----------------------------------------------------------------------------------------------
	// Return true if table has columns that aren't classified as unknown type
	function HasData()
	{
		$has_data = false;
		
		foreach ($this->column_types as $c)
		{
			if ($c != TYPE_UNKNOWN)
			{
				$has_data = true;
			}
		}
		
		return $has_data;
	}

	
}



?>