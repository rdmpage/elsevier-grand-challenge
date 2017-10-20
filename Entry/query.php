<?php

// $Id: $

/**
 * @file queries.php
 *
 * Queries to EAV that are domain-specific
 *
 */
 
// Make sure includes are absolute paths
$rootdir = dirname(__FILE__) . '/';

require_once($rootdir . 'config.inc.php');
require_once($rootdir . 'eav/eav.php');
require_once($rootdir . 'object_factory.php');
require_once($rootdir . 'spatial.php');




//--------------------------------------------------------------------------------------------------
// Taxonomically contained studies

function contained_studies($object_id)
{
	global $db;
	$hits = array();
	
	// Get span of study (min left and max right ids from NCBI tree
	
	$sql = 'SELECT MIN(ncbi_tree.left_id) AS left_id, MAX(ncbi_tree.right_id) AS right_id FROM object_link AS xy
INNER JOIN object_link AS yz ON xy.target_object_id = yz.source_object_id
INNER JOIN object ON object.object_id = yz.target_object_id
INNER JOIN object_guid ON yz.target_object_id = object_guid.object_id
INNER JOIN ncbi_tree ON ncbi_tree.tax_id = object_guid.identifier
WHERE xy.source_object_id = ' . $db->Quote($object_id) . '
AND xy.relationship_id = ' . RELATION_REFERENCES . '
AND yz.relationship_id = ' . RELATION_SOURCE . '
AND object_guid.namespace="taxid"
LIMIT 1';

//echo "$sql\n";


	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
		
	if (($result->NumRows() == 1) and ($result->fields['left_id'] != ''))
	{
		// Get LCA of span of study
		
		$sql = 'SELECT * from ncbi_tree
		WHERE (left_id <= ' . $result->fields['left_id'] . ') AND (right_id >= ' . $result->fields['right_id'] . ')
		ORDER BY left_id DESC LIMIT 1';
		
		//echo "$sql\n";

		$result = $db->Execute($sql);
		if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);

		if ($result->NumRows() == 1)
		{
			$lca = $result->fields['path'];	
			
			// Find
		
			$sql = 'SELECT y.source_object_id AS study, object.name, MAX(ncbi_tree.left_id) - MIN(ncbi_tree.left_id) AS s
FROM object_link 
INNER JOIN object_link AS y ON object_link.source_object_id = y.target_object_id
INNER JOIN object ON object.object_id = y.source_object_id
INNER JOIN object_guid ON object_link.target_object_id = object_guid.object_id
INNER JOIN ncbi_tree ON ncbi_tree.tax_id = object_guid.identifier
WHERE (ncbi_tree.path LIKE ' . $db->Quote($lca . '/%') . ')
AND object_link.relationship_id = ' . RELATION_SOURCE . '
AND y.relationship_id = ' . RELATION_REFERENCES . '
GROUP BY y.source_object_id
ORDER BY s DESC
LIMIT 5';

		//echo "$sql\n";


			$result = $db->Execute($sql);
			if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
	
			while (!$result->EOF) 
			{
				$link = array(
					'object_id' => $result->fields['study'],
					'name' => $result->fields['name']
					);
					
				array_push($hits, $link);
				$result->MoveNext();	
			}
		}
	}
	
	// This doesn't work
	//$hits = array_unique ($hits);
		
	return $hits;	

}





