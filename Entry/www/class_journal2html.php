<?php

// Display a journal

require_once('class_object2html.php');
require_once('../query.php');

class Journal2Html extends  Object2Html
{	



	function MainStart()
	{	
		$this->mHtml .= html_top();
		$this->mHtml .= '<div id="main-content-container">';
		
		$this->mHtml .= '<div>';
		
		
		$this->mHtml .= '<table>';
		$this->mHtml .= '<tr>';
		$this->mHtml .= '<td>';
		
		$this->mHtml .= '<div style="padding:0px;margin-right:10px;float:left;">';
		
		
		$guids = db_retrieve_guids($this->mObject->GetObjectId());
		foreach ($guids as $guid)
		{
			switch($guid['namespace'])
			{
				case 'issn':
					$image_url = issn_image($guid['identifier']);
					if ($image_url != '')
					{
						$this->mHtml .= '<img src="' . $image_url . '" height="128" />';
					}
					else
					{
						$this->mHtml .= '<img src="images/issn/unknown.png" height="128" />';
					}					
					break;
					
				default:
					break;
			}
		}
		$this->mHtml .= '</td>';
		$this->mHtml .= '<td valign="top">';

		$this->mHtml .= '<span style="display:block;font-size:18px;"><i>' . $this->mObject->GetTitle() . '</i></span>';
		$this->mHtml .= '<p class="explain">is a journal</p>';
		
		$this->mHtml .= '</td>';
		$this->mHtml .= '</td>';
		$this->mHtml .= '</table>';
		
		$this->mHtml .= '</div>';
		
	}


	
	function MainContent()
	{
		
		// Papers published in this journal
		$articles = db_incoming_links($this->mObject->GetObjectId(), RELATION_IS_PART_OF, CLASS_REFERENCE);
	
		$this->mHtml .= '<h3>Articles in this journal (' . count($articles) . ')</h3>';
		$this->mHtml .= '<span class="explain">Articles published in this journal.</span>';
		
		$this->mHtml .= '<ol>';
		foreach ($articles as $link)
		{
				$this->mHtml .=  '<li id="' . $link['object_id'] . '"><a href="uri/' . $link['object_id'] . '">' . $link['name'] . '</a></li>';
		}
		$this->mHtml .=  '</ol>';
		
		
		// Update display		
		foreach ($articles as $link)
		{
			$this->mHtml .= '<script type="text/javascript" src="snippet.php?id=' . $link['object_id']. '"></script>';
		}
		
		
	
	
	}
	
	function RightNav()
	{
		$this->RightNavStart();
		$this->RightNavGuids();
//		$this->RightNavMap();
//		$this->RightNavExtra();
		$this->RightNavEnd();
	}
	

}



?>