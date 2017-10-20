<?php

// Display a person

require_once('class_object2html.php');
require_once('../query.php');

class Person2Html extends  Object2Html
{	

	function MainStart()
	{	
		$this->mHtml .= html_top();
		$this->mHtml .= '<div id="main-content-container">';
		
		$this->mHtml .= '<table>
		<tr>
		<td>
		<img src="images/user.png" />
		</td>
		<td>';
		$this->mHtml .= '<h1>' . $this->mObject->GetTitle() . '</h1>';
		$this->mHtml .= '<p class="explain">is a person</p>';
		$this->mHtml .= '</td></tr></table>';
	}


	function MainEnd()
	{
		global $config;
	
		$this->mHtml .= '<script type="text/javascript" src="http://ispecies.org/yj.php?search=' . $this->mObject->GetTitle() . '&callback=ws_results"></script>';
		$this->mHtml .= '</div>';
	}
	
	function MainContent()
	{
		$this->MainDepiction();
		
		
		
		// Papers authored
		$author_of = db_outgoing_links($this->mObject->GetObjectId(), RELATION_AUTHOR_OF, CLASS_REFERENCE);
	
		$this->mHtml .= '<h3>Author of</h3>';
		$this->mHtml .= '<span class="explain">Articles authored by this person.</span>';
		
		$this->mHtml .= '<ol>';
		foreach ($author_of as $link)
		{
				$this->mHtml .=  '<li id="' . $link['object_id'] . '"><a href="uri/' . $link['object_id'] . '">' . $link['name'] . '</a></li>';
		}
		$this->mHtml .=  '</ol>';
		
		
		// Update display		
		foreach ($author_of as $link)
		{
			$this->mHtml .= '<script type="text/javascript" src="snippet.php?id=' . $link['object_id']. '"></script>';
		}
		
		// Coauthors
		$this->mHtml .= '<h3>Coauthors</h3>';
		$this->mHtml .= '<span class="explain">People this person has written papers with</span>';
		$list_html = '';
		$index_html = '';
		

		$coauthors = query_colinks($this->mObject->GetObjectId(), RELATION_AUTHOR_OF, CLASS_PERSON);
		$num_coauthors = count($coauthors);
	
		$letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');		
		
	
		// Get count of author's last names that begin with 'A'
		$numA = 0;
		if ($num_coauthors > 0)
		{
			$i = 0;
			while ($coauthors[$i]['lastname']{0} == 'A')
			{
				$i++;
				$numA++;
			}
		}
		
			
		if ($numA > 0)
		{
			$list_html .= '<li>';
			$list_html .= '<span><a name="A">A</a></span>';
			$list_html .= '<ul style="list-style-type:none;border-bottom:1px dotted rgb(190,190,190);padding-bottom:2px">';
		}
		
		$count = array();
		for ($i=0; $i < 26; $i++)
		{		
			$count[i] = 0;
		}
		
		$pos = 0;
		for($i=0; $i < $num_coauthors; $i++)
		{
			$firstLetter = $coauthors[$i]['lastname']{0};
			$firstLetter = strtoupper($firstLetter);
			
			if ($firstLetter != $letters[$pos])
			{
				$list_html .= '</ul>';
				$list_html .= '</li>';
			}
			
			while ($firstLetter != $letters[$pos])
			{
				$pos++;
	
				if ($firstLetter == $letters[$pos])
				{
					$list_html .= '<li>';
					$list_html .= '<span"><a name="' . $letters[$pos] . '">' . $letters[$pos] . '</span>';
					$list_html .= '<ul style="list-style-type:none;border-bottom:1px dotted rgb(190,190,190);padding-bottom:2px">';
				}
			}
		
			
			$list_html .= '<li><a href="uri/' . $coauthors[$i]['object_id'] . '">' . $coauthors[$i]['lastname'] . ',&nbsp;' . $coauthors[$i]['forename']  . '</a>';
			
			
			/* count is wrong, need to debug SQL			
			<span style="float:right;margin-right:20px;">' . $coauthors[$i]['count'] . '</span>'; */
			
			
			$list_html .= '</li>';
	
			$count[ord($coauthors[$i]['lastname']{0}) - 65]++;
		}


		// Index sidebar
		for ($i=0; $i < 26; $i++)
		{		
			if( $count[$i] > 0)
			{
				$index_html .= '<span style="display:block;"><a href="uri/' . $this->mObject->GetObjectId() . '#' . $letters[$i] . '">' . $letters[$i] . '</a></span>';
			}
			else
			{
				$index_html .= '<span style="display:block;color:rgb(192,192,192)">' . $letters[$i] .'</span>';
			}
	
		}


		// Create control
		$this->mHtml .= '<div>';

		$this->mHtml .= '<div style="float:right;padding:6px;text-align:center;font-size:12px">';

		// list of letters
		$this->mHtml .= $index_html;
		

		$this->mHtml .= '</div>';

		$this->mHtml .= '<div style="overflow:auto;height:400px;border:1px solid rgb(190,190,190)">';
		$this->mHtml .= '<ol style="list-style-type:none;">';
		
		
		// list of coauthors
		$this->mHtml .= $list_html;
		
		$this->mHtml .= '</ol>';
		$this->mHtml .= '</div>';
		$this->mHtml .= '</div>';


/*
	// Index sidebar
	var index_html = '';
	for (i=0;i<26;i++)
	{		
		if( count[i] > 0)
		{
			index_html += '<span style="display:block;"><a href="uri/' + gObject_id + '#' + letters[i] + '">' + letters[i] + '</a></span>';
		}
		else
		{
			index_html += '<span style="display:block;color:rgb(192,192,192)">' + letters[i] + '</span>';
		}

	}
		
	document.getElementById('contact_index').innerHTML = index_html;
	document.getElementById('contact_list').innerHTML = list_html;
}
	*/	
		
		
		
		
		
/*		for ($i = 0; $i < $c; $i++)
		{
			$sourceNode = $G->AddNode($f[$i]['object_id'], $f[$i]['name']);
			
			for ($j = $i+1; $j < $c; $j++)
			{
				if (query_coauthored($f[$i]['object_id'], $f[$j]['object_id']))
				{
					$targetNode = $G->AddNode($f[$j]['object_id'], $f[$j]['name']);
					$G->AddEdge($sourceNode, $targetNode);
					
				}
			}
		}
*/		
		
		
		
		

	
	
	}
	
