<?php

// Base HTML render (extend this for each object we want to display)

require_once('class_object2html.php');
require_once('matrix.php');
require_once('../query.php');
require_once('tms.php');

//------------------------------------------------------------------------------
class Reference2Html extends Object2Html
{	
	var $items = array();
	var $one_name = '';
	var $ref_count = 0;
	
	function HeadExtra()
	{
		$this->mHtml .= '
<script type="text/javascript">

var cells;
var rows;
var cols;

var num_cols;
var num_rows;

var last_col = -1;
var last_row = -1;


//--------------------------------------------------------------------------------------------------
function fisheye_cell_click(i,j)
{
	var url = \'genbank/\' + cells[i][j];
	//alert(url);
	document.location = url;
}

//--------------------------------------------------------------------------------------------------
function expand_column_header(column)
{
	id = \'cell0-\' + column;
	$(id).innerHTML = \'<img src="images/transparent1x1.png" width="100" height="1"  class="cell_image_spacer" />\';
	$(id).innerHTML += cells[0][column];
	$(id).addClassName(\'fisheye_selected_header\');
}

//--------------------------------------------------------------------------------------------------
function expand_row_header(row)
{
	id = \'cell\' + row + \'-0\';
	$(id).innerHTML = \'<img src="images/transparent1x1.png" width="100" height="1" class="cell_image_spacer" />\';
	$(id).innerHTML += cells[row][0];
	$(id).addClassName(\'fisheye_selected_header\');
}

//--------------------------------------------------------------------------------------------------
function collapse_column_header(column)
{
	id = \'cell0-\' + column;
	$(id).innerHTML = \'\';
	if (column == 0)
	{
		$(id).innerHTML = \'<img src="images/transparent1x1.png" width="100" height="1" class="cell_image_spacer"/>\';
	}
	$(id).removeClassName(\'fisheye_selected_header\');
}

//--------------------------------------------------------------------------------------------------
function collapse_row_header(row)
{
	id = \'cell\' + row + \'-0\';
	$(id).innerHTML = \'\';
	if (row == 0)
	{
		$(id).innerHTML = \'<img src="images/transparent1x1.png" width="100" height="1" class="cell_image_spacer"/>\';
	}
	
	$(id).removeClassName(\'fisheye_selected_header\');
}

//--------------------------------------------------------------------------------------------------
function expand_cell(cell, i, j)
{
	if ((last_row != -1) && (last_col != -1))
	{
		// We have been looking at another cell
		
		//$(\'status\').innerHTML = "previous cell " + i + "," + j;
	
		// Collapse previous cell
		if ((last_row != 0) && (last_col != 0))
		{
			collapse_cell(last_row, last_col);
			//$(\'status\').innerHTML = "collapse cell " + last_row + "," + last_col;
		}
		
		// If highlighted cell is in a different column we collapse previous column header
		if (last_col != j)
		{
			// Collapse previous column header
			collapse_column_header(last_col);
			//$(\'status\').innerHTML = "collapse column header " + i + "," + j;
			
			expand_column_header(j);
		}
		
		// If highlighted cell is in a different row we collapose previous row header
		if (last_row != i)
		{
			// Collapse previous row 
			collapse_row_header(last_row);
						
			// Expand new row
			expand_row_header(i);
			
		}
		
	}
	else
	{
		expand_column_header(j);
		expand_row_header(i);
	}
		

	// Set current cell contents
	cell.innerHTML = \'<img src="images/transparent1x1.png" width="100" height="1"  class="cell_image_spacer"/>\';


//	cell.innerHTML += \'<a href="genbank/\' + cells[i][j] + \'">\' + cells[i][j] + \'</a>\';
//	cell.innerHTML += \'<span onclick="alert(\\\'hi\\\');" style="border:1px solid yellow;">\' + cells[i][j] + \'</span>\';
	cell.innerHTML += cells[i][j];
	
//	$(\'i\').innerHTML = i;
//	$(\'j\').innerHTML = j;
	
	last_col = j;
	last_row = i;
}

//--------------------------------------------------------------------------------------------------
function collapse_cell(i, j)
{
	id = \'cell\' + i + \'-\' + j;
	$(id).innerHTML = \'\';
	
//	$(\'i\').innerHTML = i;
//	$(\'j\').innerHTML = j;
}
</script>';		
	}
		
	
	function EndPage()
	{


		parent::EndPage();
	}	
	
	function MainStart()
	{	
		$this->mHtml .= html_top();
		$this->mHtml .= '<div id="main-content-container">';
		
		$this->mHtml .= '<div>';
		
		
		$this->mHtml .= '<table>';
		$this->mHtml .= '<tr>';
		$this->mHtml .= '<td valign="top" align="center">';
		
		
		$issn = $this->mObject->GetAttributeValue('issn');
		if ($issn != '')
		{
			$image_url = issn_image($issn);
			if ($image_url != '')
			{
				$this->mHtml .= '<img src="' . $image_url . '" height="128" />';
			}
			else
			{
				$this->mHtml .= '<img src="images/issn/unknown.png" height="128" />';
			}
		}
		$this->mHtml .= '</td>';
		$this->mHtml .= '<td valign="top">';

		$this->mHtml .= '<span style="display:block;font-size:18px;">' . $this->mObject->GetTitle() . '</span>';
		$this->mHtml .= '<p class="explain">is a journal article</p>';
		
		
		$this->mHtml .='<i>';		
		if ($issn != '')
		{
			$journal_id = db_find_object_with_guid('issn', $issn);
			$this->mHtml .= '<a href="uri/' . $journal_id . '">';
		}
		$this->mHtml .= $this->mObject->GetAttributeValue('title');
		if ($issn != '')
		{
			$this->mHtml .= '</a>';
		}
		$this->mHtml .='</i>';
		
		$this->mHtml .= ' ' . $this->mObject->GetAttributeValue('volume');
		$this->mHtml .= ': ' . $this->mObject->GetAttributeValue('spage');
		$this->mHtml .= ' (' . year_from_date($this->mObject->GetAttributeValue('year')) .')';
		$this->mHtml .= '<br/>';
		
		// authors		
		$authors = db_incoming_links($this->mObject->GetObjectId(), RELATION_AUTHOR_OF, CLASS_PERSON);
		foreach ($authors as $link)
		{
			$this->mHtml .= '<span style="display:inline;border: 1px solid blue;padding: 2px; margin:2px;line-height:22px;background-color:rgb(240,240,240);-webkit-border-bottom-left-radius: 4px 4px; -webkit-border-bottom-right-radius: 4px 4px; -webkit-border-top-left-radius: 4px 4px; -webkit-border-top-right-radius: 4px 4px;">';
			$this->mHtml .= '<a href="uri/' . $link['object_id'] . '">';
			$this->mHtml .= '&nbsp;' . str_replace(' ', '&nbsp;', $link['name']) . '&nbsp;' . ' ';
			$this->mHtml .= '</a>';
			$this->mHtml .= '</span>';
		}
		$this->mHtml .= '</td>';
		$this->mHtml .= '</td>';
		$this->mHtml .= '</table>';
		
		$this->mHtml .= '</div>';
		
	}

	
	function MainContent()
	{
		$this->mHtml .= '<div style="font-size:12px">';
		// tags		
		$tags = db_outgoing_links($this->mObject->GetObjectId(), RELATION_TAGGED_WITH_TAG, CLASS_TAG);
		
		if (count($tags) > 0)
		{
			$this->mHtml .= '<h3>Tags</h3>';
			foreach ($tags as $tag)
			{
				$this->mHtml .= '<span style="display:inline;border: 1px solid blue;padding: 2px; margin:2px;line-height:22px;background-color:rgb(181,213,255);-webkit-border-bottom-left-radius: 4px 4px; -webkit-border-bottom-right-radius: 4px 4px; -webkit-border-top-left-radius: 4px 4px; -webkit-border-top-right-radius: 4px 4px;">';
				$this->mHtml .= '<a href="uri/' . $tag['object_id'] . '">';
				$this->mHtml .= '&nbsp;' . str_replace(' ', '&nbsp;', $tag['name']) . '&nbsp;' . ' ';
				$this->mHtml .= '</a>';
				$this->mHtml .= '</span>';
			}
		}		
		
		// abstract
		$a = $this->mObject->GetAttributeValue('abstract');
		
		$this->mHtml .= '<p>' . $a . '</p>';
		$this->mHtml .= '</div>';
		
		$this->ref_count = 0;
		
		// Cited by
		$cited_by = db_incoming_links($this->mObject->GetObjectId(), RELATION_REFERENCES, CLASS_REFERENCE);
		
		if (count($cited_by) > 0)
		{		
			$this->mHtml .= '<h3>Cited by ' . count($cited_by) . '</h3>';
			$this->mHtml .= '<span class="explain">More recent articles that cite this article.</span>';


			$this->mHtml .= '<ol>';
			
			foreach ($cited_by as $link)
			{
				$this->mHtml .=  '<li id="' . $link['object_id'] . '"><a href="uri/' . $link['object_id'] . '">' . $link['name'] . '</a></li>';
			}
			$this->mHtml .=  '</ol>';
		}
		
		
		// Data coupled
		$data_coupling = query_colinks($this->mObject->GetObjectId(), RELATION_REFERENCES, CLASS_REFERENCE, CLASS_GENBANK);
		
		if (count($data_coupling) > 0)
		{		
			$this->mHtml .= '<h3>Shares data with ' . count($data_coupling) . '</h3>';
			$this->mHtml .= '<span class="explain">Articles that share data with this article.</span>';
			$this->mHtml .= '<ol>';
			
			foreach ($data_coupling as $link)
			{
				$this->mHtml .=  '<li id="' . $link['object_id'] . '_' . $this->ref_count++ . '"><a href="uri/' . $link['object_id'] . '">' . $link['name'] . '</a></li>';
			}
			$this->mHtml .=  '</ol>';
		}
		

		// Cites
		$cites = db_outgoing_links($this->mObject->GetObjectId(), RELATION_REFERENCES, CLASS_REFERENCE);
		
		if (count($cites) > 0)
		{		
			$this->mHtml .= '<h3>Cites ' . count($cites) . '</h3>';
			$this->mHtml .= '<span class="explain">Articles cited by this article (note that only articles are online and known to the <a href="http://bioguid.info/openurl">bioGUID OpenURL resolver</a> will be listed here).</span>';
			
			$this->mHtml .= '<ol>';
			
			foreach ($cites as $link)
			{
				$this->mHtml .=  '<li id="' . $link['object_id'] . '_' . $this->ref_count++ . '"><a href="uri/' . $link['object_id'] . '">' . $link['name'] . '</a></li>';
			}
			$this->mHtml .=  '</ol>';
			
			$this->ref_count++;
		}
		
		
		// Matrix
		
		$j = get_matrix_js($this->mObject->GetObjectId());
		if ($j != '')
		{
			$this->mHtml .= '<h3>Taxon/gene matrix</h3>';
			$this->mHtml .= '<span class="explain">Table lens view of sequences, grouped by taxon and gene feature. Click on accession number to see details for sequence. Note that if more than one sequence exists for the same gene for the same taxon, only one will be displayed here.</span>';
			
			$this->mHtml .= '<script type="text/javascript">';
			$this->mHtml .= $j;
		}
		
		
		
		// Genes
		$genes = x2y_y2z($this->mObject->GetObjectId(), RELATION_REFERENCES, RELATION_TAGGED_WITH_TAG);
		if (count($genes) > 0)
		{
			$this->mHtml .= '<h3>Features</h3>';
			$this->mHtml .= '<p class="explain">Sequence features (such as genes) in this study</p>';
			foreach ($genes as $link)
			{
				$this->mHtml .= '<span style="font-size:12px;display:inline;border: 1px solid blue;padding: 2px; margin:2px;line-height:22px;background-color:rgb(181,213,255);-webkit-border-bottom-left-radius: 4px 4px; -webkit-border-bottom-right-radius: 4px 4px; -webkit-border-top-left-radius: 4px 4px; -webkit-border-top-right-radius: 4px 4px;">';
				$this->mHtml .= '<a href="uri/' . $link['object_id'] . '">';		
				
				$this->mHtml .= '&nbsp;' . str_replace(' ', '&nbsp;', $link['name']) . '&nbsp;' . ' ';
				$this->mHtml .= '</a>';		
				$this->mHtml .= '</span>';
			}
		}	
		
		$tlist =  array();
		
		
		// Taxa
		$one_name = '';
		$taxa = x2y_y2z($this->mObject->GetObjectId(), RELATION_REFERENCES, RELATION_SOURCE);
		if (count($taxa) > 0)
		{
			$this->mHtml .= '<h3>Taxa</h3>';
			$this->mHtml .= '<p class="explain">Taxa sequenced in thius study</p>';
			foreach ($taxa as $link)
			{
				$this->mHtml .= '<span style="font-size:12px;display:inline;border: 1px solid blue;padding: 2px; margin:2px;line-height:22px;background-color:rgb(181,213,255);-webkit-border-bottom-left-radius: 4px 4px; -webkit-border-bottom-right-radius: 4px 4px; -webkit-border-top-left-radius: 4px 4px; -webkit-border-top-right-radius: 4px 4px;">';
				$this->mHtml .= '<a href="uri/' . $link['object_id'] . '">';		
				
				$this->mHtml .= '&nbsp;' . str_replace(' ', '&nbsp;', $link['name']) . '&nbsp;' . ' ';
				$this->mHtml .= '</a>';		
				$this->mHtml .= '</span>';
				
				$one_name = $link['name'];
				
				
				$parts = split(' ', $link['name']);
				if (isset($tlist[$parts[0]]))
				{
					$tlist[$parts[0]]++;
				}
				else
				{
					$tlist[$parts[0]] = 1;
				}
			}
		}	
		
/*		$this->mHtml .= '<pre>';
		$this->mHtml .= print_r($tlist, true);
		$this->mHtml .= '</pre>';
*/		
		if (count($tlist) == 1)
		{
			// only one genus
			$tlist = array();
//			$tlist[$one_name] = 1;

			foreach ($taxa as $link)
			{
				$tlist[$link['name']] = 1;
			}


		}
		
/*		$this->mHtml .= '<pre>';
		$this->mHtml .= print_r($tlist, true);
		$this->mHtml .= '</pre>';*/
		
		foreach ($tlist as $k => $v)
		{
			array_push($this->items, new Item($v,$k));
		}		

/*		$this->mHtml .= '<pre>';
		$this->mHtml .= print_r($this->items, true);
		$this->mHtml .= '</pre>';*/

		// Sequences
		$sequences = db_outgoing_links($this->mObject->GetObjectId(), RELATION_REFERENCES, CLASS_GENBANK);
		if (count($sequences) > 0)
		{			
			$this->mHtml .= '<h3>Sequences ' . count($sequences) . '</h3>';
			$this->mHtml .= '<span class="explain">Sequences cited by this article.</span>';
			$this->mHtml .= '<ul>';
			foreach ($sequences as $link)
			{
				$this->mHtml .=  '<li>' . '<a href="uri/' . $link['object_id'] . '">' . $link['name'] . '</a></li>';
			}
			$this->mHtml .=  '</ul>';
		}		
		
		
		

		
		// Update display		
		foreach ($cited_by as $link)
		{
			$this->mHtml .= '<script type="text/javascript" src="snippet.php?id=' . $link['object_id']. '"></script>';
		}
		foreach ($data_coupling as $link)
		{
			$this->mHtml .= '<script type="text/javascript" src="snippet.php?id=' . $link['object_id']. '"></script>';
		}
		foreach ($cites as $link)
		{
			$this->mHtml .= '<script type="text/javascript" src="snippet.php?id=' . $link['object_id']. '"></script>';
		}
		
			
		
		
	}
	
	
	function RightNavMapQuery()
	{
		// studies overlapping...
		$overlapping = extent_intersects($this->mObject->GetObjectId(), 3);
		
		if (count($overlapping) > 0)
		{		
			$this->mHtml .= '<h4>Overlapping (' . count($overlapping) . ')</h4>';
			$this->mHtml .= '<span class="explain">Studies in the same area, based on intersecting polygons enclosing all point localities associated with the study. Due to limitations of the underlying database the overlap is calculated using the minimum bounding rectangle, not the actual polygon.</span>';
			
			$this->mHtml .= '<ol>';
			
			foreach ($overlapping as $link)
			{
				$this->mHtml .=  '<li id="' . $link['object_id'] . '_' . $this->ref_count++ . '"><a href="uri/' . $link['object_id'] . '">' . $link['name'] . '</a></li>';
			}
			$this->mHtml .=  '</ol>';
			
			$this->ref_count++;
		}
		
		foreach ($overlapping as $link)
		{
			$this->mHtml .= '<script type="text/javascript" src="snippet.php?id=' . $link['object_id']. '"></script>';
		}
	
		
		
	}
	
	
	
	
	function RightNavExtra()
	{
		global $config;
		
		$this->mHtml .= '<div class="rightnav-box">';
		$this->mHtml .= '<div class="rightnavbox-content">';
		$this->mHtml .= '<h4>Taxa in this study</h4>';
		
		
// Create some data for us to plot

/*$items = array();


	$i = new Item(10,'10',1);
	array_push($items, $i);
	$i = new Item(5,'5', 2);
	array_push($items, $i);
	$i = new Item(4,'4', 3);
	array_push($items, $i);
	$i = new Item(1,'2', 4);
	array_push($items, $i);
	*/


$this->mHtml .=  treemap_widget(0,0,300,300,$this->items);



//	$this->mHtml .= '<p></p>';	
	
	
		// taxonomic overlap...
		$overlapping = contained_studies($this->mObject->GetObjectId());
		
		if (count($overlapping) > 0)
		{		
			$this->mHtml .= '<h4>Studies on related taxa (' . count($overlapping) . ')</h4>';
			$this->mHtml .= '<span class="explain">Studies within span off this study, based on the NCBI taxonomy.</span>';
			
			$this->mHtml .= '<ol>';
			
			foreach ($overlapping as $link)
			{
				$this->mHtml .=  '<li id="' . $link['object_id'] . '_' . $this->ref_count++ . '"><a href="uri/' . $link['object_id'] . '">' . $link['name'] . '</a></li>';
			}
			$this->mHtml .=  '</ol>';
			
			$this->ref_count++;
		}
		foreach ($overlapping as $link)
		{
			$this->mHtml .= '<script type="text/javascript" src="snippet.php?id=' . $link['object_id']. '"></script>';
		}
	

		
		
		$this->mHtml .= '</div>';
		$this->mHtml .= '</div>';
		
	}
	
	

/*	function RightNavContent()
	{
		$this->mHtml .= $this->RightNavMap();
		
		$this->mHtml .= '<div class="rightnavbox">';
		$this->mHtml .= '<h3>NCBI classification</h3>';
		$this->mHtml .= '<div style="text-align:left">';				
		$this->mHtml .= display_pygmybrowser($this->mObject->GetObjectId());
		$this->mHtml .= "<p>To do: taxon query</p>";
		$this->mHtml .= '</div>';
		$this->mHtml .= "</div>";
		
	}	*/
}




?>