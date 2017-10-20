<?php

	$feed = new DomDocument('1.0');
	$rdf = $feed->createElement('rdf:RDF');
	
	// namespaces
	$rdf->setAttribute('xmlns',         'http://purl.org/rss/1.0/');
	$rdf->setAttribute('xmlns:rdf',     'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
	$rdf->setAttribute('xmlns:foaf',    'http://xmlns.com/foaf/0.1/');
	$rdf->setAttribute('xmlns:dc',      'http://purl.org/dc/elements/1.1/');
	$rdf->setAttribute('xmlns:dcterms', 'http://purl.org/dc/terms/');
	$rdf->setAttribute('xmlns:prism',   'http://prismstandard.org/namespaces/1.2/basic/');
	
	$rdf = $feed->appendChild($rdf);
	
	// Channel
	$channel = $feed->createElement('channel');
	$channel->setAttributeNS('http://www.w3.org/1999/02/22-rdf-syntax-ns#about', 'fred', false);
	$channel = $rdf->appendChild($channel);
	
	echo $feed->saveXML();
?>
