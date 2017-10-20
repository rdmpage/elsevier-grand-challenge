<?php

// $Id: $

/**
 * @file class_reference.php
 *
 * Encapsulate a reference
 *
 * Assume we will be handling output from bioGUID's OpenURL resolver,
 * so ISSN (if available) will be filled in, and author names will be parsed
 *
 *
 */

// Make sure includes are absolute paths
$rootdir = dirname(__FILE__) . '/';

require_once($rootdir . 'class_object.php');
require_once($rootdir . 'class_journal.php');
require_once($rootdir . 'class_person.php');
require_once($rootdir . 'class_tag.php');

require_once($rootdir . 'www/issn_image.php');


//--------------------------------------------------------------------------------------------------
/**
 * @brief Encapsulate a journal article
 *
 */
 
define('CLASS_REFERENCE',		2);
 
//--------------------------------------------------------------------------------------------------
/**
 * @brief Encapsulate a journal article
 *
 */
class Reference extends Object
{
	
	//--------------------------------------------------------------------------------
	/**
	 * @brief Compute a JACC (Journal Article Citation Convention) identifier for an
	 * article.
	 *
	 * JACC (Journal Article Citation Convention) is a simple way to compute an 
	 * identifier for an article. Proposed by Robert Cameron in 1998 in a technical
	 * report (<a href="ftp://fas.sfu.ca/pub/cs/TR/1998/CMPT1998-08.html">
	 * Scholar-Friendly DOI Suffixes with JACC: Journal Article Citation Convention</a>,
	 * a JACC has the following syntax:
	 * 
	 *	[JACC]<journal-code>:<volume>@<page>
	 *
	 * Where <journal-code> may either be a journal ISSN or a mnemonic code for the journal 
	 * specified by the publisher, <volume> is the volume number in which the article appears 
	 * and <page> specifies the first page number of the article.
	 *
	 * Here we ignore the [JACC] prefix, and just generate <journal-code>:<volume>@<page> using
	 * the journal's ISSN or, if that is unavailable, the eISSN.
	 * 	
	 */	
	function ComputeJacc()
	{
		$jacc = '';
		
		if (
			isset($this->mData->issn)
			&& isset($this->mData->volume)
			&& isset($this->mData->spage)
			)
		{
			// check
			if (
				($this->mData->issn != '')
				&& ($this->mData->volume != '')
				&& ($this->mData->spage != '')
			)
			{
				$jacc = $this->mData->issn . ':' . $this->mData->volume . '@' . $this->mData->spage;
			}
		}
		else if (
			isset($this->mData->eissn)
			&& isset($this->mData->volume)
			&& isset($this->mData->spage)
			)
		{
			if (
				($this->mData->eissn != '')
				&& ($this->mData->volume != '')
				&& ($this->mData->spage != '')
			)
			{
				$jacc = $this->mData->eissn . ':' . $this->mData->volume . '@' . $this->mData->spage;
			}
		}
		
		return $jacc;		
	}
	
