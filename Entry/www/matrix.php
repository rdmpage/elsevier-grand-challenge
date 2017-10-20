<?php

// Create a data matrix for a study
// To do -- handle case where multiple sequences exist for same gene for same taxon

require_once('../query.php');

function get_matrix_js($object_id)
{
	global $config;
	global $db;
	$html = '';
	
	$sql = 'SELECT y.name as accession, z.name as gene, w.name as taxon  
FROM object_link AS xy
INNER JOIN object_link AS yz ON xy.target_object_id = yz.source_object_id
INNER JOIN object AS y ON yz.source_object_id = y.object_id
INNER JOIN object AS z ON yz.target_object_id = z.object_id
INNER JOIN object_link AS yw ON xy.target_object_id = yw.source_object_id
INNER JOIN object AS w ON yw.target_object_id = w.object_id
WHERE xy.source_object_id = ' . $db->Quote($object_id) . '
AND (y.class_id = 9)
AND (z.class_id = 10)
AND (w.class_id = 8)
ORDER BY accession, taxon, gene';


	$rows = array();
	$cols = array();
	$cells = array();
	$data = array();

	$result = $db->Execute($sql);
	if ($result == false) die("failed $sql");  
	
	while (!$result->EOF) 
	{
//		$gene = str_replace(' ', '&nbsp;', $result->fields['gene']);
		$gene = $result->fields['gene'];
		array_push($data, array(
			$result->fields['accession'],
			$gene,
			$result->fields['taxon']
			)
			);
		if (!in_array($result->fields['taxon'], $rows))
		{
			array_push($rows, $result->fields['taxon']);
			$cells[$result->fields['taxon']] = array();
		}
		if (!in_array($gene, $cols))
		{
			array_push($cols, $gene);
		}
		$result->MoveNext();
	}
	
	
	foreach ($rows as $taxon)
	{
		foreach ($cols as $gene)
		{
			$cells[$taxon][$gene] = '';
		}
	}
	
	if (count($rows) == 0)
	{
		return '';
	}
	
	// Make
	
	foreach ($data as $d)
	{
		//print_r($d);
		if ($cells[$d[2]][$d[1]] == '')
		{
			$cells[$d[2]][$d[1]] = $d[0];
		}
		else
		{
			// Multiple sequences for this taxon/gene
			
		}
		
	}
	
	

	
/*	echo '<pre>';
	print_r($rows);
	print_r($cols);
	print_r($cells);
//	print_r($data);
	echo '</pre>';*/
	
	// dump to js
	
/*
rows = new Array("aus", "bus", "cus", "dus", "eus", "fus");
cols = new Array("cytb", "rag-1", "COX1", "12S&nbsp;rRNA");
num_cols = cols.length;
num_rows = rows.length;

cells = new Array(num_rows);
cells[0] = new Array();
cells[0][0] = '';
for (j=0; j< num_cols; j++)
{
	cells[0][j+1] = cols[j];
}
	
// populate
cells[1] = new Array(rows[0], "AF32455","EF56190","", "<select><option>U62390</option></select>");
cells[2] = new Array(rows[1], "AF456455","","", "U62390");
cells[3] = new Array(rows[2], "","","EF56190", "AY62390");
cells[4] = new Array(rows[2], "","","EF56190", "AY62390");
cells[5] = new Array(rows[2], "","","EF56190", "AY62390");
cells[6] = new Array(rows[2], "NC_12333","AY76666","EF56190", "AY62390");


*/

	

	$count = 0;
	$html .= "rows = new Array(";
	foreach ($rows as $r)
	{	
		if ($count == 0)
		{
			$count++;
		}
		else
		{
			$html .=  ",";
		}
		$html .=  '"' . $r . '"';
	}
	$html .=  ");\n";
	$count = 0;
	$html .=  "cols = new Array(";
	foreach ($cols as $r)
	{	
		if ($count == 0)
		{
			$count++;
		}
		else
		{
			$html .=  ",";
		}
		$html .=  '"' . $r . '"';
	}
	$html .=  ");\n";
	
	$html .=  'num_cols = cols.length;
num_rows = rows.length;

cells = new Array(num_rows);
cells[0] = new Array();
cells[0][0] = \'\';
for (j=0; j< num_cols; j++)
{
	cells[0][j+1] = cols[j];
}';
	$html .=  "\n";

	$count = 1;
	foreach ($cells as $c)
	{
		$html .=  "cells[$count] = new Array(rows[";
		$html .=  $count-1;
		$html .=  "]";
		
		foreach ($c as $k=>$v)
		{
			$html .=  ',"' . $v . '"';
		}
		
		$html .=  ");\n";
		$count++;
		
	}
	
	$html .= '</script>';
	
	$height = min(count($rows) * 5, 400);
	
	
	$html .= '<table cellspacing="0" cellpadding="0" border="0" style="width:425px;height:' . $height . 'px;border-right:1px rgb(192,192,192) solid;border-bottom:1px rgb(192,192,192) solid;  ">';
	$html .= '<tr>';
	
	// top left corner cell
	$html .= '<td id="cell0-0" onmouseover="expand_cell(this,0,0);" class="header"><img src="images/transparent1x1.png" width="100" height="1" class="cell_image_spacer"/></td>';
	
	// rest of column cells (the column headers)
	$j = 1;
	$i = 0;
	foreach ($cols as $c)
	{
		$html .= '<td id="cell' . $i . '-' . $j . '" "onmouseover="expand_cell(this,' . $i . ',' . $j . ');" class="fisheye_header"></td>';
		$j++;
	}
	$html .= '</tr>';
	
	// The rows, number 1,..,n (0 is the column header row)
	$i = 1;
	foreach ($cells as $c)
	{
		$html .= '<tr>';
		
		// column 0 will have the taxon name
		$j = 0;
		$html .= '<td style="width:100px;" id="cell' . $i . '-' . $j . '" onmouseover="expand_cell(this,' . $i . ',' . $j . ');" class="fisheye_header" ></td>';
		
		// data cells
		$j = 1;
		foreach ($c as $k=>$v)
		{		
			$tdHtml = '<td  id="cell' . $i . '-' . $j . '" "onmouseover="expand_cell(this,' . $i . ',' . $j . ');"';
			if ($v != '')
			{
				if (($i == 0) || ($j == 0))
				{
					$tdHtml .= ' class="fisheye_header" ';
				}
				else
				{
					$tdHtml .= ' class="fisheye_data" onclick="fisheye_cell_click(' . $i . ', ' . $j . ');" ';
				}
			}
			else
			{
				$tdHtml .= ' class="fisheye" ';
			}
			
			$tdHtml .= '>';
			$tdHtml .= '';
			if (($i==0) && ($j == 0))
			{
				$tdHtml .= '<img src="images/transparent1x1.png" width="100" height="1" class="cell_image_spacer"/>';
			}
			$tdHtml .= '</td>';
			$html .= $tdHtml;
			$j++;
			
		}
		$html .= '</tr>';
		$i++;
	}
$html .= '</table>';
	
		
	return $html;
}

//echo get_matrix_js('6615b63a20f47c5033d8037a923b9f03');


?>