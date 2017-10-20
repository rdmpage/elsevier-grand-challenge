<?php

// $Id: $

/**
 * @file class_genbank.php
 *
 * Encapsulate a Genbank record
 *
 *
 *
 */

// Make sure includes are absolute paths
$rootdir = dirname(__FILE__) . '/';

require_once($rootdir . 'class_object.php');
require_once($rootdir . 'class_cannonical.php');
require_once($rootdir . 'class_feature.php');
require_once($rootdir . 'class_reference.php');
require_once($rootdir . 'class_specimen.php');
require_once($rootdir . 'class_taxon_name.php');

//--------------------------------------------------------------------------------------------------
/**
 * @brief Encapsulate a Genbank record
 *
 */
 
define('CLASS_GENBANK',		9);
 
//--------------------------------------------------------------------------------------------------
/**
 * @brief Encapsulate a specimen
 *
 */
class Genbank extends Object
{	

	//--------------------------------------------------------------------------------
	/**
	 * @brief Generate name for specimen
	 *
	 */
	function CreateName()
	{
		$this->mName = $this->mData->title;
	}	
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Create a descriptive string for the object.
	 *
	 */
	function CreateDescription()
	{
		$this->mDescription = $this->mData->description;
	}	
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Generate object identifier
	 *
	 *
	 */
	function GenerateObjectId()
	{
		$this->mObjectId = md5($this->mData->accession);
	}	
	
	
	//----------------------------------------------------------------------------------------------
	function GetHtmlSnippet()
	{
		return $this->GetAttributesAsHtmlTable();
	}
	
		
		
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Post process reference
	 *
	 * Make source info available (hugely clunky)
	 *
	 */
	function PostProcess()
	{
		
		if(isset($this->mData->source->isolate)) { $this->mData->isolate = $this->mData->source->isolate; }
		if(isset($this->mData->source->host)) { $this->mData->host = $this->mData->source->host; }
		if(isset($this->mData->source->host_namebankID)) { $this->mData->host_namebankID = $this->mData->source->host_namebankID; }
		if(isset($this->mData->source->specimen_voucher)) { $this->mData->specimen_voucher = $this->mData->source->specimen_voucher; }
		if(isset($this->mData->source->specimen_code)) { $this->mData->specimen_code = $this->mData->source->specimen_code; }
		if(isset($this->mData->source->organelle)) { $this->mData->organelle = $this->mData->source->organelle; }
		if(isset($this->mData->source->organism)) { $this->mData->organism = $this->mData->source->organism; }
		if(isset($this->mData->source->lat_lon)) { $this->mData->lat_lon = $this->mData->source->lat_lon; }
		if(isset($this->mData->source->country)) { $this->mData->country = $this->mData->source->country; }
		if(isset($this->mData->source->locality)) { $this->mData->locality = $this->mData->source->locality; }

		if(isset($this->mData->source->latitude)) { $this->mData->latitude = $this->mData->source->latitude; }
		if(isset($this->mData->source->longitude)) { $this->mData->longitude = $this->mData->source->longitude; }

		if(isset($this->mData->source->note)) { $this->mData->note = $this->mData->source->note; }
		if(isset($this->mData->source->collection_date)) { $this->mData->collection_date = $this->mData->source->collection_date; }
		if(isset($this->mData->source->collected_by)) { $this->mData->collected_by = $this->mData->source->collected_by; }
		if(isset($this->mData->source->PCR_primers)) { $this->mData->PCR_primers = $this->mData->source->PCR_primers; }
		if(isset($this->mData->source->identified_by)) { $this->mData->identified_by = $this->mData->source->identified_by; }
	}		
		
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Set object type (must be defined in each object)
	 *
	 */
	function SetType()
	{
		$this->mClassId = CLASS_GENBANK;
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Store object GUIDs in EAV database
	 *
	 *
	 * @param author_id Unique identifier for author or agent storing the object
	 * @param ip IP address of author or agent storing the object
	 * @param comment Comment describing the edit 
	 */
	function StoreGuids($author_id, $ip, $comment)
	{
		
		if (isset($this->mData->accession))
		{
			db_store_object_guid($this->mObjectId, 'genbank', $this->mData->accession, $author_id, $ip, $comment);
		}
		if (isset($this->mData->gi))
		{
			db_store_object_guid($this->mObjectId, 'gi', $this->mData->gi, $author_id, $ip, $comment);
		}
	}		
			
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Store links between this object and any associated objects
	 *
	 * Link sequence to gene name tags
	 * Link to NCBI taxon...
	 *
	 * @param author_id Unique identfiier for author or agent storing the object
	 * @param ip IP address of author or agent storing the object
	 * @param comment Comment describing the edit 
	 */
	function StoreLinks($author_id, $ip, $comment)
	{
		//------------------------------------------------------------------------------------------
		// Link to NCBI taxon name		
		$o = new stdClass;
		$o->taxId = str_replace("taxon:", "", $this->mData->source->db_xref);
		$o->title = $this->mData->source->organism;
		
		$j = new TaxonName();
		$j->SetData($o);
		$j->Store();
		
		// link
		db_link_objects(
			$this->GetObjectId(),
			$j->GetObjectId(), 
			RELATION_SOURCE,
			1,
			$author_id, $ip, $comment);
		
		//------------------------------------------------------------------------------------------
		// Link to host
		if (isset($this->mData->source->host))
		{
			$o = new stdClass;
			$o->title= $this->mData->host;
		
			if (isset($this->mData->host_namebankID))
			{
				$o->namebankID = $this->mData->host_namebankID;
			}		
			print_r($o);
			$name = new CannonicalName();
			$name->SetData($o);
			$name->Store();		
			
			$name->Dump();
			
			$name_id = $name->GetObjectId();
			
			echo "$name_id=$name_id\n";
			
			db_link_objects(
				$this->GetObjectId(),
				$name_id, 
				RELATION_HOSTED_BY,
				1,
				$author_id, $ip, $comment);
		}
		
		//------------------------------------------------------------------------------------------
		// Link to specimen (if we have one)
		if (isset($this->mData->source->specimen))
		{
			$j = new Specimen();
			$j->SetData($this->mData->source->specimen);
			$j->Store();
						
			db_link_objects(
				$j->GetObjectId(),
				$this->GetObjectId(), 
				RELATION_VOUCHER_FOR,
				1,
				$author_id, $ip, $comment);
		}
		
		//------------------------------------------------------------------------------------------
		// Link to features
		foreach ($this->mData->features as $f)
		{
		
			switch ($f->key)
			{
				case 'CDS':
				case 'gene':
				case 'tRNA':
				case 'rRNA':
				case 'misc_feature':				
					$o = new stdClass;
					$o->key = $f->key;
					$o->name = $f->name;
					
					$j = new Feature();
					$j->SetData($o);
					$j->Store();
					
					// link
					db_link_objects(
						$this->GetObjectId(),
						$j->GetObjectId(), 
						RELATION_TAGGED_WITH_TAG,
						1,
						$author_id, $ip, $comment);
					break;
					
				case 'mRNA':
					break;
					
				default:
					break;
			}
		}				
		
		
		//------------------------------------------------------------------------------------------
		// Link to literature
		foreach ($this->mData->references as $ref)
		{
			// we should have enough to add this to the EAV if necessary (details are resolved by
			// the bioGUID resolver
			
			if (isset($ref->doi)
				|| isset($ref->hdl)
				|| isset($ref->url)
				|| isset($ref->pmid)
				|| isset($ref->issn)
				)
			{
				$j = new Reference();
				$j->SetData($ref);
				$j->Store();
				
				// link
				db_link_objects(
					$j->GetObjectId(), 
					$this->GetObjectId(),
					RELATION_REFERENCES,
					1,
					$author_id, $ip, $comment);
			}
		}
				
	}

}


if (0)
{
	$j = '{
  "gi": "40809698",
  "accession": "AB105343",
  "title": "AB105343",
  "version": "AB105343.1",
  "created": "2004-01-14",
  "updated": "2005-06-30",
  "description": "Opalina sp. Ra3 gene for 18S ribosomal RNA, partial sequence",
  "taxonomy": "Eukaryota; stramenopiles; Slopalinida; Opalinidae; Opalina",
  "references": [
    {
      "authors": [
        {
          "lastname": "Nishi",
          "initials": "A."
        },
        {
          "lastname": "Ishida",
          "initials": "K."
        },
        {
          "lastname": "Endoh",
          "initials": "H."
        }
      ],
      "atitle": "Reevaluation of the evolutionary position of opalinids based on 18S rDNA, and alpha- and beta-tubulin gene phylogenies",
      "title": "J. Mol. Evol. 60 (6), 695-705 (2005)",
      "pmid": "15931497",
      "doi": "10.1007\/s00239-004-0149-x"
    },
    {
      "authors": [
        {
          "lastname": "Endoh",
          "initials": "H."
        },
        {
          "lastname": "Nishi",
          "initials": "A."
        },
        {
          "lastname": "Ishida",
          "initials": "K."
        }
      ],
      "atitle": "Direct Submission",
      "title": "Submitted (10-MAR-2003) Hiroshi Endoh, Kanazawa University, Department of Biology, Faculty of Science; Kakuma, Kanazawa, Ishikawa 920-1192, Japan (E-mail:hendoh@kenroku.kanazawa-u.ac.jp, Tel:81-76-264-6074, Fax:81-76-264-6099)"
    }
  ],
  "source": {
    "organism": "Opalina sp. Ra3",
    "mol_type": "genomic DNA",
    "isolate": "Ra3",
    "host": "Rhacophorus arboreus",
    "db_xref": "taxon:224007",
    "country": "Japan",
    "locality": "Ishikawa, Kanazawa, Utatsu",
    "host_namebankID": "30726"
  },
  "features": [
    {
      "key": "rRNA",
      "location": "<1..>229",
      "name": "18S ribosomal RNA"
    }
  ],
  "sequence": "ttagatgttctgggccgcacgtgtgacacaatgatatattcaataagtataattttttatatattatattataaatttatttataatataatataaaaatctaaactgtaaagttatgataatcttaaatatatatcgtgtttgggattgatgcttgtaattattcatcatgaacgaggaacacctagtaagtgcaagtcatcagcttgcgctgaatacgtccctgccc"
}';


$j='
{
  "gi": "8100592",
  "accession": "AF191520",
  "title": "AF191520",
  "version": "AF191520.1",
  "created": "2000-05-29",
  "updated": "2003-06-24",
  "description": "Fontinalis squamosa tRNA-Leu (trnL) and tRNA-Phe (trnF) genes, partial sequence; chloroplast genes for chloroplast products",
  "taxonomy": "Eukaryota; Viridiplantae; Streptophyta; Embryophyta; Bryophyta; Moss Superclass V; Bryopsida; Bryidae; Hypnanae; Hypnales; Fontinalaceae; Fontinalis",
  "references": [
    {
      "authors": [
        {
          "lastname": "Shaw",
          "initials": "A.J."
        },
        {
          "lastname": "Allen",
          "initials": "B."
        }
      ],
      "atitle": "Phylogenetic relationships, morphological incongruence, and geographic speciation in the fontinalaceae (Bryophyta)",
      "title": "Mol. Phylogenet. Evol. 16 (2), 225-237 (2000)",
      "pmid": "10942609"
    },
    {
      "authors": [
        {
          "lastname": "Shaw",
          "initials": "A.J."
        },
        {
          "lastname": "Allen",
          "initials": "B."
        }
      ],
      "atitle": "Direct Submission",
      "title": "Submitted (01-OCT-1999) Department of Botany, Duke University, Durham, NC 27708, USA"
    }
  ],
  "source": {
    "organism": "Fontinalis squamosa",
    "organelle": "plastid:chloroplast",
    "mol_type": "genomic DNA",
    "isolate": "FS489",
    "specimen_voucher": "Allen Exs. #129(DUKE)",
    "db_xref": "taxon:123094"
  },
  "features": [
    {
      "key": "gene",
      "location": "<1..354",
      "name": "trnL"
    },
    {
      "key": "tRNA",
      "location": "join(<1..22,305..354)",
      "name": "trnL"
    },
    {
      "key": "misc_feature",
      "location": "355..409",
      "name": "Region: trnL-trnF spacer"
    },
    {
      "key": "gene",
      "location": "410..>474",
      "name": "trnF"
    },
    {
      "key": "tRNA",
      "location": "410..>474",
      "name": "trnF"
    }
  ],
  "sequence": "aatcggtagacgctacggacttaaataatttgagcgttagtagaaaaacttactaaatgctagctttcagattcagggaaacttaggctgataaaaatataagcaatcctgagccaaatcttatttcgtttgaaaataaaataggtgcagagactcaatggaagctatcctaacgaacactattttacaaattactacattttaaaaattattaaaaatctagtttttaactagtaagcgaggataaagatagagtccaattttacatgttaatcttagcaacaatttaaattgtagtaaaaagaaaatccgttggctttattgaccgtgagggttcaagtccctctacccccaaaaaatatagttttttattgacataaacttccagtttatgttaggataaactaataaaaaaagccggaatagctcagttggtanagcagaggactgaaaatcctcgtgtcaccagttcaa"
}';

$j=
'{
  "gi": "32469179",
  "accession": "AB099483",
  "title": "AB099483",
  "version": "AB099483.1",
  "created": "2003-07-08",
  "updated": "2003-07-19",
  "description": "Urotrichus talpoides mitochondrial DNA, complete genome",
  "taxonomy": "Eukaryota; Metazoa; Chordata; Craniata; Vertebrata; Euteleostomi; Mammalia; Eutheria; Laurasiatheria; Insectivora; Talpidae; Urotrichus",
  "references": [
    {
      "authors": [
        {
          "lastname": "Nikaido",
          "initials": "M."
        },
        {
          "lastname": "Cao",
          "initials": "Y."
        },
        {
          "lastname": "Harada",
          "initials": "M."
        },
        {
          "lastname": "Okada",
          "initials": "N."
        },
        {
          "lastname": "Hasegawa",
          "initials": "M."
        }
      ],
      "atitle": "Mitochondrial phylogeny of hedgehogs and monophyly of Eulipotyphla",
      "title": "Mol. Phylogenet. Evol. 28 (2), 276-284 (2003)",
      "pmid": "12878464"
    },
    {
      "authors": [
        {
          "lastname": "Nikaido",
          "initials": "M."
        },
        {
          "lastname": "Cao",
          "initials": "Y."
        },
        {
          "lastname": "Harada",
          "initials": "M."
        },
        {
          "lastname": "Okada",
          "initials": "N."
        },
        {
          "lastname": "Hasegawa",
          "initials": "M."
        }
      ],
      "atitle": "Direct Submission",
      "title": "Submitted (06-JAN-2003) Masato Nikaido, Tokyo Institute of Technology, Graduate school of Bioscience and Biotechnology; Nagatsuta-cho 4259, Yokohama-si Midori-ku, Kanagawa 2268501, Japan (E-mail:mnikaido@bio.titech.ac.jp, Tel:81459245742, Fax:81459245835)"
    }
  ],
  "source": {
    "organism": "Urotrichus talpoides",
    "organelle": "mitochondrion",
    "mol_type": "genomic DNA",
    "db_xref": "taxon:106106"
  },
  "features": [
    {
      "key": "tRNA",
      "location": "1..70",
      "name": "tRNA-Phe"
    },
    {
      "key": "rRNA",
      "location": "71..1037",
      "name": "12S ribosomal RNA"
    },
    {
      "key": "tRNA",
      "location": "1038..1104",
      "name": "tRNA-Val"
    },
    {
      "key": "rRNA",
      "location": "1105..2683",
      "name": "16S ribosomal RNA"
    },
    {
      "key": "tRNA",
      "location": "2689..2764",
      "name": "tRNA-Leu"
    },
    {
      "key": "gene",
      "location": "2768..3724",
      "name": "ND1"
    },
    {
      "key": "CDS",
      "location": "2768..3724",
      "name": "NADH dehydrogenase subunit 1"
    },
    {
      "key": "tRNA",
      "location": "complement(3723..3791)",
      "name": "tRNA-Gln"
    },
    {
      "key": "tRNA",
      "location": "3862..3930",
      "name": "tRNA-Met"
    },
    {
      "key": "gene",
      "location": "3931..4974",
      "name": "ND2"
    },
    {
      "key": "CDS",
      "location": "3931..4974",
      "name": "NADH dehydrogenase subunit 2"
    },
    {
      "key": "tRNA",
      "location": "4973..5041",
      "name": "tRNA-Trp"
    },
    {
      "key": "tRNA",
      "location": "complement(5049..5117)",
      "name": "tRNA-Ala"
    },
    {
      "key": "tRNA",
      "location": "complement(5119..5191)",
      "name": "tRNA-Asn"
    },
    {
      "key": "tRNA",
      "location": "complement(5232..5298)",
      "name": "tRNA-Cys"
    },
    {
      "key": "tRNA",
      "location": "complement(5299..5363)",
      "name": "tRNA-Tyr"
    },
    {
      "key": "gene",
      "location": "5367..6911",
      "name": "CO1"
    },
    {
      "key": "CDS",
      "location": "5367..6911",
      "name": "cytochrome oxidase subunit 1"
    },
    {
      "key": "tRNA",
      "location": "complement(6913..6981)",
      "name": "tRNA-Ser"
    },
    {
      "key": "tRNA",
      "location": "6989..7057",
      "name": "tRNA-Asp"
    },
    {
      "key": "gene",
      "location": "7058..7741",
      "name": "CO2"
    },
    {
      "key": "CDS",
      "location": "7058..7741",
      "name": "cytochrome oxidase subunit 2"
    },
    {
      "key": "tRNA",
      "location": "7745..7812",
      "name": "tRNA-Lys"
    },
    {
      "key": "gene",
      "location": "7815..8018",
      "name": "ATPase8"
    },
    {
      "key": "CDS",
      "location": "7815..8018",
      "name": "ATPase subunit 8"
    },
    {
      "key": "gene",
      "location": "7976..8656",
      "name": "ATPase6"
    },
    {
      "key": "CDS",
      "location": "7976..8656",
      "name": "ATPase subunit 6"
    },
    {
      "key": "gene",
      "location": "8656..9439",
      "name": "CO3"
    },
    {
      "key": "CDS",
      "location": "8656..9439",
      "name": "cytochrome oxidase subunit 3"
    },
    {
      "key": "tRNA",
      "location": "9440..9510",
      "name": "tRNA-Gly"
    },
    {
      "key": "gene",
      "location": "9511..9856",
      "name": "ND3"
    },
    {
      "key": "CDS",
      "location": "9511..9856",
      "name": "NADH dehydrogenase subunit 3"
    },
    {
      "key": "tRNA",
      "location": "9857..9925",
      "name": "tRNA-Arg"
    },
    {
      "key": "gene",
      "location": "9927..10223",
      "name": "ND4L"
    },
    {
      "key": "CDS",
      "location": "9927..10223",
      "name": "NADH dehydrogenase subunit 4L"
    },
    {
      "key": "gene",
      "location": "10217..11594",
      "name": "ND4"
    },
    {
      "key": "CDS",
      "location": "10217..11594",
      "name": "NADH dehydrogenase subunit 4"
    },
    {
      "key": "tRNA",
      "location": "11595..11663",
      "name": "tRNA-His"
    },
    {
      "key": "tRNA",
      "location": "11664..11724",
      "name": "tRNA-Ser"
    },
    {
      "key": "tRNA",
      "location": "11728..11797",
      "name": "tRNA-Leu"
    },
    {
      "key": "gene",
      "location": "11798..13618",
      "name": "ND5"
    },
    {
      "key": "CDS",
      "location": "11798..13618",
      "name": "NADH dehydrogenase subunit 5"
    },
    {
      "key": "gene",
      "location": "complement(13602..14129)",
      "name": "ND6"
    },
    {
      "key": "CDS",
      "location": "complement(13602..14129)",
      "name": "NADH dehydrogenase subunit 6"
    },
    {
      "key": "tRNA",
      "location": "complement(14130..14198)",
      "name": "tRNA-Glu"
    },
    {
      "key": "gene",
      "location": "14203..15342",
      "name": "cytb"
    },
    {
      "key": "CDS",
      "location": "14203..15342",
      "name": "cytochrome b"
    },
    {
      "key": "tRNA",
      "location": "15343..15409",
      "name": "tRNA-Thr"
    },
    {
      "key": "tRNA",
      "location": "complement(15409..15477)",
      "name": "tRNA-Pro"
    }
  ],
  "sequence": "gtcgatgtagcttaattatcaaagcaaggcactgaaaatgcctagatgagttttaataactccattaacattaaaaggtttggtcctagcctttctattagctgtcagtaaaattacacatgcaagtttccgcaccccagtgagaatacccttgaagtcaaaaacgacataaaggagttggcatcaagtacaccacccaatggtagctaataacgccttgcctagccacacccccacgggatacagcagtgataaaaattaagctatgaacgaaagtttgactaagttatactgacacagggttggtaaatttcgtgccagccaccgcggtcatacgattaacccaagttaatagacgtacggcgtaaagagtgttgaagaattaaccataataattaaagccaagacttaactaagatgtaaaaacctacagttaaagtaaaaataagctacgaaagtggctttaacatttttccgattacacgatagctaagacccaaactgggattagataccccactatgcttagccctaaaccaagacaatccaattaacaagattgtccgccagagaactactagcaacagcttaaaactcaaaggacttggcggtgctttatatccctctagaggagcctgttctataatcgataaaccccgataaacctcaccaacccttgctaattcagcctatataccgccatcttcagcaaaccctcaaaaggaatcgcagtaagcacaagtataagcataaaaacgttaggtcaaggtgtagctaatgggctgggaagaaatgggctacattttctatttttagaacattcacgaaaacctttatgaaactaaaggttaaaggcggatttagtagtaaattaagaatagagcgcttaattgaattaggccatgaagcacgcacacaccgcccgtcaccctcctcaagtattaaacctcctaccaatacataataacaggataacaggtatgagaggagataagtcgtaacaaggtaagcatactggaaagtgtgcttggattaatcaaagtgtagcttaacaaaagcacctggcttacacccagaagatttcattaaaaatgaccactttgaactaaagctagcccaacccaaaccaaattcaactataattaattaataaaacaaaacatttatcaaaataaaagtataggagatagaaattatgaactggcgctatagagaaagtaccgtaagggaacgagtgaaagaacttaattaaaagtaaaaaaaagcaaagattaaaccttttaccttttgcataatgaattaactagaacatcttagcaaagagaactttagttaagaaccccgaaaccagacgagctacctaagagcagcaaaaaagagcaaactcatctatgtggcaaaatagtgagaagacttttaggtagaggtgaaaagcctaccgagcctggtgatagctggttgtccagaaaagaatgtaagttcaactttaatttatacacaaaaaaaaaacaaattttaatgtaaaattaaatgttagtctaaggaggtacagccccttagacgcaggatacaaccttgcctggcgagtaagcattttaaacaaaccatagttggcctaaaagcagccaccaattaagaaagcgttcaagctcaacaacaaaaattttattaatcccaaaaatggaactaactcccagattttaactggactaatctatatatatatatagaagaattactgttaatatgagtaacgagaatttttttctccctgcacaagcctatatcagatcggataaccactgatagttaacagccatataacccaaaccacaaattaaccggcttataaaataaactgttaatccaacacaggagtgctactaatcaagggaaagattaaaagaagtaaaaggaactcggcaaacataaaccccgcctgtttaccaaaaacatcacctctggcattttcagtatcagaggcactgcctgcccagtgacgcaagttaaacggccgcggtatcctgaccgtgcaaaggtagcataatcatttgttctctaattaaggacttgtatgaacggccacacgagggtttaactgtctcttacttccaatcagtgaaattgaccttcccgtgaagaggcgggaatgacataacaagacgagaagaccctatggagctttaattaactaacccaaaaaaaaaataactccattccgacaggaactatatttacataaaactgggttaacaattttggttggggtgacctcggagcataaactaacctccgagtgattttagcttagacctacaagtcaaagcccactaatcacaattgatccaataacttttgatcaacggaacaagttaccctagggataacagcgcaatcctatttaagagttcatatcgacaatagggtttacgacctcgatgttggatcaggacatcccaatggtgcagccgctattaatggttcgtttgttcaacgattaaagtcctacgtgatctgagttcagaccggagtaatccaggtcggtttctatctattttatatttctcccagtacgaaaggacaagagaaatgaggcctactctacctgagagccttaaaaccaatagatgatttcatctcaatctagtaatttataacaatacagccctagaaatagggcttcgtaacgttagggtggcagagcccggtaattgcgtaaaatttaagactttatttctcagaggttcaattcctctccctaacataaatgttcttaatcaacctactagccctaatcgtgccaatcttacttgccgtggcttttcttaccctagttgaacgcaaggtattaggatatatacaactccgaaaaggaccaaacatcgtaggaccatatggactcctccaacccatcgcagatgccgttaaactattcaccaaagaaccactacgacctctaacttcctcaatctccatattcattatcgccccaatccttgccctaacactagccctcaccatatgaattccactccctataccatacccgcttatcaacataaatttaagcgtactatttatcctggccgtatcaagcctagctgtatattcaatcttatgatctggatgagcctccaattctaaatacgcattaatcggagcattacgagcagtagcacaaaccatctcatatgaagtcacactagcaatcatcctactctccatcttactaataagcggttcattctcactttcaaacctaattgtaacccaagaatatacttgactcctactctcatcatgaccactagccataatatgatttatctcgaccctagcagaaaccaatcgagctccctttgacctcacagaaggagaatctgaactagtttcagggtttaacgtagaatatgccgcaggcccatttgccttatttttcctagcagaatatgccaacatcattataataaatgtcctaaccaccattctatttctcggggcattccatagcccacatataccagaactctactccattaactttacagttaaagccctaatccttatcatctcattcttatgagtacgagcttcatatccccgatttcgatatgatcaactaatacacttactatgaaaaaatttcctaccccttaccctagcaatatgtatatgacacgtctcattcccaattttcctttccggtatcccaccccaaacctagaaatatgtctgataaaagagttactttgatagagtaaataatagaggtttaaaccctcttatttctagaattataggactcgaacctattcccaagaattcaaaaatctttgtgctaccatattacaccatattctaagtaaggtcagctaaataagctatcgggcccataccccgaaaatgttggttcatatccttcccgtactaataaacccactagtattctctacaatctcactaacagtagcactaggaacaaccatcgtattaatcagctcccactgattaatgatctggattgggtttgagataaacatactagccattgtccccatactaataaaaaaatttaatccccgatccatagaagcagcaacaaaatatttcctaacacaggccacagcctccatactacttatactagctatcatcattaacctaacctattctggccaatggactacaataaaaatacttagcccaatcgcctcaacaataataacaattgcactaatcataaaattaggaatggctccatttcacttctgagtccctgaagtaacccaaggagtacccctaatatcaggaataatcctactaacatgacaaaaaatcgctcctttatcagtacttatccaaatagcctattccctaaacacaaatctactcctcaccacagcaatcctatcaattgccgtaggaggatgaggaggactaaaccaaacacaactacgaaaaattatagcatattcatcaattgcacacataggctgaatagcagctatcctaacatataacacaacaataacctcattaaacctaattatctatattctactcacaattaccgtatttatactattacactttaactcatccacaactacactatcactatcacacctctgaaataaaataccaataatctcaacactaattttaactacaatactctcactcggaggcctcccacccctctcaggatttatccccaaatggataattattcacgaactcacaaagaacaacagcatcatcctaccaacagtcatagccatcatagccttactaaatttatatttctacatacgattaacctactccacatcactaacactatttccatcaacaaacaacatgaaaatgaaatgacaattcgaaaacaccaaaaacacaccaataacagccccccttattatcttctcaacaatacttctaccactcacacccatattagcactactggaataggagtttaggttaccatcagaccaagagccttcaaagctctaagcaagtataatttacttaactcctgccaaccataaggattgcaagactctatcctacatcaattgaatgcaaatcaatcactttaattaagctaaatccttactagattggtgggcttcaaccccacgaaattttagttaacagctaaataccctaatcaactggcttcaatctacatctctcccgcctcaaaaaaaaaaaagaggcgggagaggaagccctggcagagtttaaagctgctcctttgaatttgcaattcaacatgaaattcaccacaaggcttggtaaaaagaggactcaaacctctgtctttagatttacagtctaatgcttactcagccattttacctatgttcattaatcgttgattattttcaactaatcacaaagatatcggtacattgtacatgttatttggggcctgggcaggtatagtaggcacagccctgagcctactaattcgtgccgaactcggtcaacccggagcccttatgggcgatgaccagatctacaacgtcgttgtaactgcacatgcatttgtaataattttctttatagttatacccattttactaggcggctttggcaattgacttgttccacttataattggtgccccagacatagcatttccacgtatgaacaacataagcttctgactccttcccccatcatttctgttattactagcatcatctacagttgaagccggggcaggaacaggttgaactgtatatccacctttagccggaaacctggcacacgcaggagcttcagtagatttagcaatcttctctctccacttagcgggtgtatcatctattctaggtgctattaactttattacaacaattattaacataaaaccccctgcaatatcccaataccaaacaccacttttcgtttgatccgtattaattactgccgttctactattgctctctctgccagtcctagcagcaggcattaccatactcttaacagatcgaaatttaaacactactttcttcgacccagcaggcggaggggaccctattttataccaacatttattctgattctttggacacccagaagtctatatcctgatcttaccaggatttgggttaatttcacatatcgttacatactactcgggaaaaaaagaaccatttggttatataggaatagtgtgagcaataatgtcaattgggtttttaggctttattgtatgggcccatcacatatttacagtaggcctagacgttgacacacgtgcatactttacatctgctactataattattgctattcccactggagtaaaagtttttagctgattagcaactctgcacggaggaaatattaaatgatcacccgccatactatgagccctgggctttattttcttattcacagtaggaggcttaacaggaattgtcttagccaattcatccctagacatcgtattacatgacacatactatgtagtagcacactttcactatgtattatctataggggctgtatttgctattattggaggatttgtacattgattcccattattcactggatattcattaagtgaaacttgggccaaaattcacttcgctattatatttgttggagtcaatataacattctttccacaacactttttaggactctcaggcataccacgacgatattcagattatccagatgcctacaccacatgaaataccgtttcatctataggatcattcatctcactaacagcagtaatattaatagtattcataatttgagaagcatttgcatcaaaacgagaagtctccacagtagaattaacaacaactaatattgagtgacttcacggctgcccaccaccatatcacacattcgaagaaccaacttatgtaaattctaaataaataagaaaggaaggattcgaacccccaaagactggtttcaagccaaccccataaccactatgtctttctccattaatgagatattagtaaaattattacataactttgtcaaagttaaattataggttaaagccctttgtatctctatggcatacccatttcaatttggatttcaagatgcaacatcacctattatggaagaattattaaactttcatgatcacgcactaataattgccttcttaattagctcattagtcctttatattatttcacttatgctcacaactaaattaactcatacaagcacaatggatgcacaagaagtggaaactatttgaaccatcctacctgccattattttaattataattgctttaccatcactacgaattctatatataatggatgaaattaacaacccatccttaacagtaaaaacaatgggtcaccaatgatattgaagttatgagtatacggattatgaagacttaaccttcgactcatatatagtaccaaccactgatttaaagccaggggaattacgactattagaagttgataatcgagttgttttaccaatagaaataactattcgaatgcttatttcatctgaagacgttttacactcatgagccgtaccatcactagggttaaaaacagatgcaatcccaggacgactaaatcaaacaactttactatcaacccgacctggattatattacggacagtgctcagaaatctgtggctctaatcatagcttcatacctattgtcctcgaaatagttccactaaaatatttcgaaaaatgatcttcatctatgctataaagtcattaagaagctaaactagcattaaccttttaagttaaagaatgagagcccagacctctccttaatgaatatgccacaattagacacatctacatgatttattactattttagcaacaattattacattattcatagtatttcaactaaaaatttcaaaatttatttatccatcaaacccagaattaaaatctataaaatcgctaaaacataatactccttgagaaacaaaatgaacgaaaatctattcgcctctttcattacccctacaataataggattacctattgtcattctaatcatcatgttcccaactattttatttcctgagccaaatcgactaattaataatcgactaatctcaatacaacaatgactcattcaactaacttcaaaacaaataatatcaattcacaactctaaaggtcaaacctggactctaatattaatatctctcattctattcatcggatctactaatctcctaggtttacttccacactcatttaccccaaccactcaactatcaatgaacctaggcatagccattccactatgagcaggcacagttatcactggatttcgacataaaacgaaagcatcgctagcacatttcttaccacaaggaacccctattccactaattcctatattaattatcatcgaaactattagtctatttattcaacccatagccctagccgttcgactcaccgcaaacattaccgcagggcatttactaattcacctaattggaggtgccactttagctctaataaatattagtgtggctacagctatagtcaccttcattattttagtgctactaactattctggaattcgccgtagcacttattcaagcatacgtatttaccctattagttagcctatacctacatgacaacacctaatgacacaccaaacacatgcatatcacatagtaaatccaagcccatgaccactaacaggagccctatccgcactacttctaacatcaggacttgtaatatgattccactttaactcatcaacactactatgcctaggccttttagccaattctctaactatatatcaatgatgacgagacattgttcgtgaagggacatttcaaggtcaccacaccccaatcgtacaaaaaggacttcgatatggtataatcctctttatcatttcagaagtattcttctttgcaggctttttctgagccttttatcactcaagtcttgcaccaacccatgaactaggaggattttgaccaccagcaggaattcacccattaaacccattagaagtaccactactcaacacctcagtcctattagcttctggggtatcaatcacctgagcacatcacagtctaatagaaggtaaccgaaagcatataatccaagccctattcattaccatcgcactaggagtatatttcacaatcctacaagcagcagaatactatgaagccccattcactatctcagatggggtatatggatctactttcttcatagcaactggatttcatggcctacatgtaattattggcaccacattccttacagtctgcttcatccgtcaactaaaatatcatttcacatcaaaacaccattttggatttgaagccgctgcctgatattgacatttcgtagatgtagtatgactattcctctacgtctctatttactgatgaggatcatattcttctagtattaaaaagtactgctgacttccaatcagccagtctcagtaacaaacctgaggaagagtaattaatatactacttacaattatcattaatacactcctgtcatcaattcttgttttaattgcattctgacttccccaactaaatacatacgcagaaaaatcgagcccgtatgaatgcggatttgacccaataggatcagctcgacttccattctctataaaattttttctagtagcaattactttcctactatttgatttagaaattgcactccttttaccactcccatgagcctcacaaacaaatgatgtaaaaacagtactcacaatagcactaattctaatttccctattagcactaagtttggcatacgaatgaacacaaaaaggcctagaatgaacagaattggtaattagtttaaaaaaaaataaatgatttcgactcattagactgtggataaatccacaattatcaatatgtctttagtgtatgtaaacgtaataatcgcattcttaatttcattattaggcctgctgatataccgatcacacctaatatcctccctcctatgcctagaaggtataatattatccctatttatcttaggcaccattataattctcaatattcactttactctagcaagtataatcccaattatcctattagtgtttgcagcatgcgaggcagcgattggactttcccttttagtaatggtatcaaatacatatggggtagattatgtccaaaatctaaacctcctacaatgctaaaaattattattccaacaaccctacttcttccattaacttgactatcaaaaaataacataatttgaatcaacaccacactatacagcttattaatcagcttatcaagccttttataccttaatatacctaacgaaaataacttaagcttctctattatatttttttcagacccattgtccaccccattagtagtccttaccacatgacttctaccacttatacttatagccagccaatttcacctatccaatgagcacccaatccgaaaaaaaacctacatttctatactaatcttacttcaagtatttctaatcataacatttacatcaacagaattaatcctattttatattttatttgaagccaccctagtaccaactctaattctaattactcgttgaggaaaccaaacagaacgattaaacgcaggaatatatttcctattttatacactagtaggctcactgccattactagtcgcattaacctatttacaaaactcaacaggctcattaaatattacaattatacaactaatagcaaacccaataccaaacaaatggtcatcatcgctaatatgattggcgtgcatcatagcatttatagtaaaaataccactatacggactacatctatggttaccaaaagcccatgtagaagccccaatcgcagggtctatagtacttgcagccattttacttaaattaggaggatatggcataatacgtatttcaactatcttagcgccacacactaacactatagcctacccatttatagccctatcactatgaggaataattataacaagttcaatctgcttacgacagacagacctaaaatcattaattgcttactcctctgtaagtcacatggcactagttatcgtagctatcataatccaaacaccatgaagctatataggcgccacagccttaataatcgcccacggacttacatcatcaatattattctgcttagccaattctaattacgaacgaatccatagtcgaacaataatcttagcccgaggattacaaacactcctgccactaatagccgcatgatgactaatggcaagccttacaaatcttgccctacccccaacaattaacctgattggagaactattagtaatactcacaaccttttcatgatccaacatcacaatcttattaataggcttaaacatggttatcacagccctatactccctatacatattaatccaaactcaacgaggcaaacacactcaccacatcattaatatcaaaccttcatttacacgggaacatgctctaatagcattacacataacacctttactactcctatcaattaaccctaaaatcattttaggacccacattatgtaaatatagtttaacaaaaacattagattgtgaatctaaaaatagaagattgctacttcttatttaccgagaaagatatagcaagaactgctaattcatgcttccgtgtataaaaacacggctttctcacccacttttataggatagaagtaatccgttggtcttaggaaccaaaaatttggtgcaactccaaataaaagtaattaacatacttacatcttcattattattatcactaatcatccttataatccccattataataaccctaactaataagtataaagaagccaacttccccttatatgtaaaaaataccatcttctatgccttcataataagcataatcccagcacttatattcatctactcaggacaagaagcagtaatttcaaattgacattgaatgactatccactctataaaactaataatcagcctaaaactagattacttctccataatctttataccagtagcattattcgttacatggtccattatagaattctcaatatgatacatgcactcagaccccaacataaaccgcttctttaaatatctattaatgtttctaattacaataataattttagttacagcaaacaacctatttcaactctttattggctgagaaggcgtagggattatatcattccttttaattggctgatgatacgggcgaacggacgcaaacaccgcagcacttcaggcaatcttatataaccgtattggagatattggattcgtattatcaatagcatgatttctatttaactcaaactcatgagaactacagcaaatttttataaccgaatcaggacataatatgctcccattgctgggacttctactagccgccacaggaaaatctgctcaatttggccttcacccctgacttccatcagcaatggaaggcccaacccccgtatccgcactacttcactccagcacaatagtagtagcgggtgtatttctacttatccgattttatcccctaatcgaaaacaacacaacaattctaacactgaccctatgcctaggggcaataacaaccctattcacagctatctgtgccctcacacaaaatgatatcaaaaagatcgtagcattctcaacttcaagtcaactcgggttaataatagtaacaatcggaattaatcaaccacatctagcttttcttcacatctgcacccacgcatttttcaaagccatattatttatatgctctggctccattatccacaacctaaatgatgaacaggatattcgaaaaatagggggcctattcaaatctataccattcacaacatccgcactaatcacaggaagcctggcattaacaggaataccttaccttacaggattctactcaaaagacctaatcatcgaagcggttaacacgtcgtatacaaacgcctgagcccttttaatcactttaatcgcaacctccctaacagctgtctacagtactcgcattatatttttcgccctactaggacagccacgattctccacattaattttaatcaatgaaaataaccccctcctaataaatcctatcaaacgcctgttaataggaagtatttttgccggatttataatctcaaataatattttgcctatgactgttccccaaataaccataccactatacctaaaactaacagcactagcagttactattctaggatttctattagcactagagctaaacaacataacatattacttaaaattttccacacctaaccacagccataagttctcaaaccaattaggatatttcccaatcatcatacaccgactaatccctaagatcaacctaacaatgagccaaaaatctgcatcaatattactagacttagtctgaatagaaaatttcctacccaaaactgtttcatattgccaaataatggcctcaactctagtatcaaaccaaaaaggactaatcaaactatattttctatcattcataattacacttaccctaagcatattactatttaatttccacgggtaatttccattacaactaaaactccaatcactaaggatcaaccagtgacaataactaatcaagtaccataactgtataaagccgcaatacccatagcctcctcactaaaaaaaccagaatcaccagtatcataaattactcaatccccctgtccattaaaatttagcacaatttctaatttttcatcactaatacaatacccagcaaataaaagctccgccataaaacctaaaacaaacagactaagaactgttttattagacactcaaacttcaggatactcctccatagccatagctgtagtataaccaaaaactactaacatcccacccaaataaatcaaaaataccattaaacctaaaaacgaccccccataatttaatacaataccacatccaaccccaccactaacaattaaacccaatccaccataaataggagaaggttttgaagaaaaacccacaaaacttactactaaaatagtacttaaaataaaagcaatgtatgttatcattattcccacatggaatctaaccatgactaatgacatgaaaaatcatcgttgtaattcaactacaagaatactaatgacaaacctacgaaaaacccatcccctaataaaaattatcaataattcatttatcgatttaccagcaccctcaaatatttcatcatgatgaaacttcggttcactattaggaatctgcttaattctacaaattctaacaggtttattcttagcaatacattatacatcagacacaataacagcattttcatcagtaacccatatctgccgagacgttaattacggctgactgattcgatacttacacgccaacggagcatccatatttttcatctgcttattcctacacgtaggacgagggttatattatgggtcctatatatttatagagacatgaaatattggggtaattttactatttgctgtaatagccaccgcattcataggatacgttttaccatgaggccaaatatccttttgaggagcaacagtaattacaaacctactttctgctatcccctacatcggcaccgacctagtagaatgaatctgagggggtttttcagtagacaaagccaccctcactcgatttttcgccttccactttattctaccatttgtaattgccgccctagctggagtacacttattatttcttcacgaaacaggctccaataacccctccggacttacatcagactcagacaaaatcccatttcacccttactacacaattaaagatattttaggagtgctaattctgattctagtattatcctccctagtactattctcacccgacctcctaggagacccagacaactatatcccagcaaacccactaaatacccctccccatattaaaccagaatgatatttcctatttgcatacgcaattctacgatcaatcccaaataaattaggaggagtactagccctcgtattttcaatcctaatcctagccttaataccactattacacacttcaaaacaacgaagtataatattccgaccaatcagccaatgcttattctgactattagtagcagacctatttaccctcacatgaattggaggccaacctgtagaacacccatttattattattggccaattagcctctattttatactttatacttatcttagttttaataccaattgcaagcctggtagaaaacaacctacttaaatgaagagtctttgtagtataactattactctggtcttgtaaaccagaaatggagactatatctccccaagacattcaaggaagaagcactagccccaccaccaacacccaaagctggtattcttatctaaactattccttgggtcgccatctataagtctaagctttcccaacctaaatttcagtactaaattcaccccacttcacttcaattttctaaacatattttacaccaccccctatgtaattcgtgcattaatttatatccccccatgcatataagcaagtacatacaaatttaatgctttaccacatatcaaactaattaccttacattaacctgttaaccacatgaatatccacaaccacatgaaagcataattccacatagtacattctcctatatctctgacataaaccataaatagcaaaaccttgatattaaagtcatatggcctaagtccaccaatgatccggatatttcttaataaccaactcacgtgaaatcagcaacccttgtaaacaggactcattaacctcgctccgggcccattaaacttgggggtagctataaatgcactttaacagacatctggttctttcttcagggccatctcacctaaaaccgcccactctttccccttaaataagacatctcgatggattaattactaatcagcccatgctcacacataactgtggtgtcatacatttggtatttttttaattttggggatgctatgactcacctatggccgtaaaggcctcgaacagtcaattaacttgtagctgaacttaaattgaaatggaacctccccaaccactactaggtccatacttcagtcaatggtagcaggacataacagtttaacacccacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacgcacacgtacccacacgtgcacattctttaccaataaaatatcttttcaaacccccttacccccgttaagccaagaacgtgtaacaatacatcttgccaaaccccaaaaacaagaacagtcacacagttcataataaacttaacttaattttattaacttcccccacatctttctattgagaaacaccaaatcaacaagaatatctaatcaatacatcgctgcatcaacacaaaaaacccctactaattcctaaatacccccaaactatgaaattttaacagcacaaatattgaacaactagccaatagctactctagtgatactaatatcttgctaattccaatctcactccatagataccgggtacaaaatcataattggcatttttacaatt",
  "taxonomic_group": "Mammals"
}';


