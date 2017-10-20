<?php

// $Id: $

/**
 * @file class_journal.php
 *
 * Encapsulate a journal
 *
 */

// Make sure includes are absolute paths
$rootdir = dirname(__FILE__) . '/';

require_once($rootdir . 'class_object.php');
require_once($rootdir . 'ISBN-ISSN.php');


 
define('CLASS_JOURNAL',		4);

//------------------------------------------------------------------------------------
/**
 * @brief A journal
 *
 */
class Journal extends Object
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
	 * Generate md5 hash of ISSN, if available, otherwise hash journal name
	 */
	function GenerateObjectId()
	{
		if (isset($this->mData->issn))
		{
			$this->mObjectId = md5($this->mData->issn);
		}
		else
		{
			$this->mObjectId = md5($this->mData->title);
		}
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Test whether an object with any of this object's guids is already in the database
	 *
	 * Use the ISSN (if present) to test whether this journal already exists in the database.
	 *
	 * @return object identifier if object exists, otherwise ''
	 *
	 */
	function ObjectIdFromGuid()
	{
		$object_id = '';
		
		// Do we have a journal with this ISSN?
		if (isset($this->mData->issn))
		{
			$object_id = db_find_object_with_guid('issn', $this->mData->issn);
		}
		
		return $object_id;
		
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Test whether an object is already in the database based on metadata
	 *
	 * Use the journal title to test whether this journal already exists in the database. Only do
	 * this if we don't have an ISSN.
	 *
	 * @return object identifier if object exists, otherwise ''
	 *
	 */
	function ObjectIdFromMetadata()
	{
		$object_id = '';

		if (!isset($this->mData->issn))
		{
			$hits = db_find_objects_with_attribute_value($this->mClassId, 'title', $this->mData->title);
			if (1 == count($hits))
			{
				$exists = true;
				$object_id = $hits[0];
			}
		}
		return $object_id;
	}	
	

	//--------------------------------------------------------------------------------
	/**
	 * @brief Post process 
	 *
	 * Clean ISSN using Robert D. Cameron's tools
	 *
	 * to do: maybe try and get "definitive" name from bioguid ISSN lookup
	 */
	function PostProcess()
	{
		// Clean the ISSN
		if (isset($this->mData->issn))
		{
			$str = $this->mData->issn;
			
			$clean = ISN_clean($str);
			$class = ISSN_classifier($clean);
			if ($class == "checksumOK")
			{
				$this->mData->issn = canonical_ISSN($clean);
			}
		}
		
		
	}
		
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Set object type (must be defined in each oject)
	 *
	 */
	function SetType()
	{
		$this->mClassId = CLASS_JOURNAL;
	}
	
	//--------------------------------------------------------------------------------
	/**
	 * @brief Store journal GUIDs in EAV database
	 *
	 * Default GUID is ISSN
	 *
	 * @param author_id Unique identifier for author or agent storing the object
	 * @param ip IP address of author or agent storing the object
	 * @param comment Comment describing the edit 
	 */
	function StoreGuids($author_id, $ip, $comment)
	{		
		if (isset($this->mData->issn))
		{
			// ISSN has been cleaned at this point by PostProcess
			db_store_object_guid($this->mObjectId, 'issn', $this->mData->issn, $author_id, $ip, $comment);
		}
	}
}


if (0)
{
	// test
	$o = new stdClass;
	$o->issn = '07378211';
	$o->title= 'Systematic Botany Monographs';
	
	$j = new Journal();
	$j->SetData($o);
	$j->Dump();
	$j->Store();		
	echo "<br/><b>" . $j->GetObjectId() . "</b>";
}

?>