	//--------------------------------------------------------------------------------
	/**
	 * @brief Generate name for reference, using the title of the article
	 *
	 */
	function CreateName()
	{
		if (isset($this->mData->atitle))
		{
			$this->mName = $this->mData->atitle;
		}
	}	
	
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Generate object identifier
	 *
	 * By default for an article we use the md5 hash of the JACC. If we can't compute a JACC,
	 * we use the DOI, if that isn't available use the article title, failing that, a unique integer
	 *
	 */
	function GenerateObjectId()
	{
		$id = '';
		
		$jacc = $this->ComputeJacc();
		if ($jacc != '')
		{
			$id = $jacc;
		}
		else
		{
			// Do we have any other guids (a paper with a DOI may lack pagination),
			// or we may be dealing with a book, etc.)
			if (isset($this->mData->doi))
			{	
				$id = $this->mData->doi;
			}
			
			if ($id == '')
			{
				// We may have a title of the reference (e.g., from GenBank)
				if (isset($this->mData->atitle))
				{	
					$id = $this->mData->atitle;
				}
				else 
				{
					// A unique number
					$id = uniqid('');
				}
			}
		}
		$this->mObjectId = md5($id);
	}	
	
	
	//----------------------------------------------------------------------------------------------
	function GetHtmlSnippet()
	{
		$html = '';
		
		$issn = $this->GetAttributeValue('issn');
		
		$html .= '<table>';
		$html .= '<tbody style="font-size:12px">';
		
		$html .= '<tr>';
		$html .= '<td width="1" valign="top">';
		
		
		$image_url = issn_image($issn);
		if ($image_url != '')
		{
			$html .= '<img src="' . $image_url . '" height="40" />';
		}
		else
		{
			$html .= '<img src="images/issn/unknown.png" height="40" />';
		}
		
/*		
		
		switch($issn)
		{
			// Elsevier
			case '1055-7903':
			case '1439-6092':
			case '0169-5347':
			
			// JSTOR
			case '0045-8511':
			case '0960-7447':
			case '0026-6493':
			case '0022-1511':
			case '0363-6445':
			
			// Wiley
			case '0006-3606':
			case '0962-1083':
			case '0748-3007':
			case '0046-5070':
			case '0024-4066':
			case '0954-4879':
			case '0300-3256':
			case '0024-4082':
			
			// Informaworld
			case '1063-5157':
			
			// Oxford
			case '1367-4803':
			case '0305-1048':
			case '0737-4038':
			
			case '0027-8424':
			case '0018-067X':
			case '0016-6731':
			
			// Ingenta
			case '0011-216X':
			case '0173-5373':
			
				$html .= '<img src="images/issn/' . str_replace('-','',$issn) . '.gif" height="40" />';
				break;
				
			// Informaworld
			case '0022-2933':
				$html .= '<img src="images/issn/' . str_replace('-','',$issn) . '.png" height="40" />';
				break;
				
			// Blackwell's / Wiley
			case '0305-0270':
			case '0014-3820':
			
			// BioOne
			case '0003-0090':
			case '0278-0372':
			case '0003-0082':
			case '0004-8038':
			case '0091-7613':
			case '0043-5643':
			case '0003-1569':
			
			// NRC
			case '1205-7533':
			
			
			case '0018-0831':
			case '0733-1347':
			
			case '0036-8075':
				$html .= '<img src="images/issn/' . str_replace('-','',$issn) . '.jpg" height="40" />';
				break;
				
			case '0962-8452':
			
			// Springer
			case '0022-2844':
			case '1064-7554':
			case '0960-3115':
			case '0018-8158':
				$html .= '<img src="images/issn/' . str_replace('-','',$issn) . '.jpg" height="40" />';
				break;
				
			default:
				$html .= '<img src="images/issn/unknown.png" height="40" />';
				break;
		}
		*/
		$html .= '</td>';
		$html .= '<td valign="top">';
		
		$html .= '<a href="uri/' . $this->GetObjectId() . '"> ' .  $this->GetTitle() . '</a>';
		$html .= '<br/>';
		
		$html .= '<i>';		
		$html .= $this->GetAttributeValue('title');
		$html .='</i>';
		
		$html .= ' ' . $this->GetAttributeValue('volume');
		$html .= ': ' . $this->GetAttributeValue('spage');
		$html .= ' (' . year_from_date($this->GetAttributeValue('year')) .')';
		
		$html .= '</td>';
		$html .= '</tr>';
		$html .= '</tbody>';
		$html .= '</table>';
		
/*		$html = '<div style="border:1px solid blue;">';
		if ($issn == '1055-7903')
		{
			$html .= '<img src="images/10557903.gif" height="64" />';
		}
		$html .= '</div>';*/
	
		return $html;
	}	
	
