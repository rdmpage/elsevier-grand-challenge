<?php

// $Id: $

/**
 * @file object_factory.php
 *
 *
 *
 */

// Make sure includes are absolute paths
$rootdir = dirname(__FILE__) . '/';

require_once($rootdir . 'class_object.php');
require_once($rootdir . 'class_cannonical.php');
require_once($rootdir . 'class_feature.php');
require_once($rootdir . 'class_genbank.php');
require_once($rootdir . 'class_journal.php');
require_once($rootdir . 'class_locality.php');
require_once($rootdir . 'class_person.php');
require_once($rootdir . 'class_reference.php');
require_once($rootdir . 'class_specimen.php');
require_once($rootdir . 'class_tag.php');
require_once($rootdir . 'class_taxon_name.php');


//------------------------------------------------------------------------------
/**
 * @brief Object factory
 *
 * Given an identifier, create corresponding object (object is not populated)
 *
 * @param id Object id (md5 hash as used internally)
 *
 * @return Object (or empty string)
 */
function object_factory($id)
{		
	$o = '';
	
	if(db_object_exists($id))
	{		
		switch (db_object_class($id))
		{
			case CLASS_REFERENCE:
				$o = new Reference($id);
				break;

			case CLASS_PERSON:
				$o = new Person($id);
				break;

			case CLASS_JOURNAL:
				$o = new Journal($id);
				break;

			case CLASS_CANNONICALNAME:
				$o = new CannonicalName($id);
				break;

			case CLASS_SPECIMEN:
				$o = new Specimen($id);
				break;

			case CLASS_TAG:
				$o = new Tag($id);
				break;

			case CLASS_TAXON_NAME:
				$o = new TaxonName($id);
				break;

			case CLASS_GENBANK:
				$o = new Genbank($id);
				break;

			case CLASS_FEATURE:
				$o = new Feature($id);
				break;

			case CLASS_LOCALITY:
				$o = new Locality($id);
				break;

			default:
				echo "<b>Unrecognised class " . db_object_class($id) . "</b>";
				break;
		}
	}
		
	return $o;

}


?>