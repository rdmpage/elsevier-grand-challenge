<?php

// $Id: $

/**
 * @file class_cannonical.php
 *
 * Encapsulate a cannonical taxonomic name
 *
 * For each taxonomic name we have a canonical name, which if it exists in uBio will have a 
 * namebankID (and is the name in namebankID for which nameString = fullNameString).
 *
 * Conceptually this is very like how Flickr stores tags, see 
 * http://weblog.terrellrussell.com/2007/06/clean-and-store-your-raw-tags-like-flickr/
 *
 */

// Make sure includes are absolute paths
$rootdir = dirname(__FILE__) . '/';

require_once($rootdir . 'class_tag.php');
 
define('CLASS_CANNONICALNAME',		5);

//------------------------------------------------------------------------------------
/**
 * @brief A cannonical taxonomic name
 *
 */
class CannonicalName extends Tag
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
	 * Generate md5 hash of name
	 */
	function GenerateObjectId()
	{
		if (isset($this->mData->namebankID))
		{
			$this->mObjectId = md5($this->mData->namebankID);
		}
		else
		{
			$this->mObjectId = md5('namestring:' . $this->mData->title);
		}
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Test whether an object with any of this object's guids is already in the database
	 *
	 * Use the namebankID (if present) to test whether this name already exists in the database.
	 *
	 * @return object identifier if object exists, otherwise ''
	 *
	 */
	function ObjectIdFromGuid()
	{
		$object_id = '';
		
		// Do we have a cannonical name with this namebankID?
		if (isset($this->mData->namebankID))
		{
			$object_id = db_find_object_with_guid('namebankID', $this->mData->namebankID);
		}
		
		return $object_id;
		
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Test whether an object is already in the database based on metadata
	 *
	 *
	 * @return object identifier if object exists, otherwise ''
	 *
	 */
	function ObjectIdFromMetadata()
	{
		$object_id = '';

		if (isset($this->mData->title))
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
	

		
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Set object type (must be defined in each oject)
	 *
	 */
	function SetType()
	{
		$this->mClassId = CLASS_CANNONICALNAME;
	}
	
	//--------------------------------------------------------------------------------
	/**
	 * @brief Store  GUIDs in EAV database
	 *
	 * Default GUID is uBio namebankID
	 *
	 * @param author_id Unique identifier for author or agent storing the object
	 * @param ip IP address of author or agent storing the object
	 * @param comment Comment describing the edit 
	 */
	function StoreGuids($author_id, $ip, $comment)
	{		
		if (isset($this->mData->namebankID))
		{
			db_store_object_guid($this->mObjectId, 'namebankID', $this->mData->namebankID, $author_id, $ip, $comment);
		}
	}
}


if (0)
{
	// test
	$o = new stdClass;
	$o->namebankID = '2476165';
	$o->title= 'Eleutherodactylus ridens';
	
	$j = new CannonicalName();
	$j->SetData($o);
	$j->Dump();
	$j->Store();		
	echo "<br/><b>" . $j->GetObjectId() . "</b>";
}

?>