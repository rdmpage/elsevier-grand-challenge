<?php

// Process Elsevier XML and store objects in Database
//
// Note use of my old XSLT functions, as PHP 5's inbuilt XSLT functions couldn't cope

require_once('class_table.php');
require_once('specimen_codes.php');
require_once('../lib.php');
require_once('xslt.php');

// EAV classes
require_once('../class_object.php');
require_once('../class_genbank.php');
require_once('../class_locality.php');
require_once('../class_reference.php');
require_once('../class_specimen.php');
require_once('../class_tag.php');


// Global settings
//$gUseOpenurl = false;
$gUseOpenurl = true;

// From http://uk3.php.net/function.opendir
// archipel dot gb at online dot fr
// 22-Jun-2008 06:20
function listFiles( $from = '.', $filter = '')
{
    if(! is_dir($from))
        return false;
    
    $files = array();
    $dirs = array( $from);
    while( NULL !== ($dir = array_pop( $dirs)))
    {
        if( $dh = opendir($dir))
        {
            while( false !== ($file = readdir($dh)))
            {
                if( $file == '.' || $file == '..')
                    continue;
                $path = $dir . '/' . $file;
                if( is_dir($path))
                    $dirs[] = $path;
                else
                {
                	if ($filter == '')
                	{
                    	$files[] = $path;
                    }
                    else
                    {
                    	if (preg_match("/$filter$/", $path))
                    	{
                    		$files[] = $path;
                    	}
                    }
                }
            }
            closedir($dh);
        }
    }
    return $files;
}

	class ImportObject
	{
		var $data;
		var $item = array();
		var $output;
		
		function ImportObject($data)
		{
			$this->data = $data;
			$this->output = new stdclass;
			$this->output->doi = $this->data->doi;
			
			$this->output->authors = $this->data->authors;
			$this->output->abstract = $this->data->abstract;
			
			
			// Keywords
			$this->output->keywords = $this->data->keywords;
			
	
			// Coordinates
			$this->output->coordinates = array();
	
			// Localities
			$this->output->localities = array();
			
			// Coordinates of localities
			$this->output->locality_coordinates = array();
			
	
			// Accessions
			$this->output->accessions = array();
	
			// Coordinates of sequences
			$this->output->accession_coordinates = array();
	
			// Localities of sequences
			$this->output->accession_localities = array();
	
			// Vouchers
			$this->output->vouchers = array();
	
			// Coordinates of vouchers
			$this->output->voucher_coordinates = array();
	
			// Localities of vouchers
			$this->output->voucher_localities = array();
	
			// Cited literature that exists online
			$this->output->cites = array();
	
		}
		
		function Dump()
		{
			print_r($this->data);
		}
		
		function Process()
		{
			$this->DoBibliography();
			$this->DoTables();
		}
		
		function Export()
		{
			
			// Localities mentioned, but not linked to a sequence or specimen
			
			
			
			print_r($this->output);
			//echo json_encode($this->output);
			
			return $this->output;
		}
		
		
		function DoBibliography()
		{
			global $gUseOpenurl;
		
		
			// Handle bibliography
			foreach ($this->data->bibliography as $bibitem)
			{
				// OpenURL
				if (isset($bibitem->genre))
				{
				
					$url = '?genre=' . $bibitem->genre;
					
					switch ($bibitem->genre)
					{
						case 'article':
							$url .= '&date=' . $bibitem->date;
							$url .= '&volume=' . $bibitem->volume;
							$url .= '&spage=' . $bibitem->spage;
							$url .= '&title=' . urlencode($bibitem->title);
							break;
							
						case 'book':
							$url .= '&date=' . $bibitem->date;
							$url .= '&pub=' . $bibitem->publisher;
							$url .= '&place=' . $bibitem->publoc;
							$url .= '&title=' . urlencode($bibitem->atitle);
							
							if (isset($bibitem->authors[0]))
							{
								$url .= '&aulast=' . urlencode($bibitem->authors[0]->surname);
								$url .= '&aufirst=' . urlencode($bibitem->authors[0]->forename);
							}							
							break;
	
						case 'bookitem':
							$url .= '&date=' . $bibitem->date;
							$url .= '&pub=' . $bibitem->publisher;
							$url .= '&place=' . $bibitem->publoc;
							$url .= '&atitle=' . urlencode($bibitem->atitle);
							$url .= '&title=' . urlencode($bibitem->title);
							$url .= '&spage=' . $bibitem->spage;
							if (isset($bibitem->authors[0]))
							{
								$url .= '&aulast=' . urlencode($bibitem->authors[0]->surname);
								$url .= '&aufirst=' . urlencode($bibitem->authors[0]->forename);
							}
							break;
						
							
						default:
							break;
					}
					
					$bibitem->openurl = $url;
					
					
					echo $url . "\n";
					
					
					// Do OpenURL call here
					if ($gUseOpenurl)
					{
					$j = get('http://bioguid.info/openurl/' . $url . '&display=json');
					
					$ref = json_decode($j);
					
					if ($ref->status == 'ok')
					{
						if (isset($ref->doi))
						{
							echo $ref->doi;
							
							array_push($this->output->cites, 'doi:' . $ref->doi);
						}
						elseif (isset($ref->pmid))
						{
							echo $ref->pmid;
							
							array_push($this->output->cites, 'pmid:' . $ref->pmid);
						}
						elseif (isset($ref->hdl))
						{
							echo $ref->pmid;
							
							array_push($this->output->cites, 'hdl:' . $ref->hdl);
						}
						elseif (isset($ref->url))
						{
							echo $ref->url;
							
							array_push($this->output->cites, $ref->url);
						}
						echo "\n";
					}
					else
					{
						echo $url . "\n";
						echo "-\n";
					}
					//echo $j . "\n"; 
					}
	
	
				}
			}	
			print_r($this->data->bibliography);
		
		
		}
		
		//--------------------------------------------------------------------------------------------------
		// Handle data in tables
		function DoTables()
		{
			foreach ($this->data->tables as $table)
			{
				if (isset($table->rows))
				{
				
					$has_latlong = false;
					
					$h = new TableHeader($table); 
					
					// Classify column headings
					$h->ClassifyColumns();
					
					// Check classification based on looking at the column data
					$h->CheckColumnClassification();
									
					// If we have our desired data types, process and store
					if ($h->HasData())
					{
						// Dump	
						$h->Dump();
						
						$this->item = array();
						for ($i = 0; $i < count($h->rows); $i++)
						{
							//echo "$i $has_latlong\n";
						
						
							$j = $h->row_parent[$i];
							if ($j == $i)
							{
								$this->item[$j] = new stdClass;
								$this->item[$j]->accessions = array();
								$this->item[$j]->voucher = array();
							}
						
							$column_counter = 0;
							foreach ($h->rows[$i] as $c)
							{
								//echo "$i $j $c\n";
								
								
								if ($h->column_types[$column_counter] == TYPE_GENBANK)
								{
									if (IsAccessionNumber($c))
									{
										// may have > 1 on a list
										$acc = list_to_array($c);
										foreach ($acc as $a)
										{
											if ($a != '')
											{
												// Clean up
												$a = preg_replace('/([0-9])[a-z]$/', "\\1", $a);
												$a = preg_replace('/([0-9])\*$/', "\\1", $a);
												$a = preg_replace('/([0-9])\(\d+\)\*?$/', "\\1", $a);
												array_push($this->item[$j]->accessions, $a);
											}
										}
										
									}
								}
					
								
								if	($h->column_types[$column_counter] == TYPE_LATITUDE_LONGITUDE)
								{
									
									$loc = array();
									if (IsLatLong($c, $loc))
									{
										$this->item[$j]->latitude = $loc['latitude'];
										$this->item[$j]->longitude = $loc['longitude'];
										$has_latlong = true;
									}
								}
								
								if	($h->column_types[$column_counter] == TYPE_ALTERNATING_LATITUDE_LONGITUDE)
								{
					
									if (IsLatitude($c, $latitude))
									{
										$this->item[$j]->latitude = $latitude;
										$has_latlong = true;
									}
								}
					
								if	($h->column_types[$column_counter] == TYPE_ALTERNATING_LATITUDE_LONGITUDE)
								{
					
									if (IsLongitude($c, $longitude))
									{
										$this->item[$j]->longitude = $longitude;
										$has_latlong = true;
									}
								}
								
						
								if	($h->column_types[$column_counter] == TYPE_LATITUDE)
								{				
									if (IsLatitude($c, $latitude))
									{
										$this->item[$j]->latitude = $latitude;
										$has_latlong = true;
									}
									else if (is_numeric($c))
									{
										$this->item[$j]->latitude = $c * $h->column_multipliers[$column_counter];
										$has_latlong = true;
									}
								}
						
								if	($h->column_types[$column_counter] == TYPE_LONGITUDE)
								{
									
					
									if (IsLongitude($c, $longitude))
									{
										$this->item[$j]->longitude = $longitude;
										$has_latlong = true;
									}
									else if (is_numeric($c))
									{
										$this->item[$j]->longitude = $c  * $h->column_multipliers[$column_counter];
										$has_latlong = true;
									}
								}
						
								if	($h->column_types[$column_counter] == TYPE_VOUCHER)
								{
									$voucher = list_to_array($c);
									foreach ($voucher as $v)
									{
										// Clean up
										switch ($v)
										{
											case 'n/a':
											case '':
											case '-':
											case 'No Voucher':
											case 'Specimen ID #':
												break;
												
											default:
												$v = preg_replace('/([0-9])\*$/', "\\1", $v);
												array_push($this->item[$j]->voucher, $v);
												break;
										}
									}
								}
								
								if ($h->column_types[$column_counter] == TYPE_LOCALITY)
								{
									// clean
									$c = preg_replace('/\(\d+\)\s*/', '', $c);
									$c = preg_replace('/^\-$/', '', $c);
					
									if ($c != '')
									{
										$this->item[$j]->locality =  $c;
										
										// There might be lats and longs in here
										$loc = array();
										if (IsLatLong($c, $loc))
										{
											if (!isset($this->item[$j]->latitude) && !isset($this->item[$j]->longitude))
											{
												$has_latlong = true;
												$this->item[$j]->latitude = $loc['latitude'];
												$this->item[$j]->longitude = $loc['longitude'];
											}
										}
										
										
									}
								}
								
								
								$column_counter++;
							}
						}
						
						print_r($this->item);
						
						echo "boo\n";
						echo "has_latlong $has_latlong\n";
						
						// Accessions
						foreach ($this->item as $item)
						{
							if (count($item->accessions) > 0)
							{
								foreach ($item->accessions as $a)
								{
									array_push($this->output->accessions, $a);
								}
							}
						}					
	
						// Vouchers
						foreach ($this->item as $item)
						{
							if (count($item->voucher) > 0)
							{
								foreach ($item->voucher as $a)
								{
									array_push($this->output->vouchers, $a);
									
									// link to sequence..? possibly erroneous if multiple sequences of different ages
									// obtained from different labs.
								}
							}
						}					
	
						
						// Coordinates
						if ($has_latlong)
						{
							foreach ($this->item as $item)
							{
								if (isset($item->latitude) && isset($item->longitude))
								{
									// Do we have a voucher or accession?
									if (count($item->voucher) == 0
										and count($item->accessions) == 0)
									{
										// OK, just a naked pair of coordinates, store them
										array_push($this->output->coordinates, 
											array('latitude' => $item->latitude,
												'longitude' => $item->longitude)
											);
											
										// are they linked to a locality?
										if (isset($item->locality))
										{
											$this->output->locality_coordinates[$item->locality] = array('latitude' => $item->latitude,
												'longitude' => $item->longitude);
										}
										array_push($this->output->localities, $item->locality);
											
										
									}
									
									if (count($item->accessions) > 0)
									{
										foreach ($item->accessions as $a)
										{
											$this->output->accession_coordinates[$a] = array('latitude' => $item->latitude,
												'longitude' => $item->longitude);
										}
									}
	
									
									if (count($item->voucher) > 0)
									{
										foreach ($item->voucher as $a)
										{
											$this->output->voucher_coordinates[$a] = array('latitude' => $item->latitude,
												'longitude' => $item->longitude);
										}
									}
								}
								else
								{
									// This item doesn't have lat long (but others do), so store raw localities
									
									if (isset($item->locality))
									{
										// Do we have a voucher or accession?
										if (count($item->voucher) == 0
											and count($item->accessions) == 0)
										{
											// OK, just a naked locality 
											array_push($this->output->localities, $item->locality);
										}
										
										if (count($item->voucher) > 0)
										{
											foreach ($item->voucher as $a)
											{
												$this->output->voucher_localities[$a] = $item->locality;
											}
										}
										if (count($item->accessions) > 0)
										{
											foreach ($item->accessions as $a)
											{
												$this->output->accession_localities[$a] = $item->locality;
											}
										}
									}
								}
							}
						}
						else
						{
							// maybe we have text description of localities?
							foreach ($this->item as $item)
							{
								if (isset($item->locality))
								{
	/*								// Do we have a voucher or accession?
									if (count($item->voucher) == 0
										and count($item->accessions) == 0)
									{*/
										// OK, just a naked locality 
										array_push($this->output->localities, $item->locality);
		//							}
									
									
										if (count($item->voucher) > 0)
										{
											foreach ($item->voucher as $a)
											{
												$this->output->voucher_localities[$a] = $item->locality;
											}
										}
										if (count($item->accessions) > 0)
										{
											foreach ($item->accessions as $a)
											{
												$this->output->accession_localities[$a] = $item->locality;
											}
										}
									
									
									
									
									
								}
							}
						}
					}
				}
			}
		}
		
		
	}




