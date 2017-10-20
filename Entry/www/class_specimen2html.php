<?php

// Base HTML render (extend this for each object we want to display)

require_once('class_object2html.php');
require_once('../query.php');

class Specimen2Html extends  Object2Html
{	

	function MainStart()
	{	
		$this->mHtml .= html_top();
		$this->mHtml .= '<div id="main-content-container">';
		

		$this->mHtml .= '<h1>' . $this->mObject->GetTitle() . '</h1>';
		$this->mHtml .= '<p class="explain">is a specimen</p>';
		$this->mHtml .= '<div style="display:block;font-size:12px;">' . $this->mObject->GetHtmlSnippet() . '</div>';

		
		// uBio taxonomic name
		$this->mHtml .= '<h3>Tags</h3>';
		$this->mHtml .= '<div style="font-size:12px">';
		$tags = db_outgoing_links($this->mObject->GetObjectId(), RELATION_TAGGED_WITH_TAG, CLASS_CANNONICALNAME);
		foreach ($tags as $tag)
		{
			$this->mHtml .= '<span style="display:inline;border: 1px solid blue;padding: 2px; margin:2px;line-height:22px;background-color:rgb(181,213,255);-webkit-border-bottom-left-radius: 4px 4px; -webkit-border-bottom-right-radius: 4px 4px; -webkit-border-top-left-radius: 4px 4px; -webkit-border-top-right-radius: 4px 4px;">';
			$this->mHtml .= '<a href="uri/' . $tag['object_id'] . '">';		
			$this->mHtml .= '&nbsp;' . str_replace(' ', '&nbsp;', $tag['name']) . '&nbsp;' . ' ';
			$this->mHtml .= '</a>';
			$this->mHtml .= '</span>';
			
		}
		$this->mHtml .= '</div>';
	}


	
	function MainContent()
	{
		$ref_count = 0;
		$studies = array();
		
		// Voucher for these sequences		
		$voucher_for = db_outgoing_links($this->mObject->GetObjectId(), RELATION_VOUCHER_FOR, CLASS_GENBANK);
		if (count($voucher_for) > 0)
		{		
			$this->mHtml .= '<h3>Voucher for (' . count($voucher_for) . ')</h3>';
			$this->mHtml .= '<span class="explain">Sequences from this specimen.</span>';
			$this->mHtml .= '<ul>';
			foreach ($voucher_for as $link)
			{
				$this->mHtml .=  '<li>' . '<a href="uri/' . $link['object_id'] . '">' . $link['name'] . '</a></li>';
				
				// Studies citing these sequences...
				$s = db_incoming_links($link['object_id'], RELATION_REFERENCES, CLASS_REFERENCE);
				foreach ($s as $l)
				{
					// store in simple array so we avoid duplicates
					$studies[$l['object_id']] = $l['name'];
				}
			}
			$this->mHtml .=  '</ul>';
		}
		
//		$r = print_r ($studies, true);
//		$this->mHtml .= '<pre>' . $r . '</pre>';
		
		// Studies citing this specimen		
		if (count($studies) > 0)
		{		
			$this->mHtml .= '<h3>Sequence citations (' . count($studies) . ')</h3>';
			$this->mHtml .= '<span class="explain">Publications that cite sequences from this specimen.</span>';
		
		
			$this->mHtml .= '<ol>';
			foreach ($studies as $k => $v)
			{
				$this->mHtml .=  '<li id="' . $k . '_' . $ref_count++ . '"><a href="uri/' . $k . '">' . $v . '</a></li>';
			}
			$this->mHtml .=  '</ol>';
		}		


		// Citing it directly		
		$cites = db_incoming_links($this->mObject->GetObjectId(), RELATION_REFERENCES, CLASS_REFERENCE);
		if (count($cites) > 0)
		{		
			$this->mHtml .= '<h3>Cited by (' . count($cites) . ')</h3>';
			$this->mHtml .= '<span class="explain">Publications that cite this specimen directly.</span>';
			$this->mHtml .= '<ul>';
			foreach ($cites as $link)
			{
				$this->mHtml .=  '<li id="' .$link['object_id'] . '_' . $ref_count++ . '">' . '<a href="uri/' . $link['object_id'] . '">' . $link['name'] . '</a></li>';
				
				$studies[$link['object_id']] = $link['name'];
			}
			$this->mHtml .=  '</ul>';
		}
		

		
		
		// Populate studies with images
		foreach ($studies as $k => $v)
		{
			$this->mHtml .= '<script type="text/javascript" src="snippet.php?id=' . $k . '"></script>';
		}
		
	
	
	}
	
	function RightNavMapHeading()
	{
		$this->mHtml .= '<h4>Specimen locality</h4>';	
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