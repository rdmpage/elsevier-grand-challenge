<?php

// $Id: $

/**
 * @file index.php
 *
 * Reflect services
 *
 */
 
// Make sure includes are absolute paths
$rootdir = dirname(__FILE__);
$rootdir = preg_replace('/reflect$/', "", $rootdir);

require_once($rootdir . 'config.inc.php');
require_once($config['adodb_dir']);

$db = NewADOConnection('mysql');
$db->Connect("localhost", 
	$config['db_user'], $config['db_passwd'], $config['db_name']);

// Ensure fields are (only) indexed by column name
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

$html = '';

$tax_id = 0;

if (isset($_GET['tax_id']))
{
	$tax_id = $_GET['tax_id'];
}

if ($tax_id != 0)
{
	$sql = 'SELECT * FROM ncbi_names WHERE tax_id = ' . $tax_id;

	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __LINE__ . "]: " . $sql);
	
	if ($result->NumRows() == 0)
	{
		$html = '<p>' . $tax_id . ' is not a recognised NCBI taxonomy identifier!</p>';
	}
	else
	{
		$header = '';
		
		$html = '<table border="1">';
		$html .= '<tr><th>Name</th><th>Name class</th></tr>';
		while (!$result->EOF) 
		{
			$html .= '<tr><td>' . $result->fields['name_txt'] . '</td><td>' . $result->fields['name_class'] . '</td></tr>';
			
			if ($result->fields['name_class'] == 'scientific name')
			{
				$header = '<h1>' . $result->fields['name_txt'] . '</h1>';
			}
			$result->MoveNext();	
		}
		$html .= '</table>';
		$html = $header . $html;
	}
}
else
{
	$html = '<p>To use this service you must supply a NCBI taxonomy identifier, e.g. <a href="?tax_id=9606">http://iphylo.org/~rpage/challenge/reflect/?tax_id=9606</a></p>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Reflect Taxonomy Service</title>
	<meta name="generator" content="BBEdit 9.0" />
</head>
<body>
<?php echo $html; ?>
</body>
</html>