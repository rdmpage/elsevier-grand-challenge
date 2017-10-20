<?php

// $Id: $

/**
 * @file class_object.php
 *
 * Object stored in EAV database
 *
 */
 
// Make sure includes are absolute paths
$rootdir = dirname(__FILE__) . '/';

require_once($rootdir . 'config.inc.php');
require_once($rootdir . 'eav/eav.php');
require_once($rootdir . 'class_graph.php');


// These definitions must match those in the database
// Class types
define('CLASS_BASE',			1);

// Relationship types
define('RELATION_REFERENCES', 		1);
define('RELATION_AUTHOR_OF', 		2);
define('RELATION_IS_PART_OF', 		3);
define('RELATION_TAGGED_WITH_TAG', 	4);
define('RELATION_SOURCE',	 		5);
define('RELATION_HOSTED_BY',	 	6);
define('RELATION_VOUCHER_FOR',	 	7);



//--------------------------------------------------------------------------------------------------
/**
 * @brief Base object.
 *
 * Identifiers
 *
 *
 *
 */

//--------------------------------------------------------------------------------------------------
// Classes
class Object
{
	var $mObjectId;
	var $mClassId;
	var $mName;
	var $mDescription;
	var $mAttributes;
	var $mData;
	
	//----------------------------------------------------------------------------------------------
	function Object($id = '')
	{
		$this->mObjectId = $id;
		$this->mName = '[untitled]';
		$this->mDescription = '';
		$this->SetType();
	}

	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Create a name for the object. We use this as the object title when 
	 * displaying it.
	 *
	 */
	function CreateName()
	{
		$this->mName = "object";
	}

	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Create a descriptive string for the object.
	 *
	 */
	function CreateDescription()
	{
		$this->mDescription = "";
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Dump object contents
	 *
	 */
	function Dump()
	{
//		echo '<pre style="text-align: left;border: 1px solid #c7cfd5;background: #f1f5f9;padding:15px;">';
		echo "   ObjectID: " . $this->mObjectId . "\n";
		echo "       Name: " . $this->mName . "\n";
		echo "Description: " . $this->mDescription . "\n";
		echo "      Class: " . $this->mClassId . "\n";
		echo "      Data: \n";
		print_r($this->mData);
		echo "Attributes: \n";
		print_r($this->mAttributes);
//		echo "</pre>";		
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Test whether this object already exists
	 *
	 * Three possible tests:
	 * <ol>
	 * <li>Does an object exist with this object's md5 hash?</li>
	 * <li>Does an object exist with any of this object's guids?</li>
	 * <li>Does an object exist with this object's metadata?</li>
	 * </ol>
	 *
	 * If object exists, we set mObjectId to the id of that objecth
	 *
	 * @return True if object exists in database, false otherwise
	 */
	function Exists()
	{
		$exists = false;
		
		// Does object exist with this md5 hash?
		if (db_object_exists($this->mObjectId))
		{
			$exists = true;
		}
		// Object with one of the guids
		if (!$exists)
		{
			$object_id = $this->ObjectIdFromGuid();
			
			$exists = ($object_id != '');
			if ($exists)
			{
				$this->mObjectId = $object_id;
			}
		}
		// Metadata search
		if (!$exists)
		{
			$object_id = $this->ObjectIdFromMetadata();
			$exists = ($object_id != '');
			if ($exists)
			{
				$this->mObjectId = $object_id;
			}
		}
			
		return $exists;
	}
	

	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Get value of a given attribute by name
	 *
	 * @param attribute_name Name of the attribute
	 *
	 * @result Attribute value, or empty string '' if attribute not found.
	 */
	function GetAttributeValue($attribute_name)
	{
		$value = '';
		
		$a = db_attribute_from_name ($this->GetType(), $attribute_name);
		
		if (isset($a['id']))
		{
			$value = db_retrieve_current_attribute_value ($this->GetObjectId(), $a['datatype'], $a['id']);
		}
		return $value;
	}
	
	//----------------------------------------------------------------------------------------------
	function GetAttributesToExclude()
	{
		$exclude = array();
		return $exclude;
	}

	//----------------------------------------------------------------------------------------------
	function GetAttributesAsHtmlTable()
	{
		$html = '';
		
		
		$exclude = $this->GetAttributesToExclude();
		
		//print_r($this->mAttributes['attributes']);
		
		$html .= '<table border="0" cellpadding="2" cellspacing="0" class="attributes" width="100%">';
		
		$count = 0;
		foreach ($this->mAttributes['attributes'] as $a)
		{
			if (array_search($a['name'], $exclude) === false)
			{
			
				$html .= '<tr';
				if ($count % 2)
				{
					$html .= ' class="even"';
				}
				else
				{
					$html .= ' class="odd"';
				}
				$html .= '>';
				$html .= '<td valign="top">';
			
				if ('' != $a['caption'])
				{
					$html .= $a['caption'];
				}
				else
				{
					$html .= $a['name'];
				}
				$html .= '</td>';
				$html .= '<td>' . $a['value'] . '</td>';
				$html .= '</tr>';
			
				$count++;
			}
		}

		$html .= '</table>';
		
		return $html;
	}

	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Generate an indentifier for the object. 
	 *
	 * We use a md5 hash of some string associated with the identifier to generate a 
	 * unique identifier that we use as a primary key.
	 *
	 */
	function GenerateObjectId()
	{
		
	}
	
	//----------------------------------------------------------------------------------------------
	function GetDescription()
	{
		return $this->mDescription;
	}
	
	
	//----------------------------------------------------------------------------------------------
	// Return a graph object depeicting the object's connections
	function GetGraph()
	{
		$neighbours = db_incoming_links($this->GetObjectId());
		
		// Make graph
		$G = new Graph(true);
		
		$targetNode = $G->AddNode($this->GetObjectId(), $this->GetName());
		foreach ($neighbours as $n)
		{
			$sourceNode = $G->AddNode($n['object_id'], $n['name']);
			$G->AddEdge($sourceNode, $targetNode, $n['type']);
		}
		$neighbours = db_outgoing_links($this->GetObjectId());
		
		
		$sourceNode = $G->AddNode($this->GetObjectId(), $this->GetName());
				
		foreach ($neighbours as $n)
		{
			$targetNode = $G->AddNode($n['object_id'], $n['name']);
			$G->AddEdge($sourceNode, $targetNode, $n['type']);
		}
		
		return $G;
	}
	
	//----------------------------------------------------------------------------------------------
	function GetHtmlSnippet()
	{
		return '';
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Generate microformat
	 *
	 * By default include geo location
	 *
	 * Tools such as https://addons.mozilla.org/en-US/firefox/addon/4106 can extract
	 * microformats.
	 *
	 */
	function GetMicroformat()
	{
/*		$html = '<div style="visibility:hidden; height:0px;">';
		
		// Location
		$points = db_get_localities_for_object($this->GetObjectId());

		foreach($points as $p)
		{
			$html .= '<span class="geo" >' . "\n";
			$html .= '<span class="latitude">' . $p['pt'][1] . '</span>' . "\n";
			$html .= '<span class="longitude">' . $p['pt'][0] . '</span>' . "\n";
			$html .= '</span>' . "\n";
		}
		$html .= '</div>';
		return $html; */
		return '';
	}
	
	//----------------------------------------------------------------------------------------------
	function GetName()
	{
		return $this->mName;
	}
	
	//----------------------------------------------------------------------------------------------
	function GetObjectId()
	{
		return $this->mObjectId;
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Get id of parent object (if it exists)
	 *
	 */
	function GetParentObjectId()
	{
		return '';
	}

	
	//----------------------------------------------------------------------------------------------
	function GetRdf($feed, $item)
	{		
		foreach ($this->mAttributes['attributes'] as $a)
		{				
			if ('' != $a['rdf'])
			{
				$element = $feed->createElement($a['rdf']);
				$element = $item->appendChild($element);
				$value = $feed->createTextNode($a['value']);
				$value = $element->appendChild($value);
			}
		}
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Create RSS 2.0 item
	 *
	 * If object is geotagged then we add the locality(s) to the RSS using
	 * GeoRSS tags (see http://georss.org/)
	 */
	function GetRss($feed, $item)
	{	
		$created = db_object_created($this->GetObjectId());
				
		// Date object created
		$element = $feed->createElement('pubDate');
		$element = $item->appendChild($element);
		$value = $feed->createTextNode(date(DATE_RSS, strtotime($created)));
		$value = $element->appendChild($value);
		
/*		// Location
		$points = db_get_localities_for_object($this->GetObjectId());

		foreach($points as $p)
		{
			$element = $feed->createElement('georss:point');
			$element = $item->appendChild($element);
			$value = $feed->createTextNode($p['pt'][1] . ' ' . $p['pt'][0]);
			$value = $element->appendChild($value);
		}
		foreach($points as $p)
		{
			$geoPoint = $feed->createElement('geo:Point');
			$geoPoint = $item->appendChild($geoPoint);
			
			$element = $feed->createElement('geo:lat');
			$element = $geoPoint->appendChild($element);
			$value = $feed->createTextNode($p['pt'][1]);
			$value = $element->appendChild($value);

			$element = $feed->createElement('geo:long');
			$element = $geoPoint->appendChild($element);
			$value = $feed->createTextNode($p['pt'][0]);
			$value = $element->appendChild($value);
		}
*/

			
	}

	
	//----------------------------------------------------------------------------------------------
	function GetTitle()
	{
		return $this->GetName();
	}
	
	//----------------------------------------------------------------------------------------------
	function GetType()
	{
		return $this->mClassId;
	}
	
	//----------------------------------------------------------------------------------------------
	function Merge($author_id='', $ip='127.0.0.1', $comment='')
	{
		
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Test whether an object with any of this object's guids is already in the database
	 *
	 * @return object identifier if object exists, otherwise ''
	 *
	 */
	function ObjectIdFromGuid()
	{
		return '';
	}

	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Test whether an object is already in the database based on metadata
	 *
	 * @return object identifier if object exists, otherwise ''
	 *
	 */
	function ObjectIdFromMetadata()
	{
		return '';
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Post process attribute data
	 *
	 */
	function PostProcess()
	{
		
	}
	
	//----------------------------------------------------------------------------------------------
	function Retrieve()
	{
		$this->mAttributes = db_retrieve_object($this->GetObjectId());
		
		//print_r($this->mAttributes);
		
		if (isset($this->mAttributes['name']))
		{
			$this->mName = $this->mAttributes['name'];
		}
		if (isset($this->mAttributes['description']))
		{
			$this->mDescription = $this->mAttributes['description'];
		}
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Set object data
	 *
	 * Used by external routines that fetch data then populate the object
	 *
	 * @param data PHP object containing attribute namesa and values
	 */
	function SetData($data)
	{
		$this->mData = $data;
		$this->PostProcess();		
	}
	
	
	//----------------------------------------------------------------------------------------------
	function SetObjectId($object_id)
	{
		$this->mObjectId = $object_id;
	}
	
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Set object type (must be defined in each oject)
	 *
	 */
	function SetType()
	{
		$this->mClassId = CLASS_BASE;
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Store object in EAV database
	 *
	 * We generate a unique identifier for the object, test whether the object already
	 * exists in the database, and if it doesn't, we store the object, its attributes,
	 * and any associated GUIDs.
	 *
	 * @param author_id Unique identfiier for author or agent storing the object
	 * @param ip IP address of author or agent storing the object
	 * @param comment Comment describing the edit 
	 */
	function Store($author_id='', $ip='127.0.0.1', $comment='')
	{
		if ($this->Exists())
		{
			// Object exists in database, don't create it. However, we may have additional information which
			// we want to merge (what does this mean for updating version and revisions...?)
			
			//echo 'Object exists' . "\n";
			$this->Merge($author_id, $ip, $comment);
		}
		else
		{
			// If we don't have an object identifier, generate one 
			if ($this->GetObjectid() == '')
			{
				$this->GenerateObjectId($author_id, $ip, $comment);
			}
					
			$this->CreateName();
			$this->CreateDescription();
			
			db_object_insert ($this->mObjectId, $this->mClassId, $this->mName, $this->mDescription);
	
			$this->StoreAttributes($author_id, $ip, $comment);
			$this->StoreGuids($author_id, $ip, $comment);
			$this->StoreLinks($author_id, $ip, $comment);
			$this->StoreLocality($author_id, $ip, $comment);
		}
		
	
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Store object attributes in EAV database
	 *
	 * Store object attributes as typed data
	 *
	 * @param author_id Unique identifier for author or agent storing the object
	 * @param ip IP address of author or agent storing the object
	 * @param comment Comment describing the edit 
	 */
	function StoreAttributes($author_id, $ip, $comment)
	{
		// Iterate over data and store attributes for this object
		foreach ($this->mData as $k => $v)
		{	
			if ($v != '')
			{				
				$attribute = db_attribute_from_name($this->mClassId, $k);
				
				if (isset($attribute['id']))
				{					
					// This is something to store
					db_update_attribute_value($this->mObjectId, 
						$attribute['datatype'], 
						$attribute['id'],
						$v,
						$author_id,
						$ip,
						$comment);					
				}
			}
		}
	}
	
	
	//----------------------------------------------------------------------------------------------
	// store one attribute value
	function StoreAttributeValue($attribute_name, $attribute_value, $author_id, $ip, $comment)
	{
		$attribute = db_attribute_from_name($this->mClassId, $attribute_name);
		
		if (isset($attribute['id']))
		{					
			// This is something to store
			db_update_attribute_value($this->mObjectId, 
				$attribute['datatype'], 
				$attribute['id'],
				$attribute_value,
				$author_id,
				$ip,
				$comment);					
		}
	}

	
	
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Store object GUIDs in EAV database
	 *
	 * Store object GUIDs 
	 *
	 * @param author_id Unique identfiier for author or agent storing the object
	 * @param ip IP address of author or agent storing the object
	 * @param comment Comment describing the edit 
	 */
	function StoreGuids($author_id, $ip, $comment)
	{
		
	}

	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Store links between this obeject and anny associated objects
	 *
	 * @param author_id Unique identfiier for author or agent storing the object
	 * @param ip IP address of author or agent storing the object
	 * @param comment Comment describing the edit 
	 */
	function StoreLinks($author_id, $ip, $comment)
	{
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Store a point locality associated with the object
	 *
	 *
	 * @param author_id Unique identfiier for author or agent storing the object
	 * @param ip IP address of author or agent storing the object
	 * @param comment Comment describing the edit 
	 */
	function StoreLocality($author_id, $ip, $comment)
	{
		// if we have a latitude and longitude pair, then store this as a point
		
		$a = db_attribute_from_name($this->mClassId, 'latitude');
		if (isset($a['id']))
		{
			$latitude = db_retrieve_current_attribute_value($this->GetObjectId(), $a['datatype'], 
				$a['id']);
			if ($latitude != '')
			{
				$a = db_attribute_from_name($this->mClassId, 'longitude');
				if (isset($a['id']))
				{
					$longitude = db_retrieve_current_attribute_value($this->GetObjectId(), $a['datatype'], 
						$a['id']);
					if ($longitude != '')
					{
						//echo "POINT = $latitude $longitude\n";
						
						db_store_object_point_locality($this->GetObjectId(), $latitude, $longitude);
					}
				}
			}
		}
		
	}	

	
}

