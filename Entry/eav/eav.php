<?php

// $Id: $

/**
 * @file eav.php
 *
 * Services
 *
 */
 
// Make sure includes are absolute paths
$rootdir = dirname(__FILE__);
$rootdir = preg_replace('/eav$/', "", $rootdir);

require_once($rootdir . 'config.inc.php');
require_once($config['adodb_dir']);

$db = NewADOConnection('mysql');
$db->Connect("localhost", 
	$config['db_user'], $config['db_passwd'], $config['db_name']);

// Ensure fields are (only) indexed by column name
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;



//--------------------------------------------------------------------------------------------------
/**
 * @brief Test whether a object with a given id already exists in the database
 *
 * @param object_id Internal object id (a MD5 hash)
 *
 * @result True if exists, false otherwise
 *
 */
function db_object_exists($object_id)
{
	global $db;

	$sql = 'SELECT * FROM object 
		WHERE (object_id = ' . $db->Quote($object_id) . ') 
		LIMIT 1';
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);

	return ($result->NumRows() == 1);
}

//--------------------------------------------------------------------------------------------------
/**
 * @brief Get class of object
 *
 * @param object_id Internal object id (a MD5 hash)
 *
 * @result Class id
 *
 */
function db_object_class($object_id)
{
	global $db;
	
	$class_id = 0;

	$sql = 'SELECT * FROM object 
		WHERE (object_id = ' . $db->Quote($object_id) . ') 
		LIMIT 1';
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);

	if (1 == $result->NumRows())
	{
		$class_id = $result->fields['class_id'];
	}
	return $class_id;
}

//--------------------------------------------------------------------------------------------------
// list of neighbouring objects, with their name and type
function db_incoming_links ($object_id, $relationship_id = 0, $class_id = 0, $limit=0)
{
	global $db;

	$neighbours = array();
	
	$sql = 'SELECT object.object_id, object.name, object.description, object.class_id, object_link.relationship_id, object_link.created, object_link.id, relationships.name as relationship_name
		FROM object_link
		INNER JOIN object ON object.object_id = object_link.source_object_id
		INNER JOIN relationships ON object_link.relationship_id = relationships.id
		WHERE object_link.target_object_id='. $db->Quote($object_id);
		
		//echo $class_id, '<br/>', $relationship_id, '<br/>';
				
		// Do we want specific classes of objects?
		if (0 != $class_id)
		{
			$sql .= ' AND (object.class_id=' . $class_id . ')';
		}
		// Do we want specific kinds of relationships?
		if (0 != $relationship_id)
		{
			$sql .= ' AND (object_link.relationship_id=' . $relationship_id . ')';
		}
		$sql .= 'AND (object_link.created <= NOW())
		AND (object_link.modified > NOW())';
		
		$sql .= ' ORDER BY object.class_id, object_link.serial_number';
		
		// Do we want limit the search results?
		if (0 != $limit)
		{
			$sql .= ' LIMIT ' . $limit;
		}
		
	//echo $sql;

	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);

	while (!$result->EOF) 
	{
		$link = array(
			'id' => $result->fields['id'],
			'object_id' => $result->fields['object_id'],
			'name' => $result->fields['name'],
			'description' => $result->fields['description'],
			'type' => $result->fields['relationship_name'],
			'class_id' => $result->fields['class_id'],
			'created' => $result->fields['created'],			
			);
		array_push($neighbours, $link);
		$result->MoveNext();	
	}
	
	return $neighbours;
}

function db_outgoing_links ($object_id, $relationship_id = 0, $class_id = 0, $limit=0)
{
	global $db;

	$neighbours = array();
	
	$sql = 'SELECT object.object_id, object.name, object.description, object.class_id, object_link.relationship_id, object_link.created, object_link.id, relationships.name as relationship_name
		FROM object_link
		INNER JOIN object ON object.object_id = object_link.target_object_id
		INNER JOIN relationships ON object_link.relationship_id = relationships.id
		WHERE object_link.source_object_id='. $db->Quote($object_id);
		
		// Do we want specific classes of objects?
		if (0 != $class_id)
		{
			$sql .= ' AND (object.class_id=' . $class_id . ')';
		}
		// Do we want specific kinds of relationships?
		if (0 != $relationship_id)
		{
			$sql .= ' AND (object_link.relationship_id=' . $relationship_id . ')';
		}
		$sql .= 'AND (object_link.created <= NOW())
		AND (object_link.modified > NOW())';
		
	$sql .= ' ORDER BY object_link.serial_number';

		
	// Do we want limit the search results?
	if (0 != $limit)
	{
		$sql .= ' LIMIT ' . $limit;
	}
	
	//echo $sql;


	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
	
	//print_r($result);

	while (!$result->EOF) 
	{
		$link = array(
			'id' => $result->fields['id'],
			'object_id' => $result->fields['object_id'],
			'name' => $result->fields['name'],
			'description' => $result->fields['description'],
			'type' => $result->fields['relationship_name'],
			'class_id' => $result->fields['class_id'],
			'created' => $result->fields['created'],						
			);
		array_push($neighbours, $link);
		$result->MoveNext();	
	}
	
	return $neighbours;
}