// Zootaxa, with reference details

$j='{
  "gi": "34304281",
  "accession": "AY214425",
  "title": "AY214425",
  "version": "AY214425.1",
  "created": "2003-08-28",
  "updated": "2003-08-28",
  "description": "Lamyctes inermipes cytochrome oxidase subunit I gene, partial cds; mitochondrial gene for mitochondrial product",
  "taxonomy": "Eukaryota; Metazoa; Arthropoda; Myriapoda; Chilopoda; Pleurostigmophora; Lithobiomorpha; Henicopidae; Henicopinae; Henicopini; Lamyctes",
  "references": [
    {
      "authors": [
        {
          "lastname": "Edgecombe",
          "forename": "G.D."
        },
        {
          "lastname": "Giribet",
          "forename": "G."
        }
      ],
      "atitle": "A new blind Lamyctes (Chilopoda: Lithobiomorpha) from Tasmania with an analysis of molecular sequence data for the Lamyctes-Henicops Group",
      "bibliographicCitation": "Zootaxa 152, 1-23 (2003)",
      "title": "Zootaxa",
      "volume": "152",
      "spage": "1",
      "epage": "23",
      "year": "2003",
      "issn": "0148-2076",
      "url": "http:\/\/www.mapress.com\/zootaxa\/2003f\/z00152f.pdf"
    },
    {
      "authors": [
        {
          "lastname": "Edgecombe",
          "forename": "G.D."
        },
        {
          "lastname": "Giribet",
          "forename": "G."
        }
      ],
      "atitle": "Direct Submission",
      "bibliographicCitation": "Submitted (06-JAN-2003) Organismic & Evolutionary Biology, Harvard University, 16 Divinity Ave., Cambridge, MA 02138, USA"
    }
  ],
  "source": {
    "organism": "Lamyctes inermipes",
    "organelle": "mitochondrion",
    "mol_type": "genomic DNA",
    "db_xref": "taxon:231405"
  },
  "features": [
    {
      "key": "CDS",
      "location": "<1..>657",
      "name": "cytochrome oxidase subunit I"
    }
  ],
  "sequence": "actatatacttaatttttggtgcttgggcttccataattgggacagccttaagtcttctaattcgtctagaacttagacaaccaggaagtttaattggtgacgaccaaatctataatgtaatcgttactgcccacgcttttgtgatgattttcttcatagtaatacctattataattggaggctttggtaactgattagtccctctaatattgggagcccctgatatagctttcccccgacttaataatataagtttctggttactccccccttcattcatactacttttaggctcagcggctgtggaaaacggagccggtactgggtggacagtatacccccccctagctgcaggtatgtcacacagaggtggatctgttgatataacgattttttctcttcacttagccggtatttcttctattttaggagcaattaattttatcacaacaatcattaatatacgaacaagaggtataatctttgaacgaatacccctattcgtatgggcagtcaaaatcaccgctattcttttattactttctctaccagtattagcaggtgctattactatactcttaactgaccgtaatttcaacactagtttctttgaccctgcgggcggaggagaccctattctgtaccaacatctattt"
}';


