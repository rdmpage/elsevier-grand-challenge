<?php

// $Id: $

/**
 * @file class_locality.php
 *
 * Encapsulate a locality (text string decsribing a locality)
 *
 *
 */

// Make sure includes are absolute paths
$rootdir = dirname(__FILE__) . '/';

require_once($rootdir . 'class_tag.php');
 
define('CLASS_LOCALITY',		11);

//------------------------------------------------------------------------------------
/**
 * @brief A tag
 *
 */
class Locality extends Tag
{	
	
	//--------------------------------------------------------------------------------
	/**
	 * @brief Generate object identifier
	 *
	 * Generate md5 hash of name
	 */
	function GenerateObjectId()
	{
		$this->mObjectId = md5('locality:' . $this->mData->stripped);
	}
	
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Set object type (must be defined in each oject)
	 *
	 */
	function SetType()
	{
		$this->mClassId = CLASS_LOCALITY;
	}
	

	
}


if (0)
{
	// test
	$o = new stdClass;
	$o->title= 'likelihood';
	
	$j = new Tag();
	$j->SetData($o);
	$j->Dump();
	$j->Store();		
	echo "<br/><b>" . $j->GetObjectId() . "</b>";
}

?>