<?php

// $Id: $

/**
 * @file class_taxon_name.php
 *
 * Encapsulate a taxonomic name
 *
 * NCBI tax_id's are our default taxonomic names
 *
 *
 */

// Make sure includes are absolute paths
$rootdir = dirname(__FILE__) . '/';

require_once($rootdir . 'class_tag.php');
 
define('CLASS_TAXON_NAME',		8);

//------------------------------------------------------------------------------------
/**
 * @brief A cannonical taxonomic name
 *
 */
class TaxonName extends Tag
{
	
	//--------------------------------------------------------------------------------
	/**
	 * @brief Create object name from person's name
	 *
	 */
	function CreateName()
	{
		$this->mName = $this->mData->title;
	}	
	
	
	//--------------------------------------------------------------------------------
	/**
	 * @brief Generate object identifier
	 *
	 * Generate md5 hash of tax_id
	 */
	function GenerateObjectId()
	{
		
		if (isset($this->mData->taxId))
		{
			$this->mObjectId = md5('taxid:' . $this->mData->taxId);
		}
		else
		{
			$this->mObjectId = md5('taxon:' . $this->mData->title);
		}
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Test whether an object with any of this object's guids is already in the database
	 *
	 * Use the tax_id (if present) to test whether this name already exists in the database.
	 *
	 * @return object identifier if object exists, otherwise ''
	 *
	 */
	function ObjectIdFromGuid()
	{
		$object_id = '';
		
		// Do we have a NCBI taxon with this namebankID?
		if (isset($this->mData->taxId))
		{
			$object_id = db_find_object_with_guid('taxid', $this->mData->taxId);
		}
		
		return $object_id;
		
	}
	
		
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Set object type (must be defined in each oject)
	 *
	 */
	function SetType()
	{
		$this->mClassId = CLASS_TAXON_NAME;
	}
	
	//--------------------------------------------------------------------------------
	/**
	 * @brief Store  GUIDs in EAV database
	 *
	 * Default GUID is NCBI tax_id
	 *
	 * @param author_id Unique identifier for author or agent storing the object
	 * @param ip IP address of author or agent storing the object
	 * @param comment Comment describing the edit 
	 */
	function StoreGuids($author_id, $ip, $comment)
	{		
		if (isset($this->mData->taxId))
		{
			db_store_object_guid($this->mObjectId, 'taxid', $this->mData->taxId, $author_id, $ip, $comment);
		}
	}
}


if (0)
{
	// test
	$o = new stdClass;
	$o->taxId = '2476165';
	$o->title= 'Eleutherodactylus ridens';
	
	$j = new TaxonName();
	$j->SetData($o);
	$j->Dump();
	$j->Store();		
	echo "<br/><b>" . $j->GetObjectId() . "</b>";
}

?>