$j='{
  "gi": "91178885",
  "accession": "DQ282797",
  "title": "DQ282797",
  "version": "DQ282797.1",
  "created": "2006-04-11",
  "updated": "2006-06-02",
  "description": "Neobatrachus pictus voucher SAMA R50636 seventh in absentia gene, partial cds",
  "taxonomy": "Eukaryota; Metazoa; Chordata; Craniata; Vertebrata; Euteleostomi; Amphibia; Batrachia; Anura; Neobatrachia; Hyloidea; Myobatrachidae; Limnodynastinae; Neobatrachus",
  "references": [
    {
      "authors": [
        {
          "lastname": "Frost",
          "forename": "D.R."
        },
        {
          "lastname": "Grant",
          "forename": "T."
        },
        {
          "lastname": "Faivovich",
          "forename": "J."
        },
        {
          "lastname": "Bain",
          "forename": "R."
        },
        {
          "lastname": "Haas",
          "forename": "A."
        },
        {
          "lastname": "Haddad",
          "forename": "C.F.B."
        },
        {
          "lastname": "de Sa",
          "forename": "R.O."
        },
        {
          "lastname": "Channing",
          "forename": "A."
        },
        {
          "lastname": "Wilkinson",
          "forename": "M."
        },
        {
          "lastname": "Donnellan",
          "forename": "S.C."
        },
        {
          "lastname": "Raxworthy",
          "forename": "C."
        },
        {
          "lastname": "Campbell",
          "forename": "J.A."
        },
        {
          "lastname": "Blotto",
          "forename": "B.L."
        },
        {
          "lastname": "Moler",
          "forename": "P."
        },
        {
          "lastname": "Drewes",
          "forename": "R.C."
        },
        {
          "lastname": "Nussbaum",
          "forename": "R.A."
        },
        {
          "lastname": "Lynch",
          "forename": "J.D."
        },
        {
          "lastname": "Green",
          "forename": "D.M."
        },
        {
          "lastname": "Wheeler",
          "forename": "W.C."
        }
      ],
      "atitle": "The Amphibian Tree of Life",
      "bibliographicCitation": "Bull. Am. Mus. Nat. Hist. 297, 1-291 (2006)",
      "title": "Bull. Am. Mus. Nat. Hist.",
      "volume": "297",
      "spage": "1",
      "epage": "291",
      "year": "2006",
      "issn": "0148-2076",
      "doi": "10.1206\/0003-0090(2006)297[0001:TATOL]2.0.CO;2",
      "hdl": "2246\/5781"
    },
    {
      "authors": [
        {
          "lastname": "Frost",
          "forename": "D.R."
        },
        {
          "lastname": "Grant",
          "forename": "T."
        },
        {
          "lastname": "Faivovich",
          "forename": "J."
        },
        {
          "lastname": "Bain",
          "forename": "R."
        },
        {
          "lastname": "Haas",
          "forename": "A."
        },
        {
          "lastname": "Haddad",
          "forename": "C.F.B."
        },
        {
          "lastname": "de Sa",
          "forename": "R.O."
        },
        {
          "lastname": "Channing",
          "forename": "A."
        },
        {
          "lastname": "Wilkinson",
          "forename": "M."
        },
        {
          "lastname": "Donnellan",
          "forename": "S.C."
        },
        {
          "lastname": "Raxworthy",
          "forename": "C."
        },
        {
          "lastname": "Campbell",
          "forename": "J.A."
        },
        {
          "lastname": "Blotto",
          "forename": "B.L."
        },
        {
          "lastname": "Moler",
          "forename": "P."
        },
        {
          "lastname": "Drewes",
          "forename": "R.C."
        },
        {
          "lastname": "Nussbaum",
          "forename": "R.A."
        },
        {
          "lastname": "Lynch",
          "forename": "J.D."
        },
        {
          "lastname": "Green",
          "forename": "D.M."
        },
        {
          "lastname": "Wheeler",
          "forename": "W.C."
        }
      ],
      "atitle": "Direct Submission",
      "bibliographicCitation": "Submitted (26-OCT-2005) Herpetology, Division of Vertebrate Zoology, American Museum of Natural History, Central Park West at 79th Street, New York, NY 10024, USA"
    }
  ],
  "source": {
    "organism": "Neobatrachus pictus",
    "mol_type": "genomic DNA",
    "specimen_voucher": "SAMA R50636",
    "db_xref": "taxon:51249",
    "country": "Australia",
    "locality": "South Australia, 10 km S Robe",
    "specimen_code": "SAMA R50636"
  },
  "features": [
    {
      "key": "mRNA",
      "location": "<1..>397",
      "name": "seventh in absentia"
    },
    {
      "key": "CDS",
      "location": "<1..>397",
      "name": "seventh in absentia"
    }
  ],
  "sequence": "tgtcttaccacctattcttcagtgtcaaagtggacatcttgtgtgcagcaactgtcgcccaaaactcacatgttgcccaacctgcaggggccccttgggatccatccggaacttggcgatggaaaaagttgccaactctgtcctcttcccctgcaaaaatgcttcttccggttgcgaggtaacgttgccacacacggagaaggcagatcacgaggagctgtgtgagttccgaccgtactcctgtccttgcccaggagcttcttgtaaatggcaaggatccctggatgctgtaatgccacacctcatgcaccagcataaatccataactacattacaaggggaggatatagtgtttcttgctacagacataaaccttcctggggctgtagactgggtt",
  "taxonomic_group": "Amphibia"
}';