//--------------------------------------------------------------------------------------------------
// Return list of localities connected (directly or indirectly) to this object
function object_localities($id, $mysql_polygon_as_text = '')
{
	
	// Create object
	$o = object_factory($id);
	$o->Retrieve();
	
	//$o->Dump();
	
	$locs = array();
	
	switch ($o->GetType())
	{
		case CLASS_REFERENCE:
		
			// localities linked directly to this reference			
			$locs = db_get_localities_for_object($id, $mysql_polygon_as_text);
			
			// sequences 
			$incoming = db_outgoing_links($id, RELATION_REFERENCES, CLASS_GENBANK);
			foreach ($incoming as $link)
			{
				$l = db_get_localities_for_object($link['object_id'], $mysql_polygon_as_text);
				$locs = array_merge($locs, $l);
				
				// specimen linked to this sequence?
				$vouchers = db_incoming_links($link['object_id'], RELATION_VOUCHER_FOR, CLASS_SPECIMEN);
				
				if (count($vouchers) > 0)
				{
					$l = db_get_localities_for_object($vouchers[0]['object_id'], $mysql_polygon_as_text);
					$locs = array_merge($locs, $l);
				}
				
				
			}
			// specimens 
			$incoming = db_outgoing_links($id, RELATION_REFERENCES, CLASS_SPECIMEN);
			foreach ($incoming as $link)
			{
				$l = db_get_localities_for_object($link['object_id'], $mysql_polygon_as_text);
				$locs = array_merge($locs, $l);
			}
			break;
			
		case CLASS_TAXON_NAME:
			// sequences 
			$incoming = db_incoming_links($id, RELATION_SOURCE, CLASS_GENBANK);
			foreach ($incoming as $link)
			{
				$l = db_get_localities_for_object($link['object_id'], $mysql_polygon_as_text);
				$locs = array_merge($locs, $l);
				
				// specimen linked to this sequence?
				$vouchers = db_incoming_links($link['object_id'], RELATION_VOUCHER_FOR, CLASS_SPECIMEN);
				
				if (count($vouchers) > 0)
				{
					$l = db_get_localities_for_object($vouchers[0]['object_id'], $mysql_polygon_as_text);
					$locs = array_merge($locs, $l);
				}
				
				
			}
			break;
			
		case CLASS_GENBANK:
			// localities linked directly to this sequence			
			$locs = db_get_localities_for_object($id, $mysql_polygon_as_text);
		
			
			// specimen linked to this sequence?
			$vouchers = db_incoming_links($id, RELATION_VOUCHER_FOR, CLASS_SPECIMEN);
			
			if (count($vouchers) > 0)
			{
				$l = db_get_localities_for_object($vouchers[0]['object_id']);
				$locs = array_merge($locs, $l);
			}
			break;
		
			
		default:
		
			// Localities directly linked to object
			$locs = db_get_localities_for_object($id, $mysql_polygon_as_text);
			break;
	}

	// Make unique (see http://uk2.php.net/manual/en/function.array-unique.php#84750 )
    foreach ($locs as &$myvalue)
    { 
        $myvalue=serialize($myvalue); 
    } 
    $locs=array_unique($locs); 

    foreach ($locs as &$myvalue)
    { 
        $myvalue=unserialize($myvalue); 
    } 

	return $locs;
}



//--------------------------------------------------------------------------------------------------
// Return convex hull bounding object as an array of points
function object_bounding_polygon($id)
{
	$polygon = array();
	
	$just_points = array();
	$locs = object_localities($id);
	foreach($locs as $loc)
	{
		array_push($just_points, $loc['xy']);
	}

	if (count($just_points) > 2)
	{
		$polygon = convex_hull($just_points);
	}
	
	return $polygon;
}

