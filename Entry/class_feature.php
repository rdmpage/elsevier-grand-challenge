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
require_once($rootdir . 'class_tag.php');
 
define('CLASS_FEATURE',		10);

//------------------------------------------------------------------------------------
/**
 * @brief A Genbank feature
 *
 */
class Feature extends Tag
{
	
	//--------------------------------------------------------------------------------
	/**
	 * @brief Create object name from person's name
	 *
	 */
	function CreateName()
	{
		$this->mName = $this->mData->name;
	}	
	
	
	//--------------------------------------------------------------------------------
	/**
	 * @brief Generate object identifier
	 *
	 * Generate md5 hash of name
	 */
	function GenerateObjectId()
	{
		// clean and strip
		$this->mObjectId = md5($this->mData->key . ':' . $this->mData->name);
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Test whether an object is already in the database based on metadata
	 *	 
	 * Do we have this key:name pair already?
	 *
	 * @return object identifier if object exists, otherwise ''
	 *
	 */
	function ObjectIdFromMetadata()
	{
		global $db;
		
		$object_id = '';
		
		$a = db_attribute_from_name($this->GetType(), 'key');
		$key = $a['id'];
		$a = db_attribute_from_name($this->GetType(), 'name');
		$name = $a['id'];
		
		$sql = 'SELECT object_id FROM EAV_String AS e1
INNER JOIN EAV_String AS e2 USING(object_id)
WHERE (e1.attribute_id = ' . $key . ') AND (e1.value=' . $db->Quote($this->mData->key) . ')
AND (e2.attribute_id = ' . $name . ') AND (e2.value=' . $db->Quote($this->mData->name) . ')';
		
		$result = $db->Execute($sql);
		if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
			
		if (1 == $result->NumRows())
		{
			$object_id =  $result->fields['object_id'];
		}
		
		// Major fuck up (sigh), again not querying attributes together
		/*

		$hits = db_find_objects_with_attribute_value($this->mClassId, 'name', $this->mData->name);
		if (count($hits) > 0)
		{
			$hits = db_find_objects_with_attribute_value($this->mClassId, 'key', $this->mData->key);
			if (count($hits) > 0)
			{
				$object_id = $hits[0];
			}
		}
		
		*/
		
		return $object_id;
	}	
		
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Set object type (must be defined in each oject)
	 *
	 */
	function SetType()
	{
		$this->mClassId = CLASS_FEATURE;
	}
	
}


?>