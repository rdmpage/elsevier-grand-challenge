<?php

// $Id: $

// Note that for IE7 getElementTextNS (in pygmy.js) dies if node has no content
// so if, for example, taxon has no common name, we set it to '[none]'

require_once('../config.inc.php');
require_once($config['adodb_dir']);

global $config;
global $ADODB_FETCH_MODE;
		
$db = NewADOConnection('mysql');
$db->Connect("localhost", 
	$config['db_user'], $config['db_passwd'], $config['db_name']);
	
// Ensure fields are (only) indexed by column name
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

function getCommonName($id)
{
	global $db;
	
	$common_name = '';

	$sql = 'SELECT * FROM ncbi_names
		WHERE (name_class = "genbank common name")
		AND (tax_id = ' . $id . ')
		LIMIT 1';
	$result = $db->Execute($sql);
	if ($result == false) die("failed: $sql"); 
	
	if ($result->NumRows() == 1)
	{
		$common_name = htmlspecialchars($result->fields['name_txt']); 
	}
		
	return $common_name;

}




function getNode($id)
{
	global $db;
	$node = new stdClass;
	$node->children = array();
	$node->lineage = array();
	
		
	$sql = 'SELECT * FROM ncbi_nodes
				INNER JOIN ncbi_names USING (tax_id) 
				WHERE ncbi_nodes.tax_id=' . $id . '
				AND ncbi_names.name_class="scientific name"
				LIMIT 1';

	$result = $db->Execute($sql);
	if ($result == false) die("failed: $sql"); 
	
	if ($result->NumRows() == 1)
	{
		$node->id = $result->fields['tax_id'];
		$node->name = trim($result->fields['name_txt']);
		$node->commonName = getCommonName($id);
		$node->rank = $result->fields['rank'];
		$node->parentId = $result->fields['parent_tax_id'];
	}	
	
	// children
	$sql = 'SELECT * 
		FROM ncbi_nodes 
		INNER JOIN ncbi_names USING (tax_id) 
		WHERE parent_tax_id=' . $id . '
		AND ncbi_names.name_class="scientific name"
		ORDER BY ncbi_names.name_txt ';
	
	$result = $db->Execute($sql);
	if ($result == false) die("failed: $sql");  
	
	while (!$result->EOF) 
	{
		if ($result->fields['tax_id'] != $id)
		{
			$child = new stdClass;
			
			$child->id = $result->fields['tax_id'];
			$child->name = trim($result->fields['name_txt']);
			$child->commonName = getCommonName($result->fields['tax_id']);
			$child->rank = $result->fields['rank'];
			
			array_push($node->children, $child);

		}

		$result->MoveNext();
	}
	
	
	// lineage
	$curnode_id = $id;
	while($curnode_id != 1)
	{
		$sql = 'SELECT * 
			FROM ncbi_nodes 
			INNER JOIN ncbi_names USING (tax_id) 
			WHERE ncbi_nodes.tax_id=' . $curnode_id . '
			AND ncbi_names.name_class="scientific name"
			LIMIT 1';
			
		$result = $db->Execute($sql);
		if ($result == false) die("failed: $sql");  
		if ($result->NumRows() == 1)
		{
			$ancestor = new stdClass;
			
			$ancestor->id = $result->fields['tax_id'];
			$ancestor->name = trim($result->fields['name_txt']);
			$ancestor->commonName = getCommonName($result->fields['tax_id']);
			$ancestor->rank = $result->fields['rank'];
			
			array_push($node->lineage, $ancestor);
			
			$curnode_id = $result->fields['parent_tax_id'];			
		}
	}

	// Push root onto the end of the lineage
	$ancestor->id = '1';
	$ancestor->name = 'root';
	$ancestor->commonName = '';
	$ancestor->rank = '';
	
	array_push($node->lineage, $ancestor);

	// reverse it 			
	$node->lineage = array_reverse($node->lineage);
	
	
	return $node;
}


$id = $_GET['id'];


$obj = getNode($id);
//header ("Content-type: plain/text");
//print_r($obj);
echo '(' . json_encode($obj) . ')';
?>

