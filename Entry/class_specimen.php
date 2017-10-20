<?php

// $Id: $

/**
 * @file class_specimen.php
 *
 * Encapsulate a specimen
 *
 *
 *
 */

// Make sure includes are absolute paths
$rootdir = dirname(__FILE__) . '/';

require_once($rootdir . 'class_object.php');
require_once($rootdir . 'class_cannonical.php');

//--------------------------------------------------------------------------------------------------
/**
 * @brief Encapsulate a specimen
 *
 */
 
define('CLASS_SPECIMEN',		6);
 
//--------------------------------------------------------------------------------------------------
/**
 * @brief Encapsulate a specimen
 *
 */
class Specimen extends Object
{	

	//--------------------------------------------------------------------------------
	/**
	 * @brief Generate name for specimen
	 *
	 */
	function CreateName()
	{
		$this->mName = $this->mData->title;
	}	
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Generate object identifier
	 *
	 */
	function GenerateObjectId()
	{
		if (isset($this->mData->guid))
		{	
			$this->mObjectId = md5($this->mData->guid);
		}
		else
		{
			$this->mObjectId = md5($this->mData->title);
		}			
	}	
	
	//----------------------------------------------------------------------------------------------
	function GetHtmlSnippet()
	{
		$snippet = '';
		
		$snippet .= $this->GetAttributeValue('organism');
		
		$loc = 	$this->GetAttributeValue('country');
		if ($this->GetAttributeValue('stateProvince'))
		{
			$loc .= ', ' . $this->GetAttributeValue('stateProvince');
		}
		if ($this->GetAttributeValue('locality'))
		{
			$loc .= ', ' . $this->GetAttributeValue('locality');
		}
		$snippet .= ' from ' . $loc;
		
		$latitude = $this->GetAttributeValue('latitude');
		$longitude = $this->GetAttributeValue('longitude');
		if ('' != $latitude)
		{
			$snippet .=  ' (' . format_decimal_latlon($latitude, $longitude) . ')';
		}
		if ($this->GetAttributeValue('collector'))
		{
			$snippet .= ', collected by ' . $this->GetAttributeValue('collector');
		}
		if ($this->GetAttributeValue('fieldNumber'))
		{
			$snippet .= ', field number ' . $this->GetAttributeValue('fieldNumber');
		}
		if ($this->GetAttributeValue('collectorNumber'))
		{
			$snippet .= ', collector number ' . $this->GetAttributeValue('collectorNumber');
		}
		
		
		return $snippet;
	}
	
	
	
		
		
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Set object type (must be defined in each object)
	 *
	 */
	function SetType()
	{
		$this->mClassId = CLASS_SPECIMEN;
	}
	
			
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Store links between this object and any associated objects
	 *
	 * Link to organism name
	 *
	 * @param author_id Unique identfiier for author or agent storing the object
	 * @param ip IP address of author or agent storing the object
	 * @param comment Comment describing the edit 
	 */
	function StoreLinks($author_id, $ip, $comment)
	{
		if (isset($this->mData->organism))
		{
			// Link to taxon name
			$o = new stdClass;
			$o->title= $this->mData->organism;
		
			if (isset($this->mData->namebankID[0]))
			{
				$o->namebankID = $this->mData->namebankID[0];
			}		
			$name = new CannonicalName();
			$name->SetData($o);
			$name->Store();		
			
			$name_id = $name->GetObjectId();
			
			db_link_objects(
				$this->GetObjectId(),
				$name_id, 
				RELATION_TAGGED_WITH_TAG,
				1,
				$author_id, $ip, $comment);
		}
	}

}


if (0)
{
	$j = '{
  "title": "USNM 514547",
  "guid": "USNM:Herps:514547",
  "institutionCode": "USNM",
  "collectionCode": "Herps",
  "catalogNumber": "514547",
  "organism": "Eleutherodactylus ridens",
  "kingdom": "Animalia",
  "phylum": "Chordata",
  "class": "Amphibia",
  "order": "Anura",
  "family": "Strabomantidae",
  "genus": "Eleutherodactylus",
  "species": "ridens",
  "country": "Honduras",
  "stateProvince": "Atlantida",
  "locality": "Parque Nacional Pico Bonito, Quebrada de Oro (tributary of R\u00edo Viejo)",
  "latitude": "15.6",
  "longitude": "-86.8",
  "elevation": "940",
  "verbatimLatitude": "15 38 -- N",
  "verbatimLongitude": "086 48 -- W",
  "dateLastModified": "2008-8-25T07:10:52.000Z",
  "verbatimCollectingDate": "28 May 1996",
  "collector": "S. Gotte",
  "collectorNumber": "LDW 10706",
  "dateCollected": "1996-05-28",
  "dateModified": "2008-08-25",
  "namebankID": [
    "2476165"
  ],
  "bci": "urn:lsid:biocol.org:col:34872"
}';

$j='{
  "title": "TNHC 63583",
  "guid": "TNHC:Herps:63583",
  "organism": "Pseudacris fouquettei",
  "kingdom": "Animalia",
  "phylum": "Chordata",
  "class": "Amphibia",
  "order": "Anura",
  "family": "Hylidae",
  "genus": "Pseudacris",
  "species": "fouquettei",
  "country": "USA",
  "stateProvince": "Texas",
  "county": "Lamar",
  "locality": "N 33.7803, W 95.5353",
  "latitude": "33.7803",
  "longitude": "-95.5353",
  "dateLastModified": "2008-01-15 10:47:16",
  "verbatimCollectingDate": "12\/31\/03",
  "collector": "Ford, Neil",
  "fieldNumber": "JTC 2586",
  "dateCollected": "2003-12-31",
  "dateModified": "2008-01-15",
  "institutionCode": "TNHC",
  "collectionCode": "Herps",
  "catalogNumber": "63583"
}';

