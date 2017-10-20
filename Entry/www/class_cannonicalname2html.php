<?php

// Base HTML render (extend this for each object we want to display)

require_once('class_object2html.php');
require_once('../query.php');
require_once('flickr.php');

class CannonicalName2Html extends  Object2Html
{	

	function MainStart()
	{	
		$this->mHtml .= html_top();
		$this->mHtml .= '<div id="main-content-container">';
		
		$this->mHtml .= '<table>
		<tr>
		<td>
		<img src="images/tag_green.png" />
		</td>
		<td>';
		$this->mHtml .= '<h1>' . $this->mObject->GetTitle() . '</h1>';
		$this->mHtml .= '<p class="explain">is a name string</p>';
		$this->mHtml .= '</td></tr></table>';
		
		
	}

	function MainEnd()
	{
		global $config;
	
		$this->mHtml .= '<script type="text/javascript" src="http://ispecies.org/yj.php?search=' . $this->mObject->GetTitle() . '&callback=ws_results"></script>';
		$this->mHtml .= '</div>';
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
				
				. '<a href="' . $details['url'] .'">'
				. '<img src="media.php?id=' . $image_id 
					. '" width="' . $w . '"'
					. '" height="' . $h . '"'
					. '/>'
				. '</a>'
				. '</div>';
		}

	//}



	
	}
	
	function MainContent()
	{
		$this->MainDepiction();
		
		
		// uBio names tag specimens, hosts in GenBank, and ultimately we will match NCBI taxonomy to uBio...
		
		
		$tagged_with = db_incoming_links($this->mObject->GetObjectId(), RELATION_HOST_OF, CLASS_GENBANK);
		
		if (count($tagged_with) > 0)
		{
			$this->mHtml .= '<h3>Sequences where host is &quot;' . $this->mObject->GetTitle() . '&quot;</h3>';
			$this->mHtml .= '<ul>';
			foreach ($tagged_with as $link)
			{
				$this->mHtml .=  '<li id="' . $link['object_id']  . '">' . '<a href="uri/' . $link['object_id'] . '">' . $link['name'] . '</a></li>';
			}
			$this->mHtml .=  '</ul>';
		}		
		
		$tagged_with = db_incoming_links($this->mObject->GetObjectId(), RELATION_TAGGED_WITH_TAG, CLASS_SPECIMEN);
		
		if (count($tagged_with) > 0)
		{
			$this->mHtml .= '<h3>Specimens labelled as &quot;' . $this->mObject->GetTitle() . '&quot;</h3>';
			$this->mHtml .= '<ul>';
			foreach ($tagged_with as $link)
			{
				$this->mHtml .=  '<li id="' . $link['object_id']  . '">' . '<a href="uri/' . $link['object_id'] . '">' . $link['name'] . '</a></li>';
			}
			$this->mHtml .=  '</ul>';
		}		
		
		foreach ($tagged_with as $link)
		{
//			$this->mHtml .= '<script type="text/javascript" src="snippet.php?id=' . $link['object_id']. '"></script>';
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