//--------------------------------------------------------------------------------------------------
// Objects within this polygon
function objects_in_polygon($mysql_polygon_as_text, $limit = 0)
{
	global $db;
	$hits = array();
	
	$sql = 'SELECT object_id, object.name, AsText(extent) AS poly FROM object_polygon
INNER JOIN object USING(object_id)
WHERE Intersects(GeomFromText(\'' . $mysql_polygon_as_text . '\' ), extent) = 1';

	if ($limit != 0)
	{
		$sql .= ' LIMIT ' . $limit;
	}
	
	//echo $sql;

	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);

	while (!$result->EOF) 
	{
		$link = array(
			'object_id' => $result->fields['object_id'],
			'name' => $result->fields['name'],				
			'poly' => $result->fields['poly'],				
			);
			
		array_push($hits, $link);
		$result->MoveNext();	
	}
	return $hits;
}



//--------------------------------------------------------------------------------------------------
// Objects overlapping this object
function extent_intersects ($object_id, $limit = 0)
{
	global $db;
	$hits = array();
	$object_extent = '';
	
	// 1. get extent for this object
	$sql = 'SELECT AsText(extent) AS poly FROM object_polygon 
		WHERE (object_id = ' . $db->Quote($object_id) . ') LIMIT 1';
		
	//echo $sql;
		
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
		
	if ($result->NumRows() == 1)
	{
		$object_extent = $result->fields['poly'];
		
		$hits = objects_in_polygon($object_extent, $limit);
	}
	

	// This takes far too long, and I'm notconvinced that DICE is the best measure
	// would need to build a proper index (sigh)
	if (0)
	{
		// OK, we now have objects that interseact our query rectangle,
		// but we've no sense of how much the overlap with the target
		if (count($hits) > 0)
		{
		
			$A = count(object_localities($object_id));
		
			foreach ($hits as $h)
			{
				$B = count(object_localities($h['object_id']));
				
				// Filter by polygons
				// A is the target object
				// B is the object in the list of hits
				$locsAinB = object_localities($object_id, $h['poly']);
				$locsBinA = object_localities($h['object_id'], $object_extent);
				
				echo "A=$A B=$B\n";
				echo "$object_id A in B = " . count($locsAinB) . " " . $h['poly'] . "\n";
				echo $h['object_id'] ." B in A = " . count($locsBinA) . " " . $object_extent . "\n";
				echo "----------------\n";
				
				$AinB = count($locsAinB);
				$BinA = count($locsBinA);
				
				$dice =($AinB + $BinA)/($A + $B);
				
				
				// Store results?...
				$sql = 'INSERT INTO dice(object_A_id, object_B_id, A, B,AinB, BinA, d) VALUES (' 
					. $db->Quote($object_id) 
					. ',' . $db->Quote($h['object_id'])
					. ',' . $A
					. ',' . $B
					. ',' . $AinB
					. ',' . $BinA
					. ',' . $dice
					.')';
					
				$result = $db->Execute($sql);
				if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
		
		
			}
			
			
		}
	}
	
	return $hits;	
}		


	


//--------------------------------------------------------------------------------------------------
/*

  +->y
 /
x
 \
  +->z

*/
function x2y_x2z ($x_id, $xy_relationship_id, $xz_relationship_id)
{
	global $db;

	$hits = array();
	
	$sql = 'SELECT DISTINCT(xz.target_object_id), object.name FROM object_link AS xy
	INNER JOIN object_link AS xz ON xy.source_object_id = xz.source_object_id
	INNER JOIN object ON object.object_id = xz.target_object_id
	WHERE xy.target_object_id = ' . $db->Quote($x_id) .'
	AND xy.relationship_id = ' . $xy_relationship_id . '
	AND xz.relationship_id = ' . $xz_relationship_id;
	
	
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);

	while (!$result->EOF) 
	{
		$link = array(
			'object_id' => $result->fields['target_object_id'],
			'name' => $result->fields['name']					
			);
			
		array_push($hits, $link);
		$result->MoveNext();	
	}
	
	return $hits;	
	
}

//--------------------------------------------------------------------------------------------------
/*

 x --> y --> z
 
*/
function x2y_y2z ($x_id, $xy_relationship_id, $yz_relationship_id)
{
	global $db;

	$hits = array();
	
	$sql = 'SELECT DISTINCT(yz.target_object_id), object.name FROM object_link AS xy
INNER JOIN object_link AS yz ON xy.target_object_id = yz.source_object_id
INNER JOIN object ON object.object_id = yz.target_object_id
WHERE xy.source_object_id = ' . $db->Quote($x_id) .'
AND xy.relationship_id = ' . $xy_relationship_id . '
AND yz.relationship_id = ' . $yz_relationship_id;
	
	
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);

	while (!$result->EOF) 
	{
		$link = array(
			'object_id' => $result->fields['target_object_id'],
			'name' => $result->fields['name']					
			);
			
		array_push($hits, $link);
		$result->MoveNext();	
	}
	
	return $hits;	
	
}


	

//--------------------------------------------------------------------------------------------------
// Studies that include this taxon (by having sequences)
//
//  taxon <--source-- genbank <--references-- reference
//
function query_studies_for_taxon($taxon_id)
{
	global $db;
	
	$studies = array();
	
	$sql = 'SELECT DISTINCT(y.source_object_id) AS study, object.name FROM object_link 
	INNER JOIN object_link AS y ON object_link.source_object_id = y.target_object_id
	INNER JOIN object ON object.object_id = y.source_object_id
	WHERE object_link.target_object_id = ' . $db->Quote($taxon_id) . '
	AND object_link.relationship_id = ' . RELATION_SOURCE . '
	AND y.relationship_id = ' . RELATION_REFERENCES;
	
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);

	while (!$result->EOF) 
	{
		$link = array(
			'object_id' => $result->fields['study'],
			'name' => $result->fields['name']					
			);
			
		array_push($studies, $link);
		$result->MoveNext();	
	}
	
	return $studies;	
	
}
	