//$list = listFiles('/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370C', 'main.xml');
//$list = listFiles('/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370B', 'main.xml');
//$list = listFiles('/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370A', 'main.xml');
$list = listFiles('/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369F', 'main.xml');


print_r($list);

// NEED to check for DOI!!!!

// Import
foreach ($list as $filename)
{
	
/*	$filename = "/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370C/10557903/00450003/07002680/main.xml";
	
	// lice
	$filename ='/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370C/10557903/00450003/07003144/main.xml';
	
	
	$filename='/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370C/10557903/00450003/07003284/main.xml';
	
	// aussie frog
	// why no lats and longs?
	//$filename ='/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370C/10557903/00450002/0700200X/main.xml';
	
	// gammarus
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370C/10557903/00450002/07002096/main.xml';
	
	// list of localities
	//$filename = "/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370C/10557903/00450002/07002692/main.xml";
	
	// catfish
	$filename = "/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370C/10557903/00450001/07000577/main.xml";
	
	// Oophaga pumilio frog [geotagged genbank]
	//$filename = "/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370C/10557903/00450002/07002138/main.xml";
	
	//$filename = "/users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370C/10557903/00450001/07002059/main.xml";
	//$filename = "/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370A/10557903/00430001/06003897/main.xml";
	
	
	//$filename = "/users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369A/LAB0369A/10557903/00260002/02003251/main.xml";
	
	// ice fish
	//$filename = "/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369B/LAB0369B/10557903/00280001/03000290/main.xml";
	
	//$filename = "/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369C/LAB0369C/10557903/00270003/03000253/main.xml";
	
	// burbot (no accessions)
	//$filename = "/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369B/LAB0369B/10557903/00290003/03001337/main.xml";
	
	// birds shake rattle roll
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369B/LAB0369B/10557903/00310001/03002598/main.xml';
	
	// Pseudacris
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370B/10557903/00440003/07001285/main.xml';
	
	// western Pseudacris
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369E/LAB0369E/10557903/00390002/0500357X/main.xml';
	
	// Turkey
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370A/10557903/00430003/07000176/main.xml';
	
	// Yucca
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370A/10557903/00430002/06005045/main.xml';
	
	// localities
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369E/LAB0369E/10557903/00400003/05003647/main.xml';
	
	// Moth (coordinates)
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369C/LAB0369C/10557903/00310002/03003506/main.xml';
	
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369A/LAB0369A/10557903/00260003/02003639/main.xml';
	
	// New Caledonia skinks
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370A/10557903/00430003/07000280/main.xml';
	
	// Baikal
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369D/LAB0369D/10557903/00350002/0500031X/main.xml';
	
	// limbless skinks
	// note this isn't in PubMed, so we link to sequence via OpenURL resolver
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369B/LAB0369B/10557903/00290003/03001428/main.xml';
	
	// extinct skinks
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369E/LAB0369E/10557903/00390002/05004185/main.xml';
	
	//$filename='/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369D/LAB0369D/10557903/00370003/05001685/main.xml';
	
	// bats
	// Museum specimens
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369C/LAB0369C/10557903/00330003/04002088/main.xml';
	
	// shrews (needs much work on parsing)
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369D/LAB0369D/10557903/00350003/05000060/main.xml';
	
	// frogs
	//$filename ='/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370B/10557903/00440002/07000152/main.xml';
	
	// ron frogs
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369E/LAB0369E/10557903/00390002/05004057/main.xml';
	
	// gecko
	//$filename ='/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369C/LAB0369C/10557903/00340002/04003252/main.xml';
	
	// Crawford
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369D/LAB0369D/10557903/00350003/05000746/main.xml';
	
	// mole rats
	// has lat-lon, but in separate colums with S and E in header
	// has GenBank error
	//$filename = '/users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370C/10557903/00450001/0700108X/main.xml';
	
	// turtles
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370C/10557903/00450001/0700142X/main.xml';
	
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369F/LAB0369F/10557903/00410002/06001825/main.xml';
	
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369E/LAB0369E/10557903/00390001/05002514/main.xml';
	
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369D/LAB0369D/10557903/00380001/05002460/main.xml';
	
	// Philoceanus
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369B/LAB0369B/10557903/00300003/03002276/main.xml';
	
	// Banza
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369E/LAB0369E/10557903/00410001/06001382/main.xml';
	
	// flies
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0370A/10557903/00420003/06005070/main.xml';
	
	
	// squid
	$filename ='/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369D/LAB0369D/10557903/00360001/04003963/main.xml';
	
	
	$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369D/LAB0369D/10557903/00360001/05000722/main.xml';
	
	$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369D/LAB0369D/10557903/00360001/05000916/main.xml';
	
	// wasps
	$filename='/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369B/LAB0369B/10557903/00310001/03002823/main.xml';
	
	// fish china
	$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369B/LAB0369B/10557903/00310001/03002756/main.xml';
	
	// amphipods
	$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369B/LAB0369B/10557903/00310001/03002914/main.xml';
	
	// ice crawlers
	$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369E/LAB0369E/10557903/00410001/06001485/main.xml';
	
	$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369B/LAB0369B/10557903/00320003/04000764/main.xml';
	
	// more ice fish (no accessions)
	$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369B/LAB0369B/10557903/00320003/04000387/main.xml';
	
	// Hyla
	$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369B/LAB0369B/10557903/00320003/04001058/main.xml';
	
	// Curcuio (Joseph)
	$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369A/LAB0369A/10557903/00320002/04000703/main.xml';
	
	// squid
	$filename = '/users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369F/LAB0369F/10557903/00410002/06001849/main.xml';
	
	// hawaii spiders
	$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369F/LAB0369F/10557903/00410002/06001862/main.xml';
	
	
	// shrimps
	$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369B/LAB0369B/10557903/00300003/03002525/main.xml';
	
	// crustacea
	$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369B/LAB0369B/10557903/00300003/03003105/main.xml';
	
	//$filename = '/users/rpage/desktop/492d98a3d8e9c.xml';
	
	// Banza
	//$filename = '/Users/rpage/Desktop/GrandChallenge/Data/DVD/LAB0369E/LAB0369E/10557903/00410001/06001382/main.xml';
	*/
	//--------------------------------------------------------------------------------------------------
	// Read XML
	//
	// We replace line breaks, add entities and namespaces.
	//
	
	
	$xmlfile = @fopen($filename, "a+") or die("could't open file --\"$filename\"");
	$xml = fread($xmlfile, filesize($filename));
	fclose($xmlfile);
	
	// Remove line breaks as this will bugger json
	$xml = str_replace ("\n", "", $xml);
	$xml = str_replace ("\r", "", $xml);
	
	//echo $xml;
	
	// Fix xml
	
	// Add entities
	$xml = str_replace(
	"<!ENTITY gr1", 
	"<!ENTITY mdash  \"-\" >
	<!ENTITY ndash  \"-\" >
	<!ENTITY deg \"°\" >
	<!ENTITY prime  \"'\" >
	<!ENTITY Prime  '\"' >
	<!ENTITY plusmn  \"±\" >
	<!ENTITY minus \"-\" >
	
	<!ENTITY ldquo \"“\" >
	<!ENTITY rdquo \"”\" >
	<!ENTITY pi \"π\" >
	<!ENTITY rsquo \"’\" >
	<!ENTITY lsquo \"‘\" >
	<!ENTITY times \"×\" >
	<!ENTITY ouml \"ö\" >
	<!ENTITY oacute \"ó\" >
	<!ENTITY midast \"-\" >
	<!ENTITY eacute \"é\" >
	<!ENTITY aacute \"á\" >
	<!ENTITY uuml \"ü\" >
	<!ENTITY aelig \"æ\" >
	<!ENTITY ocirc \"ô\" >
	<!ENTITY midast \"*\" >
	
	<!ENTITY ntilde \"ñ\" >
	<!ENTITY auml \"ä\" >
	<!ENTITY mu \"μ\" >
	<!ENTITY lowast \"*\" >
	
	<!ENTITY chi \"χ\" >
	<!ENTITY Gamma \"Γ\" >
	
	<!ENTITY iacute \"í\" >
	<!ENTITY rarr \"→\" >
	<!ENTITY uacute \"ú\" >
	<!ENTITY ccedil \"ç\" >
	<!ENTITY atilde \"ã\" >
	<!ENTITY ecirc \"ê\" >
	<!ENTITY egrave \"è\" >
	<!ENTITY acirc \"â\" >
	<!ENTITY iacute \"í\" >
	
	<!ENTITY scedil \"ş\" >
	
	<!ENTITY gbreve \"ğ\" >
	<!ENTITY inodot \"ı\" >
	
	
	
	<!ENTITY Idot \"İ\" >
	<!ENTITY Ccedil \"Ç\" >
	<!ENTITY Ouml \"Ö\" >
	
	
	<!ENTITY gr1", 
	$xml);
	
	// Add namespaces
	$xml = str_replace("xml:lang=\"en\"", "xml:lang=\"en\" xmlns:ce='http://www.elsevier.com/ce' xmlns:sb='http://www.elsevier.com/sb' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:mml = 'www.w3.org/1998/Math/MathML/'", $xml);
	
	// 4.5.2
	$xml = str_replace("<converted-article version=\"4.5.2\" docsubtype=\"fla\">", "<converted-article version=\"4.5.2\" docsubtype=\"fla\" xml:lang=\"en\" xmlns:ce='http://www.elsevier.com/ce' xmlns:sb='http://www.elsevier.com/sb' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:mml = 'www.w3.org/1998/Math/MathML/' >", $xml);
	
	// sco ????? WTF
	$xml = str_replace("<converted-article version=\"4.5.2\" docsubtype=\"sco\">", "<converted-article version=\"4.5.2\" docsubtype=\"sco\" xml:lang=\"en\" xmlns:ce='http://www.elsevier.com/ce' xmlns:sb='http://www.elsevier.com/sb' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:mml = 'www.w3.org/1998/Math/MathML/' >", $xml);
	
	
	//echo $xml;
	//exit();
	
	//exit();
	
	//--------------------------------------------------------------------------------------------------
	// Transform to JSON for easier processing
	$xslt_file = 'xsl/xml2json.xsl';
	$json = XSLT_Buffer ($xml, $xslt_file);
	
	//echo $json;
	//exit();
	
	//--------------------------------------------------------------------------------------------------
	// Create object from json
	// 
	// This object is the one we will store in the Database
	//
	
	
	$n = new ImportObject(json_decode($json));
	//$n->Dump();
	$n->Process();
	print_r($data);
	
	$data =  $n->Export();
	print_r($data);
	//exit();
	
	//--------------------------------------------------------------------------------------------------
	// now we populate EAV
	
	$ref_id = '';
	
	// 1. 
	// Get bibliographic details for reference from bioGUID, and add anything from Elsevier, then
	// store
	
	
	$doi = $data->doi;
	$url = "http://bioguid.info/doi/" . $doi . "&display=json";
	$j = get($url);
	
	$d = json_decode($j);
	
	if (isset($data->keywords))
	{
		$d->keywords = $data->keywords;
	}
	if (isset($data->abstract))
	{
		$d->abstract = $data->abstract;
	}
	
	//print_r($d);
	
	
	$o = new Reference();
	$o->SetData($d);
	$o->Store();
	$ref_id = $o->GetObjectId();
	
	echo "$ref_id\n";
	
	//exit();
	
	//--------------------------------------------------------------------------------------------------
	if(1)
	{
		// 2.
		// Store citation links 
		foreach ($data->cites as $c)
		{
			$cite_id = '';
			$url = "";
			
			if (preg_match('/^doi:(.*)$/', $c, $match))
			{
				print_r($match);
				
				$cite_id = db_find_object_with_guid('doi', $match[1]);
				if ($cite_id == '')
				{
					$url = "http://bioguid.info/doi/" . $match[1] . "&display=json";
				}
			}
			
			if (preg_match('/^hdl:(.*)$/', $c, $match))
			{
				print_r($match);
				$cite_id = db_find_object_with_guid('hdl', $match[1]);
				if ($cite_id == '')
				{
					$url = "http://bioguid.info/hdl/" . $match[1] . "&display=json";
				}
			}
			
			if (preg_match('/^pmid:(.*)$/', $c, $match))
			{
				print_r($match);
				$cite_id = db_find_object_with_guid('pmid', $match[1]);
				if ($cite_id == '')
				{
					$url = "http://bioguid.info/pmid/" . $match[1] . "&display=json";
				}
			}
			
			if (preg_match('/^http:\/\/(.*)$/', $c, $match))
			{
				print_r($match);
				$cite_id = db_find_object_with_guid('url', $c);
				if ($cite_id == '')
				{
					$url = "http://bioguid.info/openurl/?id=" . $c . "&display=json";
				}
			}
			
			
			// We either have a $cite_id or we're going to lookup an identifier at bioguid.info
			
			if ($url != '')
			{
				$j = get($url);
				$d = json_decode($j);
				if ($d->status == 'ok')
				{
					$o = new Reference();
					$o->SetData($d);
					$o->Store();
					$cite_id = $o->GetObjectId();
				}
			}
			echo "cite_id=$cite_id\n";
			
			
			
			// Links paper --references--> paper
			if ($cite_id != '')
			{
				echo "$ref_id - $cite_id - " . RELATION_REFERENCES . "\n";
				// link 
				db_link_objects(
					$ref_id,
					$cite_id, 
					RELATION_REFERENCES);
			}
		
		}
			
	}
	
	$code2object_id = array();
	
	
	//--------------------------------------------------------------------------------------------------
	if (1)
	{
		// Get sequences and store those, linking to paper
		$groups = array();
		foreach ($data->accessions as $c)
		{
			echo $c . ' ';
			
			// clean
			$c = preg_replace('/[a-z]*$/', '', $c);
			
			$seq_id = '';
			
			$seq_id = db_find_object_with_guid('genbank', $c);
			if ($seq_id == '')
			{
				$url = "http://bioguid.info/genbank/" . $c . "&display=json";
				$j = get($url);
				$d = json_decode($j);
				
				echo $j;
				
				if (isset($d->accession))
				{
					// got it
					
					
					// to avoid major issues with references (such as MBE) having
					// PMID identifiers but already being in bioGUID's OpenURL resolver
					// we need to populate bibliographic references a little more.
					// I've moved this to bioGUID, but to handle previously scrapped sequences
					// we need it here as well.
					
					// Note the issue here is one of timing -- I may encounter a minimally populated
					// reference in a GenBank record before it makes it's way into my OpenURL resolver.
					// The current bioGUID code 
					
					foreach ($d->references as $ref)
					{
						if (isset($ref->pmid))
						{
							if (!isset($ref->issn))
							{
								// go fetch
								$url = "http://bioguid.info/pmid/" . $ref->pmid . ".json";
								$jref = get($url);
								$dref = json_decode($jref);
								if ($dref->status = 'ok')
								{
									if (isset($dref->doi))
									{
										$ref->doi = $dref->doi;
									}
									if (isset($dref->hdl))
									{
										$ref->hdl = $dref->hdl;
									}
									if (isset($dref->url))
									{
										$ref->url = $dref->url;
									}
									
									// metadata to detect identical papers
									if (isset($dref->issn))
									{
										$ref->issn = $dref->issn;
									}
									if (isset($dref->spage))
									{
										$ref->spage = $dref->spage;
									}
									if (isset($dref->volume))
									{
										$ref->volume = $dref->volume;
									}
									if (isset($dref->epage))
									{
										$ref->epage = $dref->epage;
									}
									if (isset($dref->abstract))
									{
										$ref->abstract = $dref->abstract;
									}
									if (isset($dref->issue))
									{
										$ref->issue = $dref->issue;
									}
									if (isset($dref->year))
									{
										$ref->year = $dref->year;
									}
									if (isset($dref->title))
									{
										$ref->title = $dref->title;
									}
	
								}
							}
						}
					}
								
					
					
					
					
					$o = new Genbank();
					$o->SetData($d);
					$o->Store();
					$seq_id = $o->GetObjectId();
					
					$code2object_id[$c] = $seq_id;
					
					// Keep track of taxonomic group for specimen lookup...
					if (isset($d->taxonomic_group))
					{
						$g = $d->taxonomic_group;
						
						if (array_key_exists($g, $groups))
						{
							$groups[$g]++;
						}
						else
						{
							$groups[$g] = 0;
						}
					}
					
					
				}
			}
			else
			{
				$code2object_id[$c] = $seq_id;
			
			
				// Keep track of taxonomic group for specimen lookup...
				$a = db_attribute_from_name(CLASS_GENBANK, 'taxonomic_group');
				$taxonomic_group = db_retrieve_current_attribute_value($seq_id, $a['datatype'], 
					$a['id']);
				if ($taxonomic_group != '')
				{
					if (array_key_exists($taxonomic_group, $groups))
					{
						$groups[$taxonomic_group]++;
					}
					else
					{
						$groups[$taxonomic_group] = 0;
					}
				}
			
			
			
			}
			
			// Link paper --references--> sequence
			if ($seq_id != '')
			{
				echo "$ref_id - $seq_id - " . RELATION_REFERENCES;
				// link 
				db_link_objects(
					$ref_id,
					$seq_id, 
					RELATION_REFERENCES);
			}
		
			echo "\n";
		
		}
	}
	
	echo "Taxonomic groups\n";
	print_r($groups);
	
	$max_count = 0;
	$max_group = '';
	foreach ($groups as $k => $v)
	{
		if ($v > $max_count)
		{
			$max_count = $v;
			$max_group = $k;
		}
	}
	$collectionCode = '';
	switch ($max_group)
	{
		case 'Reptiles':
		case 'Amphibia':
			$collectionCode = 'Herps';
			break;
		default:
			$collectionCode = $max_group;
			break;
	}
	
	echo $collectionCode . "\n";
	
	// test
	//$collectionCode = 'Herps';
	
	// 3.
	// specimens
	// we need taxonomic group info here, plus we need to clean the specimens
	// plus test whether they are linked to a specimen in a table
	
	foreach ($data->vouchers as $v)
	{
		// clean
		$s = extract_specimen_codes($v);
		if (count($s) > 0)
		{
			$code = $collectionCode;
			if ($code == 'Herps')
			{
				$parts = split(" ", $v);
				switch ($parts[0])
				{					
					// LACM
					case 'LACM':
						$code = '';
						break;
						
					// Australian stuff
					case 'AM':
					case 'SAMA':
					case 'ANWC':
					case 'AMS';
					case 'WAM':
					case 'NT':							
						$code = '';
						break;
						
					default:
						break;
				}
			}
			
			$parts = split(" ", $s[0]);
			$url = 'http://bioguid.info/openurl?genre=specimen&institutionCode=' . $parts[0] .
				'&collectionCode=' . $code . '&catalogNumber=' . $parts[1] . '&display=json';
				
			echo $url . "\n";
			
			$specimen_id = '';
				
			// fetch
			$j = get($url);
			
			echo $j;
			
			$d = json_decode($j);
			if (isset($d->title))
			{
				// we got a specimen from a DiGIR provider
				$o = new Specimen();
				
				$o->SetData($d);
				$o->Store();
				$specimen_id = $o->GetObjectId();
				
				$code2object_id[$v] = $specimen_id;
			}
	/*		else
			{
				// We could treat recognisable specimen codes as objects and add them
				// as objects (which we try and populate later...)
				$o = new Specimen();
				$d = new stdClass;
				$d->title = $v;
				
				$o->SetData($d);
				$o->Store();
				$specimen_id = $o->GetObjectId();
				
				$code2object_id[$v] = $specimen_id;
			}*/
			
			if ($specimen_id != '')
			{
				// links
				
				// link to paper...
				db_link_objects(
					$ref_id,
					$specimen_id, 
					RELATION_REFERENCES);
			}
			
		}
		
	}
	
	
	// 4. Add localities
	
	// needs some thought, but I'm trying to capture the information without changing the original
	// records too much, so as to keep a trail of what happened.
	
	// Add point localities to specimens (as points, don't alter original record)
	foreach ($data->voucher_coordinates as $v => $latlong)
	{
		echo "$v\n";
		print_r($latlong);
		if (array_key_exists($v, $code2object_id))
		{
			db_store_object_point_locality($code2object_id[$v], 
				$latlong['latitude'], $latlong['longitude'], $ref_id);
		}
	
	}
	
	// Add point localities to sequences (as points, don't alter original record)
	foreach ($data->accession_coordinates as $v => $latlong)
	{
		echo "$v\n";
		print_r($latlong);
		if (array_key_exists($v, $code2object_id))
		{
			db_store_object_point_locality($code2object_id[$v], 
				$latlong['latitude'], $latlong['longitude'], $ref_id);
		}
	
	}
	
	// no, we get too many errors.....
	
	/*
	// Store localities as tags (and georeferencing if it exists)
	foreach ($data->localities as $loc)
	{
		echo "Locality = $loc\n";
		
		if ($loc != '')
		{
			$o = new Locality();
			
			$d = new stdClass;
			$d->title = $loc;
			
			if (array_key_exists($loc, $data->locality_coordinates))
			{
				$d->latitude = $data->locality_coordinates[$loc]['latitude'];
				$d->longitude = $data->locality_coordinates[$loc]['longitude'];
			}	
			$o->SetData($d);
			$o->Store();
			$loc_id = $o->GetObjectId();
			
			// link locality to reference
					db_link_objects(
						$ref_id,
						$loc_id, 
						RELATION_TAGGED_WITH_TAG);
		}	
	
	}
	*/
	
	
	// Store raw coordinates (as points, use as spatial index)
	foreach ($data->coordinates as $loc)
	{
		db_store_object_point_locality($ref_id, 
			$loc['latitude'], $loc['longitude']);
	}
	
}	






?>