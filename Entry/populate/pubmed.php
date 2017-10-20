<?php

// Add DOIs to database

require_once('../config.inc.php');
require_once('../class_genbank.php');
require_once('../class_reference.php');
require_once('../lib.php');

$pmids=array(
//18294389,
//18294389,
//18328107
//15723698
//17048002 // Wollbachia in lice
17643321
);

$get_links = true;

foreach ($pmids as $pmid)
{

	$url = 'http://bioguid.info/pmid/' . $pmid . '.json';
	echo $url;
	
	
	$j = get($url);
	
	$o = json_decode($j);

	$j = new Reference();
	$j->SetData($o);
	$j->Dump();
	$j->Store();		
	echo "<br/><b>" . $j->GetObjectId() . "</b>";
	
	if ($get_links)
	{
		$links = array();
		
		$url = 'http://eutils.ncbi.nlm.nih.gov/entrez/eutils/elink.fcgi?'
		            . '&dbfrom=pubmed'
		            . '&db=nucleotide'
		            . '&id=' . $pmid;
		            
		$xml = get($url);
		if (PHP_VERSION >= 5.0)
		{
			$dom= new DOMDocument;
			$dom->loadXML($xml);
			$xpath = new DOMXPath($dom);
			$xpath_query = "//eLinkResult/LinkSet/LinkSetDb/Link/Id";
			$nodeCollection = $xpath->query ($xpath_query);
			foreach($nodeCollection as $node)
			{
				array_push($links, $node->firstChild->nodeValue);
			}
		}
		foreach ($links as $gi)
		{
			$url = '';
			if (is_numeric($gi))
			{
				$url = 'http://bioguid.info/gi/' . $gi . '.json';
			}
			else
			{
				$url = 'http://bioguid.info/genbank/' . $gi . '.json';
			}
			echo $url;
			
			$j = get($url);
			
			$o = json_decode($j);
		
			$j = new Genbank();
			$j->SetData($o);
		//	$j->Dump();
			$j->Store();		
			echo "<br/><b>" . $j->GetObjectId() . "</b>";
		}
	}
	
}
?>