$j='{
  "title": "USNM 111753",
  "guid": "USNM:Mammals:111753",
  "organism": "Tupaia nicobarica surda",
  "kingdom": "Animalia",
  "phylum": "Chordata",
  "class": "Mammalia",
  "order": "Scandentia",
  "family": "Tupaiidae",
  "genus": "Tupaia",
  "species": "nicobarica",
  "subspecies": "surda",
  "country": "Andaman And Nicobar Is",
  "islandGroup": "Nicobar Islands",
  "locality": "Little Nicobar",
  "latitude": "7.3",
  "longitude": "93.7",
  "verbatimLatitude": "07 20 -- N",
  "verbatimLongitude": "093 40 -- E",
  "dateLastModified": "2003-3-30T14:13:41.000Z",
  "verbatimCollectingDate": "27 Feb 1901",
  "collector": "W. Abbott",
  "collectorNumber": "895",
  "dateModified": "2003-03-30",
  "institutionCode": "USNM",
  "collectionCode": "Mammals",
  "catalogNumber": "111753",
  "bci": "urn:lsid:biocol.org:col:34905"
}';

$j='
{
  "title": "FMNH 250112",
  "guid": "FMNH:Herps:250112",
  "institutionCode": "FMNH",
  "collectionCode": "Herps",
  "catalogNumber": "250112",
  "organism": "Enhydris punctata",
  "kingdom": "Animalia",
  "phylum": "Chordata",
  "class": "Reptilia",
  "order": "Serpentes",
  "family": "Colubridae",
  "genus": "Enhydris",
  "species": "punctata",
  "country": "Malaysia",
  "stateProvince": "Selangor",
  "dateLastModified": "2004-11-17",
  "verbatimCollectingDate": "Jun 1992",
  "collector": "P K L Ng",
  "fieldNumber": "HKV 31710",
  "dateCollected": "1992-06-01",
  "dateModified": "2004-11-17",
  "namebankID": [
    "2539503"
  ],
  "bci": "urn:lsid:biocol.org:col:34706"
}';

$j='
{
  "title": "CAS 206574",
  "guid": "CAS::206574",
  "institutionCode": "CAS",
  "collectionCode": "",
  "catalogNumber": "206574",
  "organism": "Cerberus rynchops",
  "kingdom": "Animalia",
  "phylum": "Chordata",
  "class": "Reptilia",
  "order": "Serpentes",
  "family": "Colubridae",
  "genus": "Cerberus",
  "species": "rynchops",
  "country": "Myanmar",
  "stateProvince": "Ayeyarwady Div.",
  "county": "Myaungmya Dist.",
  "continentOcean": "Asia",
  "locality": "Myanmar: Ayeyarwady Divison: vic Mwe Hauk Village, N 16 16 41.0, E 94 46 23.7",
  "latitude": "16.278055555556",
  "longitude": "94.77325",
  "dateLastModified": "2008-04-22T14:47:00",
  "verbatimCollectingDate": "6 Nov 1997",
  "collector": "J.B. Slowinski",
  "collectorNumber": "RCD-12259",
  "dateCollected": "1997-11-06",
  "dateModified": "2008-04-22",
  "namebankID": [
    "2537484"
  ]
}';

$j='
{
  "title": "CAS 219171",
  "guid": "CAS::219171",
  "institutionCode": "CAS",
  "collectionCode": "",
  "catalogNumber": "219171",
  "organism": "Gastropyxis smaragdina",
  "kingdom": "Animalia",
  "phylum": "Chordata",
  "class": "Reptilia",
  "order": "Serpentes",
  "family": "Colubridae",
  "genus": "Gastropyxis",
  "species": "smaragdina",
  "country": "Sao Tome and Principe",
  "island": "Principe Id.",
  "continentOcean": "Africa",
  "locality": "Sao Tome and Principe: Principe Id.: South of Sundi, 01 39 44.6 N, 007 23 07.8 E",
  "latitude": "1.6623888888889",
  "longitude": "7.3855",
  "dateLastModified": "2008-04-22T14:47:00",
  "verbatimCollectingDate": "21 Apr 2001",
  "collector": "R.C. Drewes and R.E. Stoelting",
  "collectorNumber": "RCD-14093",
  "dateCollected": "2001-04-21",
  "dateModified": "2008-04-22",
  "namebankID": [
    "2539856"
  ]
}';

$j='{
  "title": "USNM 111753",
  "guid": "USNM:Mammals:111753",
  "organism": "Tupaia nicobarica surda",
  "kingdom": "Animalia",
  "phylum": "Chordata",
  "class": "Mammalia",
  "order": "Scandentia",
  "family": "Tupaiidae",
  "genus": "Tupaia",
  "species": "nicobarica",
  "subspecies": "surda",
  "country": "Andaman And Nicobar Is",
  "islandGroup": "Nicobar Islands",
  "locality": "Little Nicobar",
  "latitude": "7.3",
  "longitude": "93.7",
  "verbatimLatitude": "07 20 -- N",
  "verbatimLongitude": "093 40 -- E",
  "dateLastModified": "2003-3-30T14:13:41.000Z",
  "verbatimCollectingDate": "27 Feb 1901",
  "collector": "W. Abbott",
  "collectorNumber": "895",
  "dateModified": "2003-03-30",
  "institutionCode": "USNM",
  "collectionCode": "Mammals",
  "catalogNumber": "111753",
  "bci": "urn:lsid:biocol.org:col:34905"
}';

	$o = json_decode($j);

	$j = new Specimen();
	$j->SetData($o);
	$j->Dump();
	$j->Store();		
	echo "<br/><b>" . $j->GetObjectId() . "</b>";


}








?>