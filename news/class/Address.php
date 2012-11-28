<?php
/**
 * Instances of this class represents addresses that users have. All information about addresses are saved in a database. All relations between addresses instances and the corresponding
 * database entry are managed by the class AddressDBManager. Always use AddressDBManager or User to create/get instances of this class.
 * @author Eivind Kleiven
 *
 */
class Address
{
	private $_id;
	private $_userId;
	private $_label;
	private $_addressLine1;
	private $_addressLine2;
	private $_addressLine3;
	private $_city;
	private $_state;
	private $_postalCode;
	private $_countryName;
	private $_isPersistent;
	
	public function __construct($id, $userId, $label, $addressLine1, $addressLine2, $addressLine3, $postalCode, $city, $state, $countryName)
	{
		$this->_id = $id;
		$this->_userId = $userId;
		$this->_label = $label;
		$this->_addressLine1 = $addressLine1;
		$this->_addressLine2 = $addressLine2;
		$this->_addressLine3 = $addressLine3;
		$this->_city = $city;
		$this->_state = $state;
		$this->_countryName = $countryName;
		$this->_postalCode = $postalCode;
		
		$this->_isPersistent = true;
	}

	public function GetId()
	{
		return $this->_id;
	}
	public function GetUserId()
	{
		return $this->_userId;
	}
	public function GetLabel()
	{
		return $this->_label;
	}
	public function GetAddressLine1()
	{
		return $this->_addressLine1;
	}
	public function GetAddressLine2()
	{
		return $this->_addressLine2;
	}
	public function GetAddressLine3()
	{
		return $this->_addressLine3;
	}
	public function GetCity()
	{
		return $this->_city;
	}
	public function GetState()
	{
		return $this->_state;
	}
	public function GetPostalCode()
	{
		return $this->_postalCode;
	}
	public function GetCountryName()
	{
		return $this->_countryName;
	}
	public function SetUserId($value)
	{
		$this->_userId = $value;
		$this->_isPersistent = false;
	}
	public function SetLabel($value)
	{
		$this->_label = $value;
		$this->_isPersistent = false;
	}	
	public function SetAddressLine1($value)
	{
		$this->_addressLine1 = $value;
		$this->_isPersistent = false;
	}
	public function SetAddressLine2($value)
	{
		$this->_addressLine2 = $value;
		$this->_isPersistent = false;
	}
	public function SetAddressLine3($value)
	{
		$this->_addressLine3 = $value;
		$this->_isPersistent = false;
	}
	public function SetCity($value)
	{
		$this->_city = $value;
		$this->_isPersistent = false;
	}
	public function SetState($value)
	{
		$this->_state = $value;
		$this->_isPersistent = false;
	}
	public function SetPostalCode($value)
	{
		$this->_postalCode = $value;
		$this->_isPersistent = false;
	}
	public function SetCountryName($value)
	{
		$this->_countryName = $value;
		$this->_isPersistent = false;
	}
	public function SaveToDisk()
	{
		if (!$this->_isPersistent)
		{
			AddressDBManager::SaveChangesToDisk($this);
			$this->_isPersistent = true;
		}
	}
	public function __destruct()
	{
		$this->SaveToDisk();
	}
	
	public function ToHtml()
	{
		$result = "";
		if($this->GetAddressLine1() <> "")
			$result .= $this->GetAddressLine1()."<br />";
		if($this->GetAddressLine2() <> "")
			$result .= $this->GetAddressLine2()."<br />";
		if($this->GetAddressLine3() <> "")
			$result .= $this->GetAddressLine3()."<br />";

		$result .= $this->GetPostalCode()." ".$this->GetCity()."<br />".
		$this->GetCountryName();
		
		return $result;
		
	}
	public function ToHtmlForm()
	{
		$result = "";
			$result .= '<input type="text" name="AddressLine1['.$this->GetId().']" value="'.$this->GetAddressLine1().'" size="30" />';
			$result .= '<input type="text" name="AddressLine2['.$this->GetId().']" value="'.$this->GetAddressLine2().'" size="30" />';
			$result .= '<input type="text" name="AddressLine3['.$this->GetId().']" value="'.$this->GetAddressLine3().'" size="30" />';
			$result .= '<input type="text" name="PostalCode['.$this->GetId().']" value="'.$this->GetPostalCode().'" size="4" />';
			$result .= '<input type="text" name="City['.$this->GetId().']" value="'.$this->GetCity().'" size="20" />';
			$result .= '<input type="text" name="CountryName['.$this->GetId().']" value="'.$this->GetCountryName().'" size="30" />';
			
		return $result;
		
	}
	public static function ToHtmlCreateForm()
	{
		$result = "";
		$result .= '<label>Etikett: </label><br/><input type="text" name="Label[0]" value="" size="10" />';
		$result .= '<br /><label>Adresse: </label><br/><input type="text" name="AddressLine1[0]" value="" size="30" />';
		$result .= '<br /><label>Adresse2: </label><br/><input type="text" name="AddressLine2[0]" value="" size="30" />';
		$result .= '<br /><label>Adresse3: </label><br/><input type="text" name="AddressLine3[0]" value="" size="30" />';
		$result .= '<br /><label>Postnummer: </label><br/><input type="text" name="PostalCode[0]" value="" size="4" />';
		$result .= '<br /><label>Poststed: </label><br/><input type="text" name="City[0]" value="" size="20" />';
		$result .= '<br /><label>Land: </label><br/><input type="text" name="CountryName[0]" value="" size="30" />';
		return $result;
	}
	
	
}