$j='{
  "gi": "90183634",
  "accession": "DQ283635",
  "title": "DQ283635",
  "version": "DQ283635.1",
  "created": "2006-03-23",
  "updated": "2006-03-23",
  "description": "Neobatrachus pictus 28S ribosomal RNA gene, partial sequence",
  "taxonomy": "Eukaryota; Metazoa; Chordata; Craniata; Vertebrata; Euteleostomi; Amphibia; Batrachia; Anura; Neobatrachia; Hyloidea; Myobatrachidae; Limnodynastinae; Neobatrachus",
  "references": [
    {
      "authors": [
        {
          "lastname": "Frost",
          "forename": "D.R."
        },
        {
          "lastname": "Grant",
          "forename": "T."
        },
        {
          "lastname": "Faivovich",
          "forename": "J."
        },
        {
          "lastname": "Bain",
          "forename": "R."
        },
        {
          "lastname": "Haas",
          "forename": "A."
        },
        {
          "lastname": "Haddad",
          "forename": "C.F.B."
        },
        {
          "lastname": "de Sa",
          "forename": "R.O."
        },
        {
          "lastname": "Channing",
          "forename": "A."
        },
        {
          "lastname": "Wilkinson",
          "forename": "M."
        },
        {
          "lastname": "Donnellan",
          "forename": "S.C."
        },
        {
          "lastname": "Raxworthy",
          "forename": "C."
        },
        {
          "lastname": "Campbell",
          "forename": "J.A."
        },
        {
          "lastname": "Blotto",
          "forename": "B.L."
        },
        {
          "lastname": "Moler",
          "forename": "P."
        },
        {
          "lastname": "Drewes",
          "forename": "R.C."
        },
        {
          "lastname": "Nussbaum",
          "forename": "R.A."
        },
        {
          "lastname": "Lynch",
          "forename": "J.D."
        },
        {
          "lastname": "Green",
          "forename": "D.M."
        },
        {
          "lastname": "Wheeler",
          "forename": "W.C."
        }
      ],
      "atitle": "The Amphibian Tree of Life",
      "bibliographicCitation": "Bull. Am. Mus. Nat. Hist. 297, 1-291 (2006)",
      "title": "Bull. Am. Mus. Nat. Hist.",
      "volume": "297",
      "spage": "1",
      "epage": "291",
      "year": "2006",
      "issn": "0148-2076",
      "doi": "10.1206\/0003-0090(2006)297[0001:TATOL]2.0.CO;2",
      "hdl": "2246\/5781"
    },
    {
      "authors": [
        {
          "lastname": "Frost",
          "forename": "D.R."
        },
        {
          "lastname": "Grant",
          "forename": "T."
        },
        {
          "lastname": "Faivovich",
          "forename": "J."
        },
        {
          "lastname": "Bain",
          "forename": "R."
        },
        {
          "lastname": "Haas",
          "forename": "A."
        },
        {
          "lastname": "Haddad",
          "forename": "C.F.B."
        },
        {
          "lastname": "de Sa",
          "forename": "R.O."
        },
        {
          "lastname": "Channing",
          "forename": "A."
        },
        {
          "lastname": "Wilkinson",
          "forename": "M."
        },
        {
          "lastname": "Donnellan",
          "forename": "S.C."
        },
        {
          "lastname": "Raxworthy",
          "forename": "C."
        },
        {
          "lastname": "Campbell",
          "forename": "J.A."
        },
        {
          "lastname": "Blotto",
          "forename": "B.L."
        },
        {
          "lastname": "Moler",
          "forename": "P."
        },
        {
          "lastname": "Drewes",
          "forename": "R.C."
        },
        {
          "lastname": "Nussbaum",
          "forename": "R.A."
        },
        {
          "lastname": "Lynch",
          "forename": "J.D."
        },
        {
          "lastname": "Green",
          "forename": "D.M."
        },
        {
          "lastname": "Wheeler",
          "forename": "W.C."
        }
      ],
      "atitle": "Direct Submission",
      "bibliographicCitation": "Submitted (26-OCT-2005) Herpetology, Division of Vertebrate Zoology, American Museum of Natural History, Central Park West at 79th Street, New York, NY 10024, USA"
    }
  ],
  "source": {
    "organism": "Neobatrachus pictus",
    "mol_type": "genomic DNA",
    "specimen_voucher": "SAMA R50636",
    "db_xref": "taxon:51249",
    "country": "Australia",
    "locality": "South Australia, 10 km S Robe",
    "specimen_code": "SAMA R50636"
  },
  "features": [
    {
      "key": "rRNA",
      "location": "<1..>721",
      "name": "28S ribosomal RNA"
    }
  ],
  "sequence": "atctaattagtgacgcgcatgaatggatgaacgagattcccactgtccctacctactatctagcgaaaccacagccaagggaacgggcttggcggaatcagcggggaaagaagaccctgttgagcttgactctagtctgcaactgtgaagagacatgaggggtgtaggataagtgggaggccccccgccgttcgcgcggcgggggaaccgccggtgaaataccactacccttatcgttttttcacttacccggtgaggcgggagggcgagccccacagcgggctctcgcttctggcgccaagccccggcccccccgcgggccgcgggcgacccgctccgaggacagtggcaggtggggagtttgactggggcggtacacctgtcaaaccgtaacgcaggtgtcctaaggcgagctcagggaggacagaaacctcccgtggagcagaagggcaaaagctcgcttgatcttgattttcagtatgaatacagaccgtgaaagcggggcctcacgatccttctgacttttttgggttttaagcaggaggtgtcagaaaagttaccacagggataactggcttgtggcggccaagcgttcatagcgacgtcgctttttgatccttcgatgtcggctcttcctatcattgtgaagcagaattcaccaagcgttggattgttcacccactaatagggaacgtgagctgggtttagaccgtcgtgagac",
  "taxonomic_group": "Amphibia"
}';

