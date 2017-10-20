<?php

// Base HTML render (extend this for each object we want to display)

require_once('class_object2html.php');
require_once('../query.php');

class TaxonName2Html extends  Object2Html
{	

	function MainStart()
	{	
		$this->mHtml .= html_top();
		$this->mHtml .= '<div id="main-content-container">';
		
		$this->mHtml .= '<table>
		<tr>
		<td>
		<img src="images/tag_blue.png" />
		</td>
		<td>';
		$this->mHtml .= '<h1>' . $this->mObject->GetTitle() . '</h1>';
		$this->mHtml .= '<p class="explain">is a taxon name</p>';
		$this->mHtml .= '</td></tr></table>';
		
		
	}
	
	function MainDepiction()
	{
		$image_id = get_one_image_id($this->mObject->GetTitle(), true);
				
		if ($image_id != '')
		{
			// Image dimensions
			$details = get_image_details($image_id);
			$w = $details['width'];
			$h = $details['height'];
			
			$tip_text = '<div>';
			$tip_text .= '<span><a href=&quot;' . $details['url'] . '&quot;>' . htmlentities($details['title']) . '</a></span>';
			if (isset($details['flickr_username']))
			{
				$tip_text .= '<br /><span> by <strong><a href=&quot;http://www.flickr.com/photos/' . $details['flickr_owner'] . '&quot;>' . htmlentities($details['flickr_username']) . '</a></strong></span>';
			}				
			$tip_text .= '</div>';
						
			
			$this->mHtml .= '<div "style='
				. 'width:' . $w . 'px;'
				. 'height:' . $h . 'px;"'
				
				. ' onmouseover="Tip(\'' 
					. $tip_text . '\', STICKY, 5, FONTFACE, \'Arial, sans-serif\', FONTSIZE, \'10px\', BGCOLOR, \'#FFFFFF\')" '
			

				.'>'
				
				. '<a href="' . $details['url'] .'" target="_blank">'
				. '<img src="media.php?id=' . $image_id 
					. '" width="' . $w . '"'
					. '" height="' . $h . '"'
					. '/>'
				. '</a>'
				. '</div>';
		}

	//}



	
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
		
		
		// Studies linked to this taxon by sequences
		
		$studies = query_studies_for_taxon($this->mObject->GetObjectId());
		$this->mHtml .= '<h3>Studies on this taxon</h3>';
		$this->mHtml .= '<p class="explain">Publications that cite sequences for this taxon</p>';
		$this->mHtml .= '<ol>';
		foreach ($studies as $link)
		{
			$this->mHtml .=  '<li id="' . $link['object_id'] . '"><a href="uri/' . $link['object_id'] . '">' . $link['name'] . '</a></li>';
		}
		$this->mHtml .=  '</ol>';
		
		
		$hosts = x2y_x2z($this->mObject->GetObjectId(), RELATION_SOURCE, RELATION_HOSTED_BY);
		if (count($hosts) > 0)
		{
			$this->mHtml .= '<h3>Hosts</h3>';
			$this->mHtml .= '<p class="explain">Hosts listed in the &quot;specific_host&quot; field of sequences for this taxon </p>';
			foreach ($hosts as $link)
			{
				$this->mHtml .= '<span style="display:inline;border: 1px solid blue;padding: 2px; margin:2px;line-height:22px;background-color:rgb(181,213,255);-webkit-border-bottom-left-radius: 4px 4px; -webkit-border-bottom-right-radius: 4px 4px; -webkit-border-top-left-radius: 4px 4px; -webkit-border-top-right-radius: 4px 4px;">';
				$this->mHtml .= '<a href="uri/' . $link['object_id'] . '">';		
				
				$this->mHtml .= '&nbsp;' . str_replace(' ', '&nbsp;', $link['name']) . '&nbsp;' . ' ';
				$this->mHtml .= '</a>';		
				$this->mHtml .= '</span>';
			}
		}	

		$genes = x2y_x2z($this->mObject->GetObjectId(), RELATION_SOURCE, RELATION_TAGGED_WITH_TAG);
		if (count($genes) > 0)
		{
			$this->mHtml .= '<h3>Features</h3>';
			$this->mHtml .= '<p class="explain">Sequence features (such as genes) for this taxon</p>';
			foreach ($genes as $link)
			{
				$this->mHtml .= '<span style="display:inline;border: 1px solid blue;padding: 2px; margin:2px;line-height:22px;background-color:rgb(181,213,255);-webkit-border-bottom-left-radius: 4px 4px; -webkit-border-bottom-right-radius: 4px 4px; -webkit-border-top-left-radius: 4px 4px; -webkit-border-top-right-radius: 4px 4px;">';
				$this->mHtml .= '<a href="uri/' . $link['object_id'] . '">';		
				
				$this->mHtml .= '&nbsp;' . str_replace(' ', '&nbsp;', $link['name']) . '&nbsp;' . ' ';
				$this->mHtml .= '</a>';		
				$this->mHtml .= '</span>';
			}
		}	
		
		
		// Sequences of this taxon		
		$sequences_of = db_incoming_links($this->mObject->GetObjectId(), RELATION_SOURCE, CLASS_GENBANK);
	
		$this->mHtml .= '<h3>Sequences</h3>';
		$this->mHtml .= '<p class="explain">Sequences for this taxon</p>';
		$this->mHtml .= '<ul>';
		foreach ($sequences_of as $link)
		{
			$this->mHtml .=  '<li>' . '<a href="uri/' . $link['object_id'] . '">' . $link['name'] . '</a></li>';			
		}
		$this->mHtml .=  '</ul>';
		
		
		foreach ($studies as $link)
		{
			$this->mHtml .= '<script type="text/javascript" src="snippet.php?id=' . $link['object_id']. '"></script>';
		}
		
	
	
	}
	
	function RightNavMapHeading()
	{
		$this->mHtml .= '<h4>Distribution of data associated with this taxon</h4>';	
	}

	function RightNavMapQuery()
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
			$this->mHtml .= '<h4>NCBI classification</h4>';
			
	$this->mHtml .= '
	<div class="pygmy">
		<div class="pygmy_node" id="node1">
		<span onclick="show_node(1)" ondblclick="nodeInfo(1)">root</span>
		</div>
	</div>
	
	<!-- show a given lineage -->
	<script type="text/javascript">show_node(' . $tx . ');</script>
	';
			
//			$this->mHtml .= '<p><i>N</i> other studies on these taxa</p>';
			$this->mHtml .= '</div>';
			$this->mHtml .= '</div>';
		}
	}
	

}



?>