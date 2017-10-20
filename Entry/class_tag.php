<?php

// $Id: $

/**
 * @file class_tag.php
 *
 * Encapsulate a tag
 *
 *
 */

// Make sure includes are absolute paths
$rootdir = dirname(__FILE__) . '/';

require_once($rootdir . 'class_object.php');
 
define('CLASS_TAG',		7);

//------------------------------------------------------------------------------------
/**
 * @brief A tag
 *
 */
class Tag extends Object
{
	var $stripped;
		
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
		$this->mObjectId = md5('tag:' . $this->mData->stripped);
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Test whether an object is already in the database based on metadata
	 *
	 * Look for stripped version of tag
	 *
	 * @return object identifier if object exists, otherwise ''
	 *
	 */
	function ObjectIdFromMetadata()
	{
		$object_id = '';
		

		if (isset($this->mData->stripped))
		{
			echo "$tag\n";
			$hits = db_find_objects_with_attribute_value($this->mClassId, 'stripped', $this->mData->stripped);
			if (1 == count($hits))
			{
				$exists = true;
				$object_id = $hits[0];
			}
		}
		return $object_id;
	}	
		
		
	//----------------------------------------------------------------------------------------------
	function PostProcess()
	{
		$this->mData->stripped = $this->StripTag($this->mData->title);
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Set object type (must be defined in each oject)
	 *
	 */
	function SetType()
	{
		$this->mClassId = CLASS_TAG;
	}
	
	
	//----------------------------------------------------------------------------------------------
	function StripTag($tag)
	{
		$tag = str_replace(' ', '', $tag);
		$tag = str_replace('-', '', $tag);
		$tag = str_replace('.', '', $tag);
		$tag = strtolower($tag);
		
		return $tag;
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