$j='{
  "gi": "110811508",
  "accession": "DQ503406",
  "title": "DQ503406",
  "version": "DQ503406.1",
  "created": "2006-08-23",
  "updated": "2006-08-23",
  "description": "Colostethus saltuensis voucher MUJ 3726 recombination activating protein 1 (RAG1) gene, partial cds",
  "taxonomy": "Eukaryota; Metazoa; Chordata; Craniata; Vertebrata; Euteleostomi; Amphibia; Batrachia; Anura; Neobatrachia; Hyloidea; Aromobatidae; Aromobatinae; Aromobates",
  "references": [
    {
      "authors": [
        {
          "lastname": "Grant",
          "forename": "T."
        },
        {
          "lastname": "Frost",
          "forename": "D.R."
        },
        {
          "lastname": "Caldwell",
          "forename": "J.P."
        },
        {
          "lastname": "Gagliardo",
          "forename": "R."
        },
        {
          "lastname": "Haddad",
          "forename": "C.F.B."
        },
        {
          "lastname": "Kok",
          "forename": "P.J.R."
        },
        {
          "lastname": "Means",
          "forename": "D.B."
        },
        {
          "lastname": "Noonan",
          "forename": "B.P."
        },
        {
          "lastname": "Schargel",
          "forename": "W.E."
        },
        {
          "lastname": "Wheeler",
          "forename": "W.C."
        }
      ],
      "atitle": "Phylogenetic Systematics of Dart-Poison Frogs and their Relatives (Amphibia: Athesphatanura: Dendrobatidae)",
      "bibliographicCitation": "Bull. Am. Mus. Nat. Hist. 299, 1-261 (2006)",
      "title": "Bull. Am. Mus. Nat. Hist.",
      "volume": "299",
      "spage": "1",
      "epage": "261",
      "year": "2006",
      "issn": "0003-0090",
      "doi": "10.1206\/0003-0090(2006)299[1:PSODFA]2.0.CO;2",
      "hdl": "2246\/5803"
    },
    {
      "authors": [
        {
          "lastname": "Grant",
          "forename": "T."
        }
      ],
      "atitle": "Direct Submission",
      "bibliographicCitation": "Submitted (19-APR-2006) American Museum of Natural History, Central Park West at 79th Street, New York, NY 10024, USA"
    }
  ],
  "source": {
    "organism": "Aromobates saltuensis",
    "mol_type": "genomic DNA",
    "specimen_voucher": "MUJ 3726",
    "db_xref": "taxon:384873",
    "country": "Colombia",
    "locality": "Boyaca, Cubara, Fatima, Quebrada Gralanday, 1560 m"
  },
  "features": [
    {
      "key": "gene",
      "location": "<1..>435",
      "name": "RAG1"
    },
    {
      "key": "mRNA",
      "location": "<1..>435",
      "name": "recombination activating protein 1"
    },
    {
      "key": "CDS",
      "location": "<1..>435",
      "name": "recombination activating protein 1"
    }
  ],
  "sequence": "caaacatgccaaagccaccaacgaagaacgaaagaaatggcaggcgacgcttgacaaacatcttaggaagaagatgaacctaaagcctattatgagaatgaatggaaattttgctcgaaaactcatgagccaggaaaccgttgaggctgtttgtgagctgatacattccgaagagcggcaagtggccctcaaagaacttatggacttgtatctcaaaatgaaaccggtatggcgcacttcatgcccagctaaagagtgcccagaattactctgccaatacagctaccactctcagagatttgcagaactcttgtccaccaagttcaagtatcgatatgaaggcaggatcaccaattacttccataagaccctggcccatgtcccagagatcattgaacgtgacggttctatcggagcttgggccagtgaaggcaa",
  "taxonomic_group": "Amphibia"
}';