//--------------------------------------------------------------------------------------------------
/**
 * @brief Return id of link (if one exists) two objects in the Database
 *
 * @param source_id Source object
 * @param target_id Target object
 * @param relationship_id Type of relationship
 * @param serial_number Order in which object link occurs. By default is 1.
 *
 * @result id of link, otherwise 0
 */
function db_retrieve_link_id($source_id, $target_id, $relationship_id, $serial_number = 1)
{
	global $db;
	
	$link_id = 0;

	// Do we have this relationship already?
	$sql = 'SELECT * FROM object_link 
		WHERE (source_object_id = ' . $db->Quote($source_id) . ')
		AND (target_object_id = ' . $db->Quote($target_id) . ')
		AND (relationship_id = ' . $relationship_id . ')
		AND (serial_number = ' . $serial_number . ')
		AND (created <= NOW())
		AND (modified > NOW())
		LIMIT 1';
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);

	if (1 == $result->NumRows())
	{
		$link_id = $result->fields['id'];
	}
	
	return $link_id;
}

//--------------------------------------------------------------------------------------------------
/**
 * @brief Link two objects in the Database
 *
 * Link two objects. Note that we can specify the order of the links in cases where this matters
 * (e.g., authorship)
 *
 * @param source_id Source object
 * @param target_id Target object
 * @param relationship_id Type of relationship
 * @param serial_number Order in which object link occurs. By default is 1.
 * @param author_id Internal object id of person or process making edit
 * @param ip IP address of editor
 * @param comment Comment
 *
 */ 
function db_link_objects($source_id, $target_id, $relationship_id, $serial_number = 1,	$author_id='', $ip='127.0.0.1', $comment='')
{
	global $db;

	$link_id = db_retrieve_link_id($source_id, $target_id, $relationship_id, $serial_number);
	
	if ($link_id == 0)
	{
		// make link
		$sql = 'INSERT INTO object_link(source_object_id, target_object_id, relationship_id, serial_number)
			VALUES (' . $db->Quote($source_id) . ', ' . $db->Quote($target_id) . ', ' . $relationship_id . ', ' . $serial_number . ')';
		$result = $db->Execute($sql);
		if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);

		// record this edit
		$link_id = $db->Insert_ID();
		db_record_edit($source_id, 'object_link', $link_id, $author_id, $ip, $comment);		
	}
}


//--------------------------------------------------------------------------------------------------
/**
 * @brief Insert an object into database
 *
 * @param object_id Internal object id (a MD5 hash)
 * @param class_id Class id
 * @param name Name of object (it's title)
 * @param description Description of object (to be used in search results, for example)
 * @param author_id Internal object id of person or process making edit
 * @param ip IP address of editor
 * @param comment Comment
 *
 */
function db_object_insert($object_id, $class_id, $name='', $description='',
			$author_id='', $ip='127.0.0.1', $comment='')
{
	global $db;
	
	if (!db_object_exists($object_id))
	{
	
		$sql = 'INSERT INTO object (object_id, class_id, name, description)
			VALUES(' . $db->Quote($object_id) 
			. ', ' . $db->Quote($class_id) 
			. ', ' . $db->Quote($name)
			. ', ' . $db->Quote($description). ')';
			
		$result = $db->Execute($sql);
		if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);

		// record this edit
		$data_id = $db->Insert_ID();
		db_record_edit($object_id, 'object', $data_id, $author_id, $ip, $comment);		
	}
}

//--------------------------------------------------------------------------------------------------
/**
 * @brief Record an edit made to database
 *
 * @param object_id Internal object id (a MD5 hash)
 * @param table_name Name of table that has been edited
 * @param row_id Row id (in table) of item being edited
 * @param author_id Internal object id of person or process making edit
 * @param ip IP address of editor
 * @param comment Comment
 *
 */