	//--------------------------------------------------------------------------------
	/**
	 * @brief Merge data for this object with version we have in database
	 *
	 * @param author_id Unique identifier for author or agent storing the object
	 * @param ip IP address of author or agent storing the object
	 * @param comment Comment describing the edit 
	 */
	function Merge($author_id='', $ip='127.0.0.1', $comment='')
	{		
		// Add any GUIDs we get from this version of the reference
		$this->StoreGuids($author_id, $ip, $comment);
		
		// Abstract?
		if ($this->GetAttributeValue('abstract') == '')
		{
			if (isset($this->mData->abstract))
			{
				$this->StoreAttributeValue('abstract', $this->mData->abstract, $author_id, $ip, $comment);			
			}
		}

		if ($this->GetAttributeValue('title') == '')
		{
			if (isset($this->mData->title))
			{
				$this->StoreAttributeValue('title', $this->mData->title, $author_id, $ip, $comment);			
			}
		}
		if ($this->GetAttributeValue('volume') == '')
		{
			if (isset($this->mData->volume))
			{
				$this->StoreAttributeValue('volume', $this->mData->volume, $author_id, $ip, $comment);			
			}
		}
		if ($this->GetAttributeValue('issue') == '')
		{
			if (isset($this->mData->issue))
			{
				$this->StoreAttributeValue('issue', $this->mData->issue, $author_id, $ip, $comment);			
			}
		}
		if ($this->GetAttributeValue('spage') == '')
		{
			if (isset($this->mData->spage))
			{
				$this->StoreAttributeValue('spage', $this->mData->spage, $author_id, $ip, $comment);			
			}
		}
		if ($this->GetAttributeValue('epage') == '')
		{
			if (isset($this->mData->epage))
			{
				$this->StoreAttributeValue('epage', $this->mData->epage, $author_id, $ip, $comment);			
			}
		}
		if ($this->GetAttributeValue('atitle') == '')
		{
			if (isset($this->mData->atitle))
			{
				$this->StoreAttributeValue('atitle', $this->mData->atitle, $author_id, $ip, $comment);			
			}
		}
		if ($this->GetAttributeValue('issn') == '')
		{
			if (isset($this->mData->issn))
			{
				$this->StoreAttributeValue('issn', $this->mData->issn, $author_id, $ip, $comment);			
			}
		}
		if ($this->GetAttributeValue('eissn') == '')
		{
			if (isset($this->mData->eissn))
			{
				$this->StoreAttributeValue('eissn', $this->mData->eissn, $author_id, $ip, $comment);			
			}
		}
		if ($this->GetAttributeValue('date') == '')
		{
			if (isset($this->mData->date))
			{
				$this->StoreAttributeValue('date', $this->mData->date, $author_id, $ip, $comment);			
			}
		}
		if ($this->GetAttributeValue('year') == '')
		{
			if (isset($this->mData->year))
			{
				$this->StoreAttributeValue('year', $this->mData->year, $author_id, $ip, $comment);			
			}
		}
		
		
		// Keywords?
		
		
	}
	
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Test whether an object with any of this object's guids is already in the database
	 *
	 * Use any of the standard bibliographic identifiers
	 *
	 * @return object identifier if object exists, otherwise ''
	 *
	 */
	function ObjectIdFromGuid()
	{
		$object_id = '';
		
		if (isset($this->mData->doi))
		{
			$object_id = db_find_object_with_guid('doi', $this->mData->doi);
		}
		if ($object_id == '')
		{
			if (isset($this->mData->hdl))
			{
				$object_id = db_find_object_with_guid('hdl', $this->mData->hdl);
			}
		}		
		if ($object_id == '')
		{
			if (isset($this->mData->pmid))
			{
				$object_id = db_find_object_with_guid('pmid', $this->mData->pmid);
			}
		}		
		if ($object_id == '')
		{
			$jacc = $this->ComputeJacc();
			if ($jacc != '')
			{
				$object_id = db_find_object_with_guid('jacc', $jacc);
			}
		}		
		
		
		echo "ObjectIdFromGuid $object_id\n";
		
		return $object_id;
		
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Test whether an object is already in the database based on metadata
	 *	 
	 * Do we have reference already. For an article we use the ISSN, volume, spage triple
	 *
	 * @return object identifier if object exists, otherwise ''
	 *
	 */
	function ObjectIdFromMetadata()
	{
		$object_id = '';

		/*
		// stupid, stupid, this tests for object matching one of these, not all simulatenously
		if (isset($this->mData->issn))
		{
			$hits = db_find_objects_with_attribute_value($this->mClassId, 'issn', $this->mData->issn);
			if (count($hits) > 0)
			{
				$hits = db_find_objects_with_attribute_value($this->mClassId, 'volume', $this->mData->volume);
				if (count($hits) > 0)
				{
					$hits = db_find_objects_with_attribute_value($this->mClassId, 'spage', $this->mData->spage);
					if (count($hits) > 0)
					{
						$object_id = $hits[0];
					}
				}
			}
		}
		
		echo "ObjectIdFromMetadata $object_id\n";
		
		*/
		return $object_id;
	}	
		
	
	
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Post process reference
	 *
	 * Fix dates and generate object identifier
	 *
	 */
	function PostProcess()
	{
		if (preg_match("/^[0-9]{4}$/", $this->mData->date))
		{
			$this->mData->date .= '-00-00';		
		}
		if (preg_match("/^[0-9]{4}$/", $this->mData->year))
		{
			$this->mData->year .= '-00-00';		
		}
	}	
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Set object type (must be defined in each object)
	 *
	 */
	function SetType()
	{
		$this->mClassId = CLASS_REFERENCE;
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Store object GUIDs in EAV database
	 *
	 * Store whatever GUID we have for this reference, such as DOIs, PubMed ids, Handles,
	 * URLs, and the JACC.
	 *
	 * Use identifier class to extract identifier string.
	 *
	 * @param author_id Unique identifier for author or agent storing the object
	 * @param ip IP address of author or agent storing the object
	 * @param comment Comment describing the edit 
	 */
	function StoreGuids($author_id, $ip, $comment)
	{
		
		if (isset($this->mData->doi))
		{
			db_store_object_guid($this->mObjectId, 'doi', $this->mData->doi, $author_id, $ip, $comment);
		}
		if (isset($this->mData->url))
		{
			db_store_object_guid($this->mObjectId, 'url', $this->mData->url, $author_id, $ip, $comment);
		}
		if (isset($this->mData->hdl))
		{
			db_store_object_guid($this->mObjectId, 'hdl', $this->mData->hdl, $author_id, $ip, $comment);
		}
		if (isset($this->mData->pmid))
		{
			db_store_object_guid($this->mObjectId, 'pmid', $this->mData->pmid, $author_id, $ip, $comment);
		}
		$jacc = $this->ComputeJacc();
		if ($jacc != '')
		{
			db_store_object_guid($this->mObjectId, 'jacc', $jacc, $author_id, $ip, $comment);
		}
	}	
	
			
	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Store links between this obeject and anny associated objects
	 *
	 * Link article reference to authors and journal
	 *
	 * @param author_id Unique identfiier for author or agent storing the object
	 * @param ip IP address of author or agent storing the object
	 * @param comment Comment describing the edit 
	 */
	function StoreLinks($author_id, $ip, $comment)
	{
		// Authors
		if (isset($this->mData->authors))
		{
			
			$count = 1;
			foreach ($this->mData->authors as $a)
			{			
			
				//print_r($a);
			
			
				$author = new Person();
				$author->SetData($a);
				$author->Store();
				
				$authorId = $author->GetObjectId();
				
				db_link_objects(
					$authorId, 
					$this->GetObjectId(), 
					RELATION_AUTHOR_OF,
					$count,
					$author_id, $ip, $comment);

				$count++;
			}
		}
		
		// Journal
		// Link to journal
		if (isset($this->mData->issn) or isset($this->mData->eIssn))
		{
			$o = new stdClass;
			
			if (isset($this->mData->issn))
			{
				$o->issn = $this->mData->issn;
			}
			else
			{
				$o->eIssn = $this->mData->eIssn;
			}
			
			$o->title= $this->mData->title;
	
			$j = new Journal();
			$j->SetData($o);
			$j->Store();		
			$journalId = $j->GetObjectId();
			
			db_link_objects(
				$this->GetObjectId(), 
				$journalId,
				RELATION_IS_PART_OF,
				1,
				$author_id, $ip, $comment);
			
		}
		
		
		// Tags (keywords)
		if (isset($this->mData->keywords))
		{
			foreach ($this->mData->keywords as $k)
			{			
				$kw = new Tag();
				
				$kwd = new stdClass;
				$kwd->title = $k;
				
				$kw->SetData($kwd);
				$kw->Store();
				
				$kw->Dump();
				
				$kw_Id = $kw->GetObjectId();
				
				db_link_objects(
					$this->GetObjectId(),
					$kw_Id, 
					RELATION_TAGGED_WITH_TAG,
					1,
					$author_id, $ip, $comment);

				$count++;
			}
		}
		
		
		
	}

	
}
?>