$j='{
  "gi": "55466920",
  "accession": "AJ844919",
  "title": "AJ844919",
  "version": "AJ844919.1",
  "created": "2004-11-05",
  "updated": "2004-11-05",
  "description": "Stomatepia mongo mitochondrial partial cytb gene for cytochrome b and partial tRNA-Pro gene, specimen voucher CAM01 182",
  "taxonomy": "Eukaryota; Metazoa; Chordata; Craniata; Vertebrata; Euteleostomi; Actinopterygii; Neopterygii; Teleostei; Euteleostei; Neoteleostei; Acanthomorpha; Acanthopterygii; Percomorpha; Perciformes; Labroidei; Cichlidae; African cichlids; Pseudocrenilabrinae; Tilapiini; Stomatepia",
  "references": [
    {
      "authors": [
        {
          "lastname": "Schliewen",
          "forename": "U.K."
        },
        {
          "lastname": "Klee",
          "forename": "B."
        }
      ],
      "atitle": "Reticulate sympatric speciation in Cameroonian crater lake cichlids",
      "bibliographicCitation": "Unpublished"
    },
    {
      "authors": [
        {
          "lastname": "Schliewen",
          "forename": "U.K."
        }
      ],
      "atitle": "Direct Submission",
      "bibliographicCitation": "Submitted (05-OCT-2004) Schliewen U.K., Ichthyology, Zoologische Staatssammlung Muenchen, Muenchhausenstr. 21, Munich, D-81247, GERMANY"
    }
  ],
  "source": {
    "organism": "Stomatepia mongo",
    "organelle": "mitochondrion",
    "mol_type": "genomic DNA",
    "specimen_voucher": "CAM01 182",
    "db_xref": "taxon:296559",
    "tissue_type": "fin",
    "country": "Cameroon",
    "locality": "Lake Barombi Mbo"
  },
  "features": [
    {
      "key": "gene",
      "location": "1..1141",
      "name": "cytb"
    },
    {
      "key": "CDS",
      "location": "1..1141",
      "name": "cytochrome b"
    },
    {
      "key": "gene",
      "location": "1142..>1212",
      "name": "tRNA-Pro"
    },
    {
      "key": "tRNA",
      "location": "1142..>1212",
      "name": "tRNA-Pro"
    }
  ],
  "sequence": "atggccaacctccgaaaaacccaccccctcctaaaaatcgcaaacgacgctctagttgacctcccagctccctcaaacatctccgtctgatggaattttggatctctactaggactctgcctagcagcccaaatcctaacaggcctctttctagccatacactatacctccgacatcgccacagccttctcctccgtcgcccacatttgtcgagacgtaaactatggctgactcattcgaaacatacacgccaatggcgcatcctttttcttcatttgtatttacctccacatcgggcgaggcctatactacggctcctatctgtacaaagaaacctgaaatattggagttatcctcctcctcctaaccataataacagccttcgtaggctacgtcctcccatgaggacaaatgtcattctgaggcgctaccgtcatcacaaaccttctttccgcagtcccttacattggcaactccttagttcaatgaatttgagggggattctccgtagacaacgccaccctaactcgctttttcgctttccacttccttctccccttcatcattgcagctgcaacaatagtacaccttatttttctccacgaaaccggatcaaacaaccccacaggcctaaactcagacgccgacaaaatctccttccacccctacttttcttacaaagacttattaggcttcgcaattcttttaatcgccctcatttccctggcccttttctcccccaacctactcggtgaccctgacaattttacccccgcaaaccccctagttactcctccccacatcaaacccgaatgatacttcctgtttgcctacgccatcctacgctcaattcctaacaaacttggcggagttctcgccctcctattctcaattcttgttttaatagttgtgcctatcctccacacctccaaacaacgaggcctaactttccgccccatcacacaattcttgttttgactcctagttgcagatgtcgcaatcctcacctgaattgggggcatgcccgttgaacaccccttcgttattattggccaaatcgcatcttttctctacttcttcctcttccttattcttgcccccattaccggctgactagaaaacaaaatccttgaatgacactgcactagtagctcagcgccagagcaccggtcttgtaaaccggacgtcgaaggttaaaatccttcctactgc"
}';

