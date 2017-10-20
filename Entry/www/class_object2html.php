<?php

// Base HTML render (extend this for each object we want to display)

require_once('html.php');
require_once('../class_object.php');

class Object2Html
{	
	var $mHtml;
	var $mObject;
	
	function Object2Html($obj)
	{
		$this->mHtml = '';
		$this->mObject = $obj;
	}
	
	function HeadExtra()
	{
	}
	
	function HeadScripts()
	{
		global $config;
		
		// Make object id accessible to scripts		
//		$this->mHtml .= '<script type="text/javascript">var gObject_id = \'' . $this->mObject->GetObjectId() . '\';</script>' . "\n";

		// Make webroot accessible to scripts		
		$this->mHtml .= '<script type="text/javascript">var gWebRoot = \'' . $config['webroot'] . '\';</script>' . "\n";
		
		$this->mHtml .= "<!-- Prototype -->\n";
		$this->mHtml .= html_include_script('prototype.js');
		
		$this->mHtml .=  "<!-- Pygmybrowse -->\n";
		$this->mHtml .=  html_include_css('pygmy.css');
		$this->mHtml .=  html_include_script('pygmy.js');
		

		
	// Javascript to handle Yahoo image search
	$this->mHtml .= '<script type="text/javascript">
function ws_results(obj) 
{
	d = document.getElementById("depiction");
	d.innerHTML= \'\';
	
	if (obj.ResultSet.Result.length > 0)
	{
		d.innerHTML += \'<a href="\' +  obj.ResultSet.Result[0].RefererUrl + \'"><img src="\' + obj.ResultSet.Result[0].Thumbnail.Url + \'"\'
	 	+ \' width="\' + obj.ResultSet.Result[0].Thumbnail.Width + \'"\'
	 	+ \' height="\' + obj.ResultSet.Result[0].Thumbnail.Height + \'"\'
	 	+ \' border="1" \'
	 	+ \'><\/img></a>\';
	 	
	 	d.innerHTML += \'<br/><span style="font-size:10px;color:rgb(128,128,128);">\' + obj.ResultSet.Result[0].Summary + \'</span>\';
	
	 }		
}</script>';		

	// depiction
	$this->mHtml .= '<script type="text/javascript">
function snippet(obj) 
{
	var pattern = \'li[id^="\' + obj.object_id + \'"]\';
	var elements = $$(pattern);
	elements.each( function(dis) { dis.innerHTML= obj.html } );

}</script>';	
		
	}
	
	function StartPage()
	{
		global $config;
		
		$title = $this->mObject->GetTitle();

		$this->mHtml = html_html_open();
		$this->mHtml .= html_head_open();
		$this->mHtml .=  html_title($title);
/*		$this->mHtml .=  "<!-- Alternative formats -->\n";
		$this->mHtml .=   '<link type="application/rss+xml" title="RSS 2.0" rel="alternate" href="'. $config['webroot'] . 'rss/uri/' . $this->mObject->GetObjectId() .'" />' . "\n";
		$this->mHtml .=   '<link type="application/rdf+xml" title="RDF" rel="alternate" href="' . $config['webroot'] . 'rdf/uri/' . $this->mObject->GetObjectId() . '" />' . "\n";
*/		
		$this->HeadScripts();

		$this->HeadExtra();
		
		$this->mHtml .= html_head_close();
		$this->mHtml .= html_body_open();
		
		
		// Tooltip
		$this->mHtml .=  html_include_script('scripts/wz_tooltip.js');
		
		
		
//		$this->mHtml .= '<div id="load">Loading...</div>';
		
	}
	
	function EndPage()
	{
		$this->mHtml .= html_body_close();
		$this->mHtml .= html_html_close();
	}
	
	function MainDepiction()
	{
		$this->mHtml .= '<h3>Photos</h3>';
		$this->mHtml .= '<p class="explain">(from Yahoo Image search)</p>';
		
		$this->mHtml .= '<div id="depiction"><img src="images/ajax-loader.gif" /></div>';
	}
	
	function MainStart()
	{	
		$this->mHtml .= html_top();
		$this->mHtml .= '<div id="main-content-container">';
		$this->mHtml .= '<h1>' . $this->mObject->GetTitle() . '</h1>';		
	}
	
	function MainEnd()
	{
		global $config;
		$this->mHtml .= '</div>';
	}
	
		
	function MainContent()
	{
		$this->MainDepiction();
	}
	
	function Main()
	{
		$this->MainStart();
		$this->MainContent();
		$this->MainEnd();
	}
	
	
	function RightNavStart()
	{
		$this->mHtml .= '<div id="rightnav">';
//		$this->mHtml .= $this->DisplayFeeds();		
	}
	function RightNavEnd()
	{
		$this->mHtml .= '</div>';
	}
	
	// empty block
	function RightNavContent()
	{
		$this->mHtml .= '<div class="rightnav-box">';
		$this->mHtml .= '<div class="rightnavbox-content">';
		$this->mHtml .= '<p>Hi</p>';
		$this->mHtml .= '</div>';
		$this->mHtml .= '</div>';
	
	}
	