//--------------------------------------------------------------------------------------------------
/**
 * @brief Number of papers two people have coauthored
 * *
 * @param author1_id Object id of one author
 * @param author2_id Object id of second author
 *
 * @return Number of papers coauthored
 */
function query_coauthored($author1_id, $author2_id)
{
	global $db;
	
	$count = 0;
	
	$sql = 'SELECT COUNT(object_link.target_object_id) AS c FROM object_link
		INNER JOIN object_link AS ol2 ON object_link.target_object_id = ol2.target_object_id
		WHERE (object_link.source_object_id = ' . $db->Quote($author1_id) . ')
		AND (ol2.source_object_id = ' . $db->Quote($author2_id) . ')';
		
	//echo $sql;
	
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
	
	if ($result->NumRows() == 1)
	{
		$count = $result->fields['c'];
	}
	
	return $count;
	
}

//------------------------------------------------------------------------------------

// find objects that are colinked with this object, such as coauthors
function query_colinks ($object_id, $relationship_id = 0, $source_class_id = 0, $target_class_id = 0, $limit=0)
{
	global $db;
	
	$colinks = array();
	
	$lastname_id = 0;
	$forename_id = 0;
	
	if ((CLASS_PERSON == $source_class_id) and (RELATION_AUTHOR_OF == $relationship_id))
	{
		$a = db_attribute_from_name(CLASS_PERSON, 'lastname');
		if (0 < count($a))
		{
			$lastname_id = $a['id'];
		}
		$a = db_attribute_from_name(CLASS_PERSON, 'forename');
		if (0 < count($a))
		{
			$forename_id = $a['id'];
		}
	}
	
	
	$sql = 'SELECT colinked.source_object_id, COUNT(colinked.source_object_id) as c, object.name, colinked.relationship_id, object.class_id';
	
	if (0 != $lastname_id)
	{
		$sql .= ', e1.value AS lastname, e2.value AS forename';
	}
	
	
	$sql .= ' FROM object_link
	INNER JOIN object_link as colinked ON object_link.target_object_id = colinked.target_object_id
	INNER JOIN object ON object.object_id = colinked.source_object_id 
	INNER JOIN object AS target ON target.object_id = colinked. target_object_id ';
	
	if (0 != $lastname_id)
	{
		$sql .= 'INNER JOIN EAV_String AS e1 ON e1.object_id = colinked.source_object_id
		INNER JOIN EAV_String AS e2 ON e2.object_id = colinked.source_object_id ';
	}
	
	
	$sql .= ' WHERE object_link.source_object_id = ' . $db->Quote($object_id) . '
	AND colinked.source_object_id <> ' . $db->Quote($object_id);
	
	
	
	// Do we want specific classes of objects as the sources?
	if (0 != $source_class_id)
	{
		$sql .= ' AND (object.class_id=' . $source_class_id . ')';
	}
	// Do we want specific classes of objects as the targets?
	if (0 != $target_class_id)
	{
		$sql .= ' AND (target.class_id=' . $target_class_id . ')';
	}


	// Do we want specific kinds of relationships?
	if (0 != $class_id)
	{
		$sql .= ' AND (object_link.relationship_id=' . $relationship_id . ')';
		$sql .= ' AND (colinked.relationship_id=' . $relationship_id . ')';
	}
	
	if (0 != $lastname_id)
	{
		$sql .= ' AND (e1.attribute_id=' . $lastname_id . ')';
		$sql .= ' AND (e2.attribute_id=' . $forename_id . ')';
	}
	
	$sql .= ' AND (object_link.created <= NOW())
	AND (object_link.modified > NOW())
	GROUP BY colinked.source_object_id ';
	
	if (0 != $lastname_id)
	{
		$sql .= 'ORDER BY lastname';
	}
	else
	{
		$sql .= 'ORDER BY object.name';
	}
	
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
			'object_id' => $result->fields['source_object_id'],
			'name' => $result->fields['name'],
			'type' => $result->fields['relationship_id'],
			'class_id' => $result->fields['class_id'],
			'count' => $result->fields['c'],						
			);
			
		if (0 != $lastname_id)
		{
			$link['lastname'] = $result->fields['lastname'];
			$link['forename'] = $result->fields['forename'];
		}
			
			
			
		array_push($colinks, $link);
		$result->MoveNext();	
	}
	
	return $colinks;	
	
}




?>