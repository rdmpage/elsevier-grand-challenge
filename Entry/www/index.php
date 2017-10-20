<?php

require_once('../config.inc.php');
require_once($config['adodb_dir']);
require_once('../eav/eav.php');
require_once('html.php');
require_once('../query.php');
//require_once('searchClassify.php');



if (1)
{
	global $config;
	
	echo html_html_open();
	echo html_head_open();
	echo html_title("Challenge Demo");
		

	
	echo html_head_close();
	echo html_body_open();
	echo html_top($query);
?>
	<div id="main-content-container">
	<h1>Welcome to my Elsevier Challenge entry</h1>
	

<p>This web site is part of my entry in Elsevier's Grand Challenge <a href="http://www.elseviergrandchallenge.com/">"Knowledge Enhancement in the Life Sciences"</a>.My original proposal (rather grandly titled "Towards realising Darwin’s dream: setting the trees free") is available from Nature Precedings (<a href="http://dx.doi.org/10.1038/npre.2008.2217.1">doi:10.1038/npre.2008.2217.1</a>). A paper describing the actual entry is also available ("Visualising a scientific article", <a href="http://dx.doi.org/10.1038/npre.2008.2579.1">doi:10.1038/npre.2008.2579.1</a>).</p>

<p>My project uses a collection of fulltext issues of <i>Molecular Phylogenetics and Evolution</i> as the starting point, then extracts citation links to both papers and data, such as Genbank sequences and specimens, together with geotagged localities, and builds a "web" of objects linked by relationships. Each object (such as a publication, a sequence, a specimen, a taxon name, etc.) is treated equally, so that you can take a publication and see what taxa it refers to, or take the taxon and find all the publications that refer to the taxon. Although the database has been seeded with some articles from <i>Molecular Phylogenetics and Evolution</i>, much of the data comes from <a href="http://www.ncbi.nlm.nih.gov/Genbank/index.html">GenBank</a>, <a href="http://www.ncbi.nlm.nih.gov/sites/entrez?db=PubMed">PubMed</a>, and specimen databases. These are accessed through <a href="http://bioguid.info">bioguid.info</a>, a tool I constructed to resolve identifiers and return associated metadata.</p>

<h4>Background</h4>
<p>You can find background on this project <a href="http://iphylo.blogspot.com/search?q=challenge">on my blog</a>. In many ways the inspiration for this project is <a href="http://www.silobreaker.com/">SiloBreaker</a>. I will post a more detailed description of the project (and what goes on under the hood) shortly. You can also see <a href="http://iphylo.org/~rpage/demo1">my earlier attempt</a>. 
Meantime, some starting points (not all from <i>Molecular Phylogenetics and Evolution</i>) are:

<ul>
<li><a href="uri/50c76f37adcb535ddfa9ae6544ee3f2f">Mitochondrial paraphyly in a polymorphic poison frog species (Dendrobatidae; <i>D. pumilio</i>)</a></li>
<li><a href="uri/abf974e73baa90f0840b4d74e24aac2f">Multigenic and morphometric differentiation of ground squirrels (<i>Spermophilus</i>, Scuiridae, Rodentia) in Turkey, with a description of a new species</a></li>
<li><a href="uri/bd5469c5527b8d7f38dff58e06bc21d0">Single mitochondrial gene barcodes reliably identify sister-species in diverse clades of birds</a></li>
<li><a href="uri/8c7f93f2e1884d1ff8dbf3a5357288bf">The amphibian tree of life</a></li>
</ul>

</p>

<h4>Future</h4>
<p>
As it stands the demo has some glaring limitations, particularly regarding the lists of studies that are geographically overlapping. The lack of phylogenetic trees is also frustrating. In the absence of an automated way to extract trees from images, I may add some trees from <a href="http://www.treebase.org">TreeBASE</a> and disaply them using my <a href="http://code.google.com/p/tvwidget/">tvwidget</a>. There are also likely to be some errors in the underlying data, or in how it has been parsed. Meantime I welcome any feedback or comments.
</p>

<p>Rod Page</p>
	
<div id="disqus_thread"></div><script type="text/javascript" src="http://disqus.com/forums/challengedemo/embed.js"></script><noscript><a href="http://challengedemo.disqus.com/?url=ref">View the discussion thread.</a></noscript><a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>	
	
	</div>
	
	<div id="rightnav">
	
	<!-- YouTube -->
	<div class="rightnav-box">
	<div class="rightnavbox-content">
	<h4>Video about the challenge</h4>
	<object width="360" height="266"><param name="movie" value="http://www.youtube.com/v/RS-ZMispbhQ&hl=en&fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/RS-ZMispbhQ&hl=en&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="360" height="266"></embed></object>
	</div>
	</div>
	
	<!-- Treemap image -->
	<div class="rightnav-box"><div class="rightnavbox-content">
	<h4>What is a study about?</h4>
	<p class="explain">Visual summary of the organisms included in a  <a href="uri/16a254c7b1bb1dfcf24dea7c7b7af70c"><i>Molecular Phylogenetics and Evolution</i> article</a>.</p>	
	<img src="images/treemap.png" />
	</div>
	</div>
	
	<!-- Map -->
	<div class="rightnav-box"><div class="rightnavbox-content">
	<h4>Map</h4>
	<p class="explain">Example of a map automatically constructed from geotagged specimens cited by a <a href="uri/16a254c7b1bb1dfcf24dea7c7b7af70c"><i>Molecular Phylogenetics and Evolution</i> article</a>  (the map requires a browser that can display SVG, Internet Explorer users will need a plugin such as <a href="http://www.examotion.com/?id=product_player_download">RENESIS</a>).</p>
	
	<div>
<!--[if IE]>
<embed width="360" height="180" src="map_object.php?id=16a254c7b1bb1dfcf24dea7c7b7af70c&t=1227722057">
</embed>
<![endif]-->
<![if !IE]>
<object id="mysvg" type="image/svg+xml" width="360" height="180" data="map_object.php?id=16a254c7b1bb1dfcf24dea7c7b7af70c">
<p>Error, browser must support "SVG"</p>
</object>
<![endif]>	
</div>	

	</div>
	</div>
	

	
	</div>
<?php
	echo html_body_close();
	echo html_html_close();
}

?>