	function RightNavMapHeading()
	{
		$this->mHtml .= '<p>Distribution of data associated with this taxon</p>';	
	}

	function RightNavMapQuery()
	{
	}
	
	function RightNavMap()
	{
	}
	
	function RightNavExtra()
	{
		global $config;
		
		// Get NCBI taxonid
		
		$guids = db_retrieve_guids($this->mObject->GetObjectId());
		$tx = '';
		foreach ($guids as $guid)
		{
			if ($guid['namespace'] == 'taxid')
			{
				$tx = $guid['identifier'];
				// temp bug fix
				$tx = str_replace('taxon:', '', $tx);
			}
		}
		
		if ($tx != '')
		{
			$this->mHtml .= '<div class="rightnav-box">';
			$this->mHtml .= '<div class="rightnavbox-content">';
			$this->mHtml .= '<p>Taxa in this study</p>';
			
	$this->mHtml .= '
	<div class="pygmy">
		<div class="pygmy_node" id="node1">
		<span onclick="show_node(1)" ondblclick="nodeInfo(1)">root</span>
		</div>
	</div>
	
	<!-- show a given lineage -->
	<script type="text/javascript">show_node(' . $tx . ');</script>
	';
			
			$this->mHtml .= '<p><i>N</i> other studies on these taxa</p>';
			$this->mHtml .= '</div>';
			$this->mHtml .= '</div>';
		}
	}
	

}



?>