$j='{
  "gi": "9844832",
  "accession": "AF128501",
  "title": "AF128501",
  "version": "AF128501.1",
  "created": "2000-08-18",
  "updated": "2000-12-15",
  "description": "Japalura splendida CAS194476 NADH dehydrogenase subunit 1 (ND1) gene, partial cds; tRNA-Gln, tRNA-Ile, and tRNA-Met genes, complete sequence; NADH dehydrogenase subunit 2 (ND2) gene, complete cds; tRNA-Trp, tRNA-Ala, tRNA-Asn, tRNA-Cys, and tRNA-Tyr genes, complete sequence; and cytochrome c oxidase subunit I (COI) gene, partial cds; mitochondrial genes for mitochondrial products",
  "taxonomy": "Eukaryota; Metazoa; Chordata; Craniata; Vertebrata; Euteleostomi; Lepidosauria; Squamata; Iguania; Acrodonta; Agamidae; Draconinae; Japalura",
  "references": [
    {
      "authors": [
        {
          "lastname": "Macey",
          "forename": "J.R."
        },
        {
          "lastname": "Schulte",
          "forename": "J.A. II"
        },
        {
          "lastname": "Larson",
          "forename": "A."
        },
        {
          "lastname": "Ananjeva",
          "forename": "N.B."
        },
        {
          "lastname": "Wang",
          "forename": "Y."
        },
        {
          "lastname": "Pethiyagoda",
          "forename": "R."
        },
        {
          "lastname": "Rastegar-Pouyani",
          "forename": "N."
        },
        {
          "lastname": "Papenfuss",
          "forename": "T.J."
        }
      ],
      "atitle": "Evaluating trans-tethys migration: an example using acrodont lizard phylogenetics",
      "bibliographicCitation": "Syst. Biol. 49 (2), 233-256 (2000)",
      "pmid": "12118407",
      "doi": "10.1080\/10635159950173834"
    },
    {
      "authors": [
        {
          "lastname": "Macey",
          "forename": "J.R."
        },
        {
          "lastname": "Schulte",
          "forename": "J.A. II"
        },
        {
          "lastname": "Larson",
          "forename": "A."
        }
      ],
      "atitle": "Evolution and phylogenetic information content of mitochondrial genomic structural features illustrated with acrodont lizards",
      "bibliographicCitation": "Syst. Biol. 49 (2), 257-277 (2000)",
      "pmid": "12118408",
      "doi": "10.1080\/10635159950173843"
    },
    {
      "authors": [
        {
          "lastname": "Macey",
          "forename": "J.R."
        },
        {
          "lastname": "Schulte",
          "forename": "J.A. II"
        },
        {
          "lastname": "Larson",
          "forename": "A."
        },
        {
          "lastname": "Ananjeva",
          "forename": "N.B."
        },
        {
          "lastname": "Wang",
          "forename": "Y."
        },
        {
          "lastname": "Pethiyagoda",
          "forename": "R."
        },
        {
          "lastname": "Rastegar-Pouyani",
          "forename": "N."
        },
        {
          "lastname": "Papenfuss",
          "forename": "T.J."
        }
      ],
      "atitle": "Direct Submission",
      "bibliographicCitation": "Submitted (16-FEB-1999) Biology, Washington University, Box 1137, St. Louis, MO 63130-4899, USA"
    }
  ],
  "source": {
    "organism": "Japalura splendida",
    "organelle": "mitochondrion",
    "mol_type": "genomic DNA",
    "specimen_voucher": "CAS194476; California Academy of Sciences, San Francisco",
    "db_xref": "taxon:118209",
    "country": "China",
    "locality": "Sichuan Prov., Ya\'an Prefecture, 4.3 km NNE of Caluo, on the Hanyuan to Xichang Rd., (29deg. 12N, 102deg. 21E)",
    "specimen_code": "CAS 194476"
  },
  "features": [
    {
      "key": "gene",
      "location": "<1..90",
      "name": "ND1"
    },
    {
      "key": "CDS",
      "location": "<1..90",
      "name": "NADH dehydrogenase subunit 1"
    },
    {
      "key": "tRNA",
      "location": "72..158",
      "name": "tRNA-Gln"
    },
    {
      "key": "tRNA",
      "location": "163..231",
      "name": "tRNA-Ile"
    },
    {
      "key": "tRNA",
      "location": "231..297",
      "name": "tRNA-Met"
    },
    {
      "key": "gene",
      "location": "296..1325",
      "name": "ND2"
    },
    {
      "key": "CDS",
      "location": "297..1325",
      "name": "NADH dehydrogenase subunit 2"
    },
    {
      "key": "tRNA",
      "location": "1336..1343",
      "name": "tRNA-Trp"
    },
    {
      "key": "tRNA",
      "location": "1401..1467",
      "name": "tRNA-Ala"
    },
    {
      "key": "tRNA",
      "location": "1477..1548",
      "name": "tRNA-Asn"
    },
    {
      "key": "tRNA",
      "location": "1570..1622",
      "name": "tRNA-Cys"
    },
    {
      "key": "tRNA",
      "location": "1622..1685",
      "name": "tRNA-Tyr"
    },
    {
      "key": "gene",
      "location": "1686..>1718",
      "name": "COI"
    },
    {
      "key": "CDS",
      "location": "1686..>1718",
      "name": "cytochrome c oxidase subunit I"
    }
  ],
  "sequence": "caattcctaccactaaccctggccatatgcctcctctttaccacactcccactatcaatatccgccattccaccaaacaactacacctaggaagaaaggacttgaacctccatctaagagtccaaaactcttcgtatgcccaataatactacaccctataaagaaatgtgcccgagacataaggactattttgataaaatagacacagagcctgccaacctctcatttctgttagggtctgctacacaaagcaattgggcccataccccaaaaacggtaaaatataccccctgacaatacaaattacagccacaaccgcaatcttcatagggcttaccataagtagtacttttgttataataagcaacaactgactactggcctgactaaacctagaaataaacatactagccattctaccagtaatctcaaaaacaaaacacccacgagcaatcgaagcctcaacaaagtactttctaacacagactattgcctcctgcctattactattttcctgcaccactaatgcctgatatataggcacttgaagtattacccaaatagacaacacatacacgtcaaccctcgtactactcgccctcacgataaaagccggcacagtcccaacacacttctgactgccagaagtaatacaggggagtacactcaccaccaccatactaatgtcaacctgacaaaaaatagccccaatagccctaatttactccgtatcaaatcatacctcaccaaacattacactaatacttggcctactgtcaacagccttcggcggatgaggaggaataaaccagacacagctacgaaagataatagcctattcatcaatcacgaacatgggctgaacagtaataatcctatccctacagccaaaagcgtcaataattagcatctttacatacatcatcacaattatcccaacaatcctaataatagagctcacttcaacaaaaacactacaaaatatgacaacctcctgatcaacatctcctatcaccaccaccatactagcacttctcctcctatcaacagccggcctaccacctcttacagggtttattccaaaattactaatcttaaatgaactagtaacccaaaacctcacacccatagctatggctgcagctacagcttcactactaagtctaatcttttatttacgcatagcctacctaacagccctactaaactctcctggctctgccacatcaacaatgaaatgacgacaaaaaattgaaaccaaaacaacaatcctaacaccaacatccttgacaaccataacaatactccccgcaatagccaaataggaacttaggaataaccattaaaccagagaccttcaaagtcacaaataagagtcaccaccctcttagtacctgcaataaagactgcgagaccacctcgcatcacctgaatgcaactcagacactttaattaagctaagaccttacacaagctacggatcagcgggcctcgatcccacaaaaaacagttaacagctggccacccaatccagagggcattaatccggctactctctttaaaaagagtaggcccaggaacgaattcctctccaaatttgcaatttgggtttttgctgggccgaactggggggcgacgccccataaaggggtttacagccccccgcctaagtcagccacctgtccatgtcctctttaacccgatgattactatcaact",
  "taxonomic_group": "Reptiles"
}';

$j='{
  "gi": "9844832",
  "accession": "AF128501",
  "title": "AF128501",
  "version": "AF128501.1",
  "created": "2000-08-18",
  "updated": "2000-12-15",
  "description": "Japalura splendida CAS194476 NADH dehydrogenase subunit 1 (ND1) gene, partial cds; tRNA-Gln, tRNA-Ile, and tRNA-Met genes, complete sequence; NADH dehydrogenase subunit 2 (ND2) gene, complete cds; tRNA-Trp, tRNA-Ala, tRNA-Asn, tRNA-Cys, and tRNA-Tyr genes, complete sequence; and cytochrome c oxidase subunit I (COI) gene, partial cds; mitochondrial genes for mitochondrial products",
  "taxonomy": "Eukaryota; Metazoa; Chordata; Craniata; Vertebrata; Euteleostomi; Lepidosauria; Squamata; Iguania; Acrodonta; Agamidae; Draconinae; Japalura",
  "references": [
    {
      "authors": [
        {
          "lastname": "Macey",
          "forename": "J.R."
        },
        {
          "lastname": "Schulte",
          "forename": "J.A. II"
        },
        {
          "lastname": "Larson",
          "forename": "A."
        },
        {
          "lastname": "Ananjeva",
          "forename": "N.B."
        },
        {
          "lastname": "Wang",
          "forename": "Y."
        },
        {
          "lastname": "Pethiyagoda",
          "forename": "R."
        },
        {
          "lastname": "Rastegar-Pouyani",
          "forename": "N."
        },
        {
          "lastname": "Papenfuss",
          "forename": "T.J."
        }
      ],
      "atitle": "Evaluating trans-tethys migration: an example using acrodont lizard phylogenetics",
      "bibliographicCitation": "Syst. Biol. 49 (2), 233-256 (2000)",
      "pmid": "12118407",
      "doi": "10.1080\/10635159950173834"
    },
    {
      "authors": [
        {
          "lastname": "Macey",
          "forename": "J.R."
        },
        {
          "lastname": "Schulte",
          "forename": "J.A. II"
        },
        {
          "lastname": "Larson",
          "forename": "A."
        }
      ],
      "atitle": "Evolution and phylogenetic information content of mitochondrial genomic structural features illustrated with acrodont lizards",
      "bibliographicCitation": "Syst. Biol. 49 (2), 257-277 (2000)",
      "pmid": "12118408",
      "doi": "10.1080\/10635159950173843"
    },
    {
      "authors": [
        {
          "lastname": "Macey",
          "forename": "J.R."
        },
        {
          "lastname": "Schulte",
          "forename": "J.A. II"
        },
        {
          "lastname": "Larson",
          "forename": "A."
        },
        {
          "lastname": "Ananjeva",
          "forename": "N.B."
        },
        {
          "lastname": "Wang",
          "forename": "Y."
        },
        {
          "lastname": "Pethiyagoda",
          "forename": "R."
        },
        {
          "lastname": "Rastegar-Pouyani",
          "forename": "N."
        },
        {
          "lastname": "Papenfuss",
          "forename": "T.J."
        }
      ],
      "atitle": "Direct Submission",
      "bibliographicCitation": "Submitted (16-FEB-1999) Biology, Washington University, Box 1137, St. Louis, MO 63130-4899, USA"
    }
  ],
  "source": {
    "organism": "Japalura splendida",
    "organelle": "mitochondrion",
    "mol_type": "genomic DNA",
    "specimen_voucher": "CAS194476; California Academy of Sciences, San Francisco",
    "db_xref": "taxon:118209",
    "country": "China",
    "locality": "Sichuan Prov., Ya\'an Prefecture, 4.3 km NNE of Caluo, on the Hanyuan to Xichang Rd., (29deg. 12N, 102deg. 21E)",
    "specimen_code": "CAS 194476",
    "specimen": {
      "title": "CAS 194476",
      "guid": "CAS::194476",
      "institutionCode": "CAS",
      "collectionCode": "Herps",
      "catalogNumber": "194476",
      "organism": "Japalura splendida",
      "kingdom": "Animalia",
      "phylum": "Chordata",
      "class": "Reptilia",
      "order": "Sauria",
      "family": "Agamidae",
      "genus": "Japalura",
      "species": "splendida",
      "country": "China",
      "stateProvince": "Sichuan Prov.",
      "county": "Ya\'an Pref.",
      "continentOcean": "Asia",
      "locality": "4.3 km NNE of Caluo (Chaluo) [29 12 N 102 21 E], on the Hanyuan to Xichang Rd., Ya\'an Prefecture, Sichuan Province, China",
      "dateLastModified": "2008-04-22T14:47:00",
      "verbatimCollectingDate": "30 Jul 1992",
      "collector": "R. Macey and T.J. Papenfuss",
      "collectorNumber": "RM-9950",
      "dateCollected": "1992-07-30",
      "dateModified": "2008-04-22",
      "namebankID": [
        "2540649"
      ],
      "bci": "urn:lsid:biocol.org:col:34699"
    }
  },
  "features": [
    {
      "key": "gene",
      "location": "<1..90",
      "name": "ND1"
    },
    {
      "key": "CDS",
      "location": "<1..90",
      "name": "NADH dehydrogenase subunit 1"
    },
    {
      "key": "tRNA",
      "location": "72..158",
      "name": "tRNA-Gln"
    },
    {
      "key": "tRNA",
      "location": "163..231",
      "name": "tRNA-Ile"
    },
    {
      "key": "tRNA",
      "location": "231..297",
      "name": "tRNA-Met"
    },
    {
      "key": "gene",
      "location": "296..1325",
      "name": "ND2"
    },
    {
      "key": "CDS",
      "location": "297..1325",
      "name": "NADH dehydrogenase subunit 2"
    },
    {
      "key": "tRNA",
      "location": "1336..1343",
      "name": "tRNA-Trp"
    },
    {
      "key": "tRNA",
      "location": "1401..1467",
      "name": "tRNA-Ala"
    },
    {
      "key": "tRNA",
      "location": "1477..1548",
      "name": "tRNA-Asn"
    },
    {
      "key": "tRNA",
      "location": "1570..1622",
      "name": "tRNA-Cys"
    },
    {
      "key": "tRNA",
      "location": "1622..1685",
      "name": "tRNA-Tyr"
    },
    {
      "key": "gene",
      "location": "1686..>1718",
      "name": "COI"
    },
    {
      "key": "CDS",
      "location": "1686..>1718",
      "name": "cytochrome c oxidase subunit I"
    }
  ],
  "sequence": "caattcctaccactaaccctggccatatgcctcctctttaccacactcccactatcaatatccgccattccaccaaacaactacacctaggaagaaaggacttgaacctccatctaagagtccaaaactcttcgtatgcccaataatactacaccctataaagaaatgtgcccgagacataaggactattttgataaaatagacacagagcctgccaacctctcatttctgttagggtctgctacacaaagcaattgggcccataccccaaaaacggtaaaatataccccctgacaatacaaattacagccacaaccgcaatcttcatagggcttaccataagtagtacttttgttataataagcaacaactgactactggcctgactaaacctagaaataaacatactagccattctaccagtaatctcaaaaacaaaacacccacgagcaatcgaagcctcaacaaagtactttctaacacagactattgcctcctgcctattactattttcctgcaccactaatgcctgatatataggcacttgaagtattacccaaatagacaacacatacacgtcaaccctcgtactactcgccctcacgataaaagccggcacagtcccaacacacttctgactgccagaagtaatacaggggagtacactcaccaccaccatactaatgtcaacctgacaaaaaatagccccaatagccctaatttactccgtatcaaatcatacctcaccaaacattacactaatacttggcctactgtcaacagccttcggcggatgaggaggaataaaccagacacagctacgaaagataatagcctattcatcaatcacgaacatgggctgaacagtaataatcctatccctacagccaaaagcgtcaataattagcatctttacatacatcatcacaattatcccaacaatcctaataatagagctcacttcaacaaaaacactacaaaatatgacaacctcctgatcaacatctcctatcaccaccaccatactagcacttctcctcctatcaacagccggcctaccacctcttacagggtttattccaaaattactaatcttaaatgaactagtaacccaaaacctcacacccatagctatggctgcagctacagcttcactactaagtctaatcttttatttacgcatagcctacctaacagccctactaaactctcctggctctgccacatcaacaatgaaatgacgacaaaaaattgaaaccaaaacaacaatcctaacaccaacatccttgacaaccataacaatactccccgcaatagccaaataggaacttaggaataaccattaaaccagagaccttcaaagtcacaaataagagtcaccaccctcttagtacctgcaataaagactgcgagaccacctcgcatcacctgaatgcaactcagacactttaattaagctaagaccttacacaagctacggatcagcgggcctcgatcccacaaaaaacagttaacagctggccacccaatccagagggcattaatccggctactctctttaaaaagagtaggcccaggaacgaattcctctccaaatttgcaatttgggtttttgctgggccgaactggggggcgacgccccataaaggggtttacagccccccgcctaagtcagccacctgtccatgtcctctttaacccgatgattactatcaact",
  "taxonomic_group": "Reptiles"
}';

