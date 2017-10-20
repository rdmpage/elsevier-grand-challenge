<?php

// $Id: $

/**
 * @file class_reference.php
 *
 * Encapsulate a reference
 *
 */

// Make sure includes are absolute paths
$rootdir = dirname(__FILE__) . '/';

require_once($rootdir . 'class_object.php');

//--------------------------------------------------------------------------------------------------
/**
 * @brief Encapsulate a person
 *
 */
 
define('CLASS_PERSON',		3);
 
//--------------------------------------------------------------------------------------------------
/**
 * @brief Encapsulate a person
 *
 */

class Person extends Object
{

	//--------------------------------------------------------------------------------
	/**
	 * @brief Create object name from person's name
	 *
	 */
	function CreateName()
	{
		$this->mName = '';
		
		if ((isset($this->mData->forename)) and ($this->mData->forename != ''))
		{
			$this->mName .= str_replace(".", " ", $this->mData->forename) . ' ';
		}
		else
		{
			if (isset($this->mData->initials))
			{
				$this->mName .= $this->mData->initials . ' ';
			}
		}
		if (isset($this->mData->lastname))
		{
			$this->mName .= $this->mData->lastname;
		}
		if (isset($this->mData->suffix))
		{
			$this->mName .= ' ' . $this->mData->suffix;
		}
	}	
	
	//--------------------------------------------------------------------------------
	/**
	 * @brief Generate object identifier
	 *
	 * Generate md5 hash of person's name
	 * to do: really need a better way of doing this, hashing the email address 
	 * would be a good place to start...
	 */
	function GenerateObjectId()
	{
		$this->CreateName();
		$this->mObjectId = md5($this->mName);
	}
	
	//--------------------------------------------------------------------------------
	/**
	 * @brief hCard for a person
	 *
	 * hCard is described at http://microformats.org/wiki/hcard. 
	 *
	 *@return HTML hCard, enclosed in a DIV tag with style "visibility:hidden"
	 */
	function GetMicroformat()
	{
		$html = '<div style="visibility:hidden;height:0px;">' . "\n";	
		$html .= '<div class="vcard">' . "\n";
		$html .= '<span class="fn n">';
		$html .= '<span class="given-name">' . $this->GetAttributeValue('forename') . '</span>';
		$html .= '&nbsp;';
		$html .= '<span class="family-name">' . $this->GetAttributeValue('lastname') . '</span>';
		$html .= '</span>';
		
		$email = $this->GetAttributeValue('email');
		if ('' != $email)
		{
			$html .= '<span class="email">' . $email . '</span>';			
		}
				
		$html .= '</div>';
		$html .= '</div>';
		return $html;
	}


	//----------------------------------------------------------------------------------------------
	/**
	 * @brief Set object type (must be defined in each oject)
	 *
	 */
	function SetType()
	{
		$this->mClassId = CLASS_PERSON;
	}

}

?>