	function RightNavGuids()
	{
		$this->mHtml .= '<div class="rightnav-box">';
		$this->mHtml .= '<div class="rightnavbox-content">';
		
		
		$this->mHtml .= '<h4>Identifiers</h4>';
		
		// guids
		$guids = db_retrieve_guids($this->mObject->GetObjectId());
		
		$this->mHtml .= '<ul>';
		foreach ($guids as $guid)
		{
			switch($guid['namespace'])
			{
				case 'doi':
					$this->mHtml .= '<li>';
					$this->mHtml .= '<a href="http://dx.doi.org/' . $guid['identifier'] . '" target = "_new">';
					$this->mHtml .= 'doi:' . $guid['identifier'];
					$this->mHtml .= '</a>';
					$this->mHtml .= '</li>';
					break;
				case 'hdl':
					$this->mHtml .= '<li>';
					$this->mHtml .= '<a href="http://hdl.handle.net/' . $guid['identifier'] . '" target = "_new">';
					$this->mHtml .= 'hdl:' . $guid['identifier'];
					$this->mHtml .= '</a>';
					$this->mHtml .= '</li>';
					break;
				case 'pmid':
					$this->mHtml .= '<li>';
					$this->mHtml .= '<a href="http://view.ncbi.nlm.nih.gov/pubmed/' . $guid['identifier'] . '" target = "_new">';
					$this->mHtml .= 'pmid:' . $guid['identifier'];
					$this->mHtml .= '</a>';
					$this->mHtml .= '</li>';
					break;
				case 'taxid':
					$this->mHtml .= '<li>';
					$this->mHtml .= '<a href="http://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?id=' . $guid['identifier'] . '" target = "_new">';
					$this->mHtml .= 'taxon:' . $guid['identifier'];
					$this->mHtml .= '</a>';
					$this->mHtml .= '</li>';
					break;
				case 'issn':
					$this->mHtml .= '<li>';
					$this->mHtml .= '<a href="http://www.worldcat.org/issn/' . $guid['identifier'] . '" target = "_new">';
					$this->mHtml .= 'ISSN:' . $guid['identifier'];
					$this->mHtml .= '</a>';
					$this->mHtml .= '</li>';
					break;
				case 'gi':
					$this->mHtml .= '<li>';
					$this->mHtml .= '<a href="http://view.ncbi.nlm.nih.gov/nucleotide/' . $guid['identifier'] . '" target = "_new">';
					$this->mHtml .= 'gi:' . $guid['identifier'];
					$this->mHtml .= '</a>';
					$this->mHtml .= '</li>';
					break;
				case 'genbank':
					$this->mHtml .= '<li>';
					$this->mHtml .= '<a href="http://view.ncbi.nlm.nih.gov/nucleotide/' . $guid['identifier'] . '" target = "_new">';
					$this->mHtml .= 'Accession:' . $guid['identifier'];
					$this->mHtml .= '</a>';
					$this->mHtml .= '</li>';
					break;
				case 'namebankID':
					$this->mHtml .= '<li>';
					$this->mHtml .= '<a href="http://www.ubio.org/browser/details.php?namebankID=' . $guid['identifier'] . '" target = "_new">';
					$this->mHtml .= 'namebankID:' . $guid['identifier'];
					$this->mHtml .= '</a>';
					$this->mHtml .= '</li>';
					break;
				case 'url':
					$this->mHtml .= '<li>';
					$this->mHtml .= '<a href="' . $guid['identifier'] . '" target = "_new">';
					$this->mHtml .= $guid['identifier'];
					$this->mHtml .= '</a>';
					$this->mHtml .= '</li>';
					break;
					
				default:
					break;
			}
					
		
/*			$this->mHtml .= '<li>';
			$this->mHtml .= $guid['identifier'] . '<br/>';
			$this->mHtml .= '</li>';*/
		}
		$this->mHtml .= '</ul>';

//		$this->mHtml .= '<p>Bookmark</p>';
		$this->mHtml .= '</div>';
		$this->mHtml .= '</div>';
	
	}	
	
	function RightNav()
	{
		$this->RightNavStart();
		$this->RightNavGuids();
		$this->RightNavMap();
		$this->RightNavExtra();
		$this->RightNavEnd();
	}
	
	function RightNavExtra()
	{
	}
	
	function RightNavMapHeading()
	{
		$this->mHtml .= '<h4>Distribution of object</h4>';	
	}
	
	function RightNavMapQuery()
	{
		$this->mHtml .= '<p>Query</p>';	
	}
	
	
	function RightNavMap()
	{
		global $config;
		
		$this->mHtml .= '<div class="rightnav-box">';
		$this->mHtml .= '<div class="rightnavbox-content">';
		
		$this->RightNavMapHeading();
		
		$this->mHtml .= '<div>'; // style="text-align:center">';
		
		$this->mHtml .= '
<!--[if IE]>
<embed width="360" height="180" src="map_object.php?id=' . $this->mObject->GetObjectId() . '&t=' . time() . '">
</embed>
<![endif]-->
<![if !IE]>
<object id="mysvg" type="image/svg+xml" width="360" height="180" data="map_object.php?id=' . $this->mObject->GetObjectId() . '">
<p>Error, browser must support "SVG"</p>
</object>
<![endif]>	';
		
		$this->mHtml .= '</div>';
		
		// KML
		$this->mHtml .= '<span style="font-size:11px;"><img src="images/google_earth_link.gif" width="16" height="16" align="absmiddle"/> <a href="kml.php?id=' . $this->mObject->GetObjectId() . '">View in Google Earth</a></span>';
		
		$this->RightNavMapQuery();
		
		
		$this->mHtml .= '</div>';
		$this->mHtml .= '</div>';
		
	}
	
	
	function Write()
	{
		$this->StartPage();
		$this->Main();
		$this->RightNav();
		$this->EndPage();
		
		echo $this->mHtml;
	}
}


?>