<?php

require_once('../object_factory.php');
require_once('../query.php');
require_once('class_object2html.php');
require_once('class_cannonicalname2html.php');
require_once('class_feature2html.php');
require_once('class_genbank2html.php');
require_once('class_journal2html.php');
require_once('class_person2html.php');
require_once('class_reference2html.php');
require_once('class_specimen2html.php');
require_once('class_tag2html.php');
require_once('class_taxon_name2html.php');
require_once('issn_image.php');


function main()
{
	global $config;
	
	$object_id = '';
	
	
	// Has user supplied a GUID?
	if (isset($_GET['guid']))
	{
		$guid = $_GET['guid'];
		$namespace = $_GET['namespace'];
		$object_id = db_find_object_with_guid($namespace, $guid);
		
		if ($object_id == '')
		{
			echo 'guid not found';
			exit();
		}
	}	
	else
	{
		if (isset($_GET['id']))
		{
			$object_id = $_GET['id'];
		}
		else
		{
			echo 'No id';
			exit();
		}
	}
	
/*	$object_id = '18d3b506cb4b2d2ab2e8b9d6ea2957fa';
	$object_id = '50c76f37adcb535ddfa9ae6544ee3f2f';
	$object_id = '9b5f73ba1142519b57117afb80605f5b'; */

	
	$o = object_factory($object_id);
	$o->Retrieve();
	
	switch ($o->GetType())
	{
		case CLASS_REFERENCE:
			$h = new Reference2Html($o);
			break;
			
		case CLASS_TAXON_NAME:
			$h = new TaxonName2Html($o);
			break;

		case CLASS_PERSON:
			$h = new Person2Html($o);
			break;

		case CLASS_JOURNAL:
			$h = new Journal2Html($o);
			break;

		case CLASS_GENBANK:
			$h = new Genbank2Html($o);
			break;

		case CLASS_SPECIMEN:
			$h = new Specimen2Html($o);
			break;

		case CLASS_TAG:
			$h = new Tag2Html($o);
			break;

		case CLASS_FEATURE:
			$h = new Feature2Html($o);
			break;

		case CLASS_CANNONICALNAME:
			$h = new CannonicalName2Html($o);
			break;

			
		default:	
			$h = new Object2Html($o);
			break;
	}
	$h->Write();




}

main();



?>