function db_record_edit ($object_id, $table_name, $row_id, $author_id='', $ip='127.0.0.1', $comment='')
{
	global $config;
	global $db;

	if ('' == $author_id)
	{
		$author_id = $config['owner_id'];
	}

	// Store details of edit (what, who, when)
	$sql ='INSERT INTO edits (object_id, table_name, row_id, author_id, ip, comment)
	VALUES ( ' . $db->Quote($object_id) 
	. ', ' . $db->Quote($table_name) 
	. ', ' . $db->Quote($row_id)
	. ', ' . $db->Quote($author_id)
	. ', ' . 'INET_ATON(\'' . $ip . '\')'
	. ', ' . $db->Quote($comment) . ')';

	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
}



//--------------------------------------------------------------------------------------------------
/**
 * @brief Find object with a given guid
 *
 * @param namespace Identifier namespace (e.g., 'doi');
 * @param identifier Identifier
 *
 * @result Object id if successful, otherwise ''
 *
 */
function db_find_object_with_guid($namespace, $identifier)
{
	global $db;
		
	$object_id = '';
	
	$sql = 'SELECT * FROM object_guid 
		WHERE (namespace = ' . $db->Quote($namespace) . ') 
		AND (identifier = ' . $db->Quote($identifier) . ')
		AND (created <= NOW())
		AND (modified > NOW())
		LIMIT 1';
		
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
	
	if ($result->NumRows() == 1)
	{
		$object_id = $result->fields['object_id'];
	}
	
	return $object_id;
}

//--------------------------------------------------------------------------------------------------
/**
 * @brief Find objects of a given class with a given attribute
 *
 * @param class_id Class id 
 * @param attribute_name Name of attribute
 * @param attribute_value Value of attribute to look for
 *
 * @result Array of objects matching attribute_value
 *
 */
function db_find_objects_with_attribute_value($class_id, $attribute_name, $attribute_value)
{
	global $db;
	
	$debug = 0;
	
	$objects = array();
	
	$attribute = db_attribute_from_name($class_id, $attribute_name);
	
	if (isset($attribute['id']))
	{
	
		$sql = 'SELECT DISTINCT object_id FROM ' . $attribute['datatype'] . '
			WHERE (attribute_id = ' . $attribute['id'] . ')
			AND ('. $attribute['datatype'] . '.value=' . $db->Quote($attribute_value) . ')
			AND (created <= NOW())
			AND (modified > NOW())';
			
		if ($debug)
		{
			echo '<pre style="text-align: left;border: 1px solid #c7cfd5;background: #f1f5f9;padding:15px;">';
			echo "Line: " . __LINE__ . "\n";
			echo $sql;
			echo "</pre>";				
		}

		$result = $db->Execute($sql);
		if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
	
		while (!$result->EOF) 
		{				
			array_push($objects, $result->fields['object_id']);
			$result->MoveNext();	
		}	
	}
	
	return $objects;
}


//--------------------------------------------------------------------------------------------------
/**
 * @brief Retrieve all GUIDs for an object
 *
 * @param object_id Object identifier
 *
 * @return An array of (namespace, identifier) pairs
 */
function db_retrieve_guids($object_id)
{
	global $db;
	
	$guids = array();
	
	$sql = 'SELECT * from object_guid
		WHERE object_id = ' . $db->Quote($object_id) . '
		AND (created <= NOW())
		AND (modified > NOW())';
	
	
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
	
	while (!$result->EOF) 
	{
		$identifier = array(
			'namespace' => $result->fields['namespace'],
			'identifier' => $result->fields['identifier']
			);
		array_push($guids, $identifier);
		$result->MoveNext();	
	}
	
	return $guids;

}


//--------------------------------------------------------------------------------------------------
/**
 * @brief Store a GUID for an object
 *
 */
function db_store_object_guid($object_id, $namespace, $identifier,
		$author_id='', $ip='127.0.0.1', $comment='')
{
	global $db;

	// only add if we don't have this guid
	if ('' == db_find_object_with_guid($namespace, $identifier))
	{
		$sql = 'INSERT INTO object_guid (object_id, namespace, identifier) VALUES ('
		 	. $db->Quote($object_id) . ',' . $db->Quote($namespace) . ',' . $db->Quote($identifier) . ')';
		$result = $db->Execute($sql);
		if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
		
		// record this edit
		$data_id = $db->Insert_ID();
		db_record_edit($object_id, 'object_guid', $data_id, $author_id, $ip, $comment);		
	}
}

//--------------------------------------------------------------------------------------------------
/**
 * @brief Store an attribute value
 *
 * Store an attribute for object, and record this operation in the edit table. The edits are
 *
 * @param class_id Class id
 * @param attribute_name Name of attribute (e.g., "title")
 *
 * @result id of attribute in attributes table
 */
function db_attribute_from_name($class_id, $attribute_name)
{
	global $db;
	
	$attribute = array();

	$sql = 'SELECT * FROM attributes
		WHERE (name = '. $db->Quote($attribute_name) . ') 
		AND (class_id=' . $class_id . ')
		LIMIT 1';

	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
		
	if (1 == $result->NumRows())
	{
		$attribute = array (
			'id' => $result->fields['id'],
			'datatype' => $result->fields['datatype']
			);
	}
	
	return $attribute;
}

//------------------------------------------------------------------------------------
/**
 * @brief Retrive current value of an attribute
 *
 * @param object_id Internal object id (a MD5 hash)
 * @param 
 * @param attribute_table Name of attribute table (one of EAV_Date, EAV_Int, EAV_Memo, EAV_Real, EAV_String)
 * @param attribute_id Attribute id (defined in table "attributes")
 *
 * @return Value of attribute, or '' if attribute not found
 */
function db_retrieve_current_attribute_value($object_id, $attribute_table, $attribute_id)
{
	global $db;
	
	$attribute = '';
	
	$sql = 'SELECT * FROM ' . $attribute_table . ' 
		WHERE (object_id=' . $db->Quote($object_id) . ')
		AND (attribute_id = ' . $attribute_id . ')
		AND (created <= NOW())
		AND (modified > NOW()) LIMIT 1';
		
	//echo $sql;
		
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
	
	if (1 == $result->NumRows())
	{
		$attribute = $result->fields['value'];
	}
	
	return $attribute;
}


//--------------------------------------------------------------------------------------------------
/**
 * @brief Store an attribute value
 *
 * Store an attribute for object, and record this operation in the edit table. The edits are
 * timestamped so we know when they were done, and by whom. If the an attribute of this type
 * for this object already exists, modify the timestamp of the previous value, and insert the
 * new value. This generates a version history that we can reconstruct.
 *
 * @param object_id Internal object id (a MD5 hash)
 * @param attribute_table Name of attribute table (one of EAV_Date, EAV_Int, EAV_Memo, EAV_Real, EAV_String)
 * @param attribute_id Attribute id (defined in table "attributes")
 * @param attribute_value Internal object id (a MD5 hash)
 * @param author_id Internal object id of person or process making edit
 * @param ip IP address of editor
 * @param comment Comment
 */
function db_update_attribute_value ($object_id, $attribute_table, $attribute_id, $attribute_value,
	$author_id='', $ip='127.0.0.1', $comment='')
{
	global $db;

	$sql = 'SELECT * FROM ' . $attribute_table . ' 
		WHERE (object_id=' . $db->Quote($object_id) . ')
		AND (attribute_id = ' . $attribute_id . ')
		AND (created <= NOW())
		AND (modified > NOW()) LIMIT 1';
		
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
	
	if (1 == $result->NumRows())
	{
		// This attribute already exists, so set modified timestamp to now, flagging this
		// value as replaced by a subsequent one.
		$id = $result->fields['id'];
		
		$sql = 'UPDATE ' . $attribute_table . ' SET modified=NOW() 
			WHERE (id= ' . $id . ') AND (attribute_id= ' . $attribute_id . ') AND (object_id = ' . $db->Quote($object_id) . ')';

		$result = $db->Execute($sql);
		if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
	}
	
	// Add value to database. This will be automatically timestamped as created now, with a modified timestamp
	// set to the future.
	$sql ='INSERT INTO ' . $attribute_table . '(object_id, attribute_id, value) 
		VALUES ( ' . $db->Quote($object_id) . ', ' . $attribute_id 
	. ', ' . $db->Quote($attribute_value) . ')';
	
	//echo $sql;
	
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
	
	$data_id = $db->Insert_ID();
	
	db_record_edit($object_id, $attribute_table, $data_id, $author_id, $ip, $comment);
}

//--------------------------------------------------------------------------------------------------
// Return object as an array of elements
function db_retrieve_object($object_id)
{
	global $db;
	
	$object = array();
	$attributes = array();

	$sql = 'SELECT * FROM object
		WHERE (object_id =' . $db->Quote($object_id) . ') LIMIT 1';
	$result = $db->Execute($sql);
	if ($result == false) die("failed: " . $sql);
	
	//echo $sql;
	

	if ($result->NumRows() == 1)
	{
		$object['name'] = $result->fields['name'];
		$object['description'] = $result->fields['description'];
		$object['created'] = $result->fields['created'];
		$object['modified'] = $result->fields['modified'];

		// Get current attributes of this object
		$dataType = array('EAV_Int', 'EAV_String', 'EAV_Date', 'EAV_Real', 'EAV_Memo');
	
		foreach ($dataType as $type)
		{
			$sql = 'SELECT attributes.name, attributes.caption, attributes.datatype, 
				attributes.rdf,
				' . $type . '.value FROM ' . $type . '
				INNER JOIN attributes ON ' . $type . '.attribute_id = attributes.id
			WHERE (object_id = ' . $db->Quote($object_id) . ')
			AND (created <= NOW())
			AND (modified > NOW())';


			$result = $db->Execute($sql);
			if ($result == false) die("failed: " . $sql);

			while (!$result->EOF) 
			{
				$item = array(
					'name' => $result->fields['name'],
					'caption' => $result->fields['caption'],
					'type' => $result->fields['datatype'],
					'value' => $result->fields['value'],
					'rdf' => $result->fields['rdf']	
					);
				array_push($attributes, $item);

				$result->MoveNext();	
			}	
		}
		
		// Sort
		$serial = array();
       	foreach ($attributes as $key => $row) 
        {
                $serial[$key]  = $row['serial_number'];
        }
        array_multisort($serial, SORT_ASC, SORT_NUMERIC, $attributes);

		// store
		$object['attributes'] = $attributes;

	}
	
	return $object;
	
}


//------------------------------------------------------------------------------------
// get localities for object...
function db_get_localities_for_object($object_id, $mysql_polygon_as_text = '')
{
	global $db;
	
	$localities = array();
	
	$sql = 'SELECT AsText(loc) AS pt, locality.object_id, locality.source_id, locality.confidence, object.name
FROM locality
INNER JOIN object USING(object_id)
WHERE (object.object_id = ' . $db->Quote($object_id) . ')
AND (locality.created <= NOW())
AND (locality.modified > NOW())';

	// filter by polgon if wanted...
	if ($mysql_polygon_as_text != '')
	{
		$sql .= ' AND Contains(GeomFromText(\'' . $mysql_polygon_as_text . '\'), loc) = 1';
	}
	
	
//echo $sql;

		$result = $db->Execute($sql);
		if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);

		while (!$result->EOF) 
		{
			$loc = $result->fields['pt'];
			$loc = str_replace('POINT(', '', $loc);
			$loc = str_replace(')', '', $loc);
			$loc = str_replace(' ', ',', $loc);
			list ($x, $y) = split(',', $loc);
			$pt = array($x, $y);		
		
			$locality = array (
				'object_id' => $object_id,
				'source_id' => $result->fields['source_id'],
				'confidence' => $result->fields['confidence'],
				'name' => $result->fields['name'],
				'pt' => $result->fields['pt'],
				'xy' => $pt
				);
			array_push($localities, $locality);
		
		
		
			$result->MoveNext();	
		}

	
	return $localities;
	
}


//--------------------------------------------------------------------------------------------------
// insert a point locality associated with an object
function db_store_object_point_locality($object_id, $latitude, $longitude,
	$source_id ='', $confidence = -1,
	$author_id='', $ip='127.0.0.1', $comment='', $woeid = 0)
{
	global $db;


	// only insert if we don't have this point locality for this object
	$sql = "SELECT * FROM locality WHERE (loc = GeomFromText('POINT(" . $longitude . " " . $latitude . ")') )
	AND (object_id = " . $db->Quote($object_id)  .")";
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
	
	if ($result->NumRows() == 0)
	{
		if ($source_id == '')
		{
			$source_id = $object_id; // object is geotagged
		}
	
		$sql =  "INSERT INTO locality(object_id, source_id, loc, confidence, woeid) VALUES ("
			. $db->Quote($object_id) 
			. ","  . $db->Quote($source_id) 
			. ", GeomFromText('POINT(" . $longitude . " " . $latitude . ")')"
			. ", " . $confidence 
			. ", " . $woeid . ")";
		$result = $db->Execute($sql);
		if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);		
	}	
}


//--------------------------------------------------------------------------------------------------
// media
// crude grab media file and dump it to browser...
function db_get_media($object_id)
{
	global $db;

	$sql = 'SELECT * FROM images WHERE (object_id=' . $db->Quote($object_id) . ')';
	$result = $db->Execute($sql);
	if ($result == false) die("failed");  

	header('Content-type: ' . $result->fields['mimetype']);
	echo $result->fields['blob'];
}




?>