$j='{
  "gi": "33242678",
  "accession": "AY269304",
  "title": "AY269304",
  "version": "AY269304.1",
  "created": "2003-09-16",
  "updated": "2003-09-16",
  "description": "Eleutherodactylus stejnegerianus haplotype a specimen-voucher FMNH 257780 cellular myelocytomatosis (c-myc) gene, exon 2 and partial cds",
  "taxonomy": "Eukaryota; Metazoa; Chordata; Craniata; Vertebrata; Euteleostomi; Amphibia; Batrachia; Anura; Neobatrachia; Hyloidea; Leptodactylidae; Eleutherodactylinae; Craugastor",
  "references": [
    {
      "authors": [
        {
          "lastname": "Crawford",
          "forename": "A.J."
        }
      ],
      "atitle": "Huge populations and old species of Costa Rican and Panamanian dirt frogs inferred from mitochondrial and nuclear gene sequences",
      "bibliographicCitation": "Mol. Ecol. 12 (10), 2525-2540 (2003)",
      "pmid": "12969459",
      "doi": "10.1046\/j.1365-294X.2003.01910.x"
    },
    {
      "authors": [
        {
          "lastname": "Crawford",
          "forename": "A.J."
        }
      ],
      "atitle": "Direct Submission",
      "bibliographicCitation": "Submitted (07-APR-2003) Committee on Evolutionary Biology, University of Chicago, 1025 E. 57th Street, Culver Hall 402, Chicago, IL 60637, USA"
    }
  ],
  "source": {
    "organism": "Craugastor stejnegerianus",
    "mol_type": "genomic DNA",
    "specimen_voucher": "FMNH 257780",
    "db_xref": "taxon:228449",
    "haplotype": "a",
    "country": "Costa Rica",
    "specimen_code": "FMNH 257780",
    "specimen": {
      "title": "FMNH 257780",
      "guid": "FMNH:Herps:257780",
      "institutionCode": "FMNH",
      "collectionCode": "Herps",
      "catalogNumber": "257780",
      "organism": "Eleutherodactylus stejnegerianus",
      "kingdom": "Animalia",
      "phylum": "Chordata",
      "class": "Amphibia",
      "order": "Anura",
      "family": "Leptodactylidae",
      "genus": "Eleutherodactylus",
      "species": "stejnegerianus",
      "country": "Costa Rica",
      "stateProvince": "Puntarenas",
      "county": "Coto Brus",
      "dateLastModified": "2004-11-17",
      "verbatimCollectingDate": "24 Feb 1998",
      "collector": "Andrew J Crawford",
      "fieldNumber": "AJC 0138",
      "dateCollected": "1998-02-24",
      "dateModified": "2004-11-17",
      "namebankID": [
        "2476187"
      ],
      "bci": "urn:lsid:biocol.org:col:34706"
    }
  },
  "features": [
    {
      "key": "gene",
      "location": "<1..>351",
      "name": "c-myc"
    },
    {
      "key": "mRNA",
      "location": "<1..>57",
      "name": "cellular myelocytomatosis"
    },
    {
      "key": "CDS",
      "location": "<1..>57",
      "name": "cellular myelocytomatosis"
    }
  ],
  "sequence": "aggagctcaatatggaaacaccacccatcagcagcaacggatgcagctctgaatctggtaagtacatgtcttcagcattggctttgcatacaactgctgcattgccgtgggtggggggtagttctcgattatgtagacattggggatagtcaatgttggtgttgagggaggggttcctgtagtgcatatgtgcttggatatctcagcctgatctttcacagctgttggaagttgtcgctttgtagatctgcagcactgcagtggtgggtggggtctctgtgaaagtggcttgggcaatgaatgatagtttagggcagcgacgcaacacgctttctaagaatgctaaggaca",
  "taxonomic_group": "Amphibia"
}';

$j='{
  "gi": "16326360",
  "accession": "AF284599",
  "title": "AF284599",
  "version": "AF284599.1",
  "created": "2001-10-23",
  "updated": "2008-10-15",
  "description": "Pleistodontes sp. \'Raunsepna\' internal transcribed spacer 2, complete sequence",
  "taxonomy": "Eukaryota; Metazoa; Arthropoda; Hexapoda; Insecta; Pterygota; Neoptera; Endopterygota; Hymenoptera; Apocrita; Chalcidoidea; Agaonidae; Agaoninae; Pleistodontes",
  "references": [
    {
      "authors": [
        {
          "lastname": "Lopez-Vaamonde",
          "forename": "C."
        },
        {
          "lastname": "Rasplus",
          "forename": "J.Y."
        },
        {
          "lastname": "Weiblen",
          "forename": "G.D."
        },
        {
          "lastname": "Cook",
          "forename": "J.M."
        }
      ],
      "atitle": "Molecular phylogenies of fig wasps: partial cocladogenesis of pollinators and parasites",
      "bibliographicCitation": "Mol. Phylogenet. Evol. 21 (1), 55-71 (2001)",
      "pmid": "11603937",
      "doi": "10.1006\/mpev.2001.0993"
    },
    {
      "authors": [
        {
          "lastname": "Lopez-Vaamonde",
          "forename": "C."
        },
        {
          "lastname": "Dixon",
          "forename": "D."
        },
        {
          "lastname": "Cook",
          "forename": "J.M."
        },
        {
          "lastname": "Rasplus",
          "forename": "J.Y."
        }
      ],
      "atitle": "Revision of the Australian species of Pleistodontes (Hymenoptera: Agaonidae) fig-pollinating wasps and their host plant associations",
      "bibliographicCitation": "Zool. J. Linn. Soc. 136, 637-683 (2002)",
      "title": "Zool. J. Linn. Soc.",
      "volume": "136",
      "spage": "637",
      "epage": "683",
      "year": "2002",
      "issn": "0024-4082",
      "doi": "10.1046\/j.1096-3642.2002.00040.x"
    },
    {
      "authors": [
        {
          "lastname": "Lopez-Vaamonde",
          "forename": "C."
        },
        {
          "lastname": "Rasplus",
          "forename": "J.Y."
        },
        {
          "lastname": "Weiblen",
          "forename": "G.D."
        },
        {
          "lastname": "Cook",
          "forename": "J.M."
        }
      ],
      "atitle": "Direct Submission",
      "bibliographicCitation": "Submitted (04-JUL-2000) Biology, Imperial College, Silwood Park, Ascot, Berkshire SL57PY, UK"
    }
  ],
  "source": {
    "organism": "Pleistodontes sp. \'Raunsepna\'",
    "mol_type": "genomic DNA",
    "isolate": "378-clvdiez",
    "db_xref": "taxon:108959",
    "note": "Pleistodontes spec. nov."
  },
  "features": [
    
  ],
  "sequence": "cagtacaatcgacgagactgctaactctctttattttcgagggagcgaaagcctgaacgttcgtcgacgtaacatcggggggatgtcgcgggttggttgagaggtagaggaaagacgaggagagacgggcgaagacaccgcccgcccttcctctctctcgatctctatctccgtctatctcgtgatacatccctttataatttactcggcgtcgttcgaaacgaagtagggcgaggaggaagaagacgcgttggcgcgatcgagattgtccgatcgcgtccgtcgagtcccggagctctcgagggcggcgaacgaatgcgcgcccgctgggcggaccgacggattggatcgattcccgatgcgcagtaggcgttcttcatacttttctcgtcgccgattgatgcaagcgcgcgcgcgcgcgcgcgcgcgtatacgatatatgaaatatatatttataaacgcgcgcgcatcgcg"
}';
	$o = json_decode($j);

	$j = new Genbank();
	$j->SetData($o);
	$j->Dump();
	$j->Store();		
	echo "<br/><b>" . $j->GetObjectId() . "</b>";


}








?>