<?php

// Base HTML render (extend this for each object we want to display)

require_once('class_object2html.php');
require_once('../query.php');

class Feature2Html extends  Object2Html
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
		$this->mHtml .= '<p class="explain">is a feature of a gene</p>';
		$this->mHtml .= '</td></tr></table>';
		
		
	}

	function MainEnd()
	{
		global $config;
	
//		$this->mHtml .= '<script type="text/javascript" src="http://ispecies.org/yj.php?search=' . $this->mObject->GetTitle() . '&callback=ws_results"></script>';
		$this->mHtml .= '</div>';
	}
	
	function MainContent()
	{
//		$this->MainDepiction();
		
		
		// Genes with this feature
		
		$tagged_with = db_incoming_links($this->mObject->GetObjectId(), RELATION_TAGGED_WITH_TAG, CLASS_GENBANK);
		
		if (count($tagged_with) > 0)
		{
			$this->mHtml .= '<h3>Sequences tagged with &quot;' . $this->mObject->GetTitle() . '&quot;</h3>';
			$this->mHtml .= '<ul>';
			foreach ($tagged_with as $link)
			{
				$this->mHtml .=  '<li>' . '<a href="uri/' . $link['object_id'] . '">' . $link['name'] . '</a></li>';
			}
			$this->mHtml .=  '</ul>';
		}		
		
		foreach ($tagged_with as $link)
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