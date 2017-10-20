<?php

// Base HTML render (extend this for each object we want to display)

require_once('class_object2html.php');
require_once('../query.php');

class Genbank2Html extends  Object2Html
{	

	function MainStart()
	{	
		$this->mHtml .= html_top();
		$this->mHtml .= '<div id="main-content-container">';
		
		$this->mHtml .= '<table>
		<tr>
		<td>
		<img src="images/196px-DNA_sequence.svg.png" width="90" />
		</td>
		<td>';
		$this->mHtml .= '<h1>' . $this->mObject->GetTitle() . '</h1>';
		$this->mHtml .= '<p class="explain">is a nucleotide sequence</p>';
		$this->mHtml .= '</td></tr></table>';
		
		
		// Source taxon
		$source = db_outgoing_links($this->mObject->GetObjectId(), RELATION_SOURCE, CLASS_TAXON_NAME);
		
		$this->mHtml .= '<p>from taxon <a href="uri/' . $source[0]['object_id'] . '">';
		$this->mHtml .= $source[0]['name'];
		$this->mHtml .= '</a>';
		
		// Specimen
		$vouchers = db_incoming_links($this->mObject->GetObjectId(), RELATION_VOUCHER_FOR, CLASS_SPECIMEN);
		
		if (count($vouchers) > 0)
		{
			$this->mHtml .= ' (voucher specimen <a href="uri/' . $vouchers[0]['object_id'] . '">';
			$this->mHtml .= $vouchers[0]['name'];
			$this->mHtml .= '</a>)';
		}

		// Host
		$host = db_outgoing_links($this->mObject->GetObjectId(), RELATION_HOSTED_BY, CLASS_CANNONICALNAME);
		
		if (count($host) > 0)
		{
			$this->mHtml .= ', host recorded as <a href="uri/' . $host[0]['object_id'] . '">';
			$this->mHtml .= $host[0]['name'];
			$this->mHtml .= '</a>';
		}
		$this->mHtml .= '</p>';
		
		
		// Gene names (features as tags)
		$this->mHtml .= '<div style="font-size:12px">';
		$tags = db_outgoing_links($this->mObject->GetObjectId(), RELATION_TAGGED_WITH_TAG, CLASS_FEATURE);
		foreach ($tags as $tag)
		{
			$this->mHtml .= '<span style="display:inline;border: 1px solid blue;padding: 2px; margin:2px;line-height:22px;background-color:rgb(181,213,255);-webkit-border-bottom-left-radius: 4px 4px; -webkit-border-bottom-right-radius: 4px 4px; -webkit-border-top-left-radius: 4px 4px; -webkit-border-top-right-radius: 4px 4px;">';
			$this->mHtml .= '<a href="uri/' . $tag['object_id'] . '">';		
			
			$this->mHtml .= '&nbsp;' . str_replace(' ', '&nbsp;', $tag['name']) . '&nbsp;' . ' ';
			$this->mHtml .= '</a>';		
			$this->mHtml .= '</span>';
			
		}
		$this->mHtml .= '</div>';
		
		
		
		$this->mHtml .= $this->mObject->GetAttributeValue('source');
/*		$this->mHtml .= ': ' . $this->mObject->GetAttributeValue('spage');
		$this->mHtml .= ' (' . year_from_date($this->mObject->GetAttributeValue('year')) .')';
		$this->mHtml .= '<br/>';
		
		// authors		
		$authors = db_incoming_links($this->mObject->GetObjectId(), RELATION_AUTHOR_OF, CLASS_PERSON);
		foreach ($authors as $link)
		{
			$this->mHtml .= '<span style="display:inline;margin:2px;">';
			$this->mHtml .= '<a href="uri/' . $link['object_id'] . '">';
			$this->mHtml .= $link['name'];
			$this->mHtml .= '</a>';
			$this->mHtml .= '</span>';
		}
		$this->mHtml .= '</td>';
		$this->mHtml .= '</td>';
		$this->mHtml .= '</table>';
		
		$this->mHtml .= '</div>';*/
		
	}



	
	function MainContent()
	{
	
		$this->mHtml .= '<h3>Attributes</h3>'; 		
		$this->mHtml .= $this->mObject->GetAttributesAsHtmlTable();
		
		// Studies citing this sequence
		
		$studies = db_incoming_links($this->mObject->GetObjectId(), RELATION_REFERENCES, CLASS_REFERENCE);
		
		if (count($studies) > 0)
		{		
			$this->mHtml .= '<h3>Studies citing this sequence (' . count($studies) . ')</h3>';
			$this->mHtml .= '<span class="explain">Sequences that cite this sequence.</span>';
		
		
			$this->mHtml .= '<ol>';
			foreach ($studies as $link)
			{
				$this->mHtml .=  '<li id="' . $link['object_id'] . '"><a href="uri/' . $link['object_id'] . '">' . $link['name'] . '</a></li>';
			}
			$this->mHtml .=  '</ol>';
		}
		
		foreach ($studies as $link)
		{
			$this->mHtml .= '<script type="text/javascript" src="snippet.php?id=' . $link['object_id']. '"></script>';
		}
		
	
	
	}
	
	function RightNavMapHeading()
	{
		$this->mHtml .= '<h4>Sequence sample locality</h4>';	
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