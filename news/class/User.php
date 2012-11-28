<?php
/**
 * Instances of this class represents users. All information about users are saved in a database. All relations between user instances and the corresponding
 * database entry are managed by the class UserDBManager. Always use UserDBManager to create instances of this class.
 * @author Eivind Kleiven
 *
 */
class User
{
	private $_userId;
	private $_username;
	private $_givenName;
	private $_additionalName;
	private $_family_name;
	private $_email;
	private $_birthday;
	private $_gender;
	private $_group;
	private $_registerDate;
	private $_lastLoginDate;
	private $_numberOfLogins;
	
	private $_categories;
	private $_addresses;
	private $_keywords;
	
	private $_isPersistent;

	public function __construct($userId, $username, $givenName, $additionalName, $familyName, $email, $birthday, $gender, $registerDate, $lastLoginDate, $numberOfLogins, $group)
	{
		$this->_userId 			= $userId;
		$this->_username 		= $username;
		$this->_givenName 		= $givenName;
		$this->_additionalName 	= $additionalName;
		$this->_familyName		= $familyName;
		$this->_email 			= $email;
		$this->_birthday 		= $birthday;
		$this->_gender 			= $gender;
		$this->_registerDate 	= $registerDate;
		$this->_lastLoginDate	= $lastLoginDate;
		$this->_numberOfLogins 	= $numberOfLogins;
		$this->_group			= $group;
		
		
		$this->_isPersistent = true;
	}
	
	public function GetUserId()
	{
		return $this->_userId;
	}
	public function GetUsername()
	{
		return $this->_username;
	}
	public function GetGivenName()
	{
		return $this->_givenName;
	}
	public function GetAdditionalName()
	{
		return $this->_additionalName;
	}
	public function GetFamilyName()
	{
		return $this->_familyName;
	}
	public function GetEmail()
	{
		return $this->_email;
	}
	public function GetBirthday()
	{
		return $this->_birthday;
	}	
	public function GetGender()
	{
		return $this->_gender;
	}
	public function GetGroup()
	{
		return $this->_group;
	}
	public function GetRegisterDate()
	{
		return $this->_registerDate;
	}
	public function GetLastLoginDate()
	{
		return $this->_lastLoginDate;
	}
	public function GetNumberOfLogins()
	{
		return $this->_numberOfLogins;
	}
	
	public function GetCategories()
	{
		$this->_categories = CategoryDBManager::GetCategoriesForUserId($this->_userId);
		return $this->_categories;
	}
	public function GetAddresses()
	{
		$this->_addresses = AddressDBManager::GetAddressesForUserId($this->_userId);
		return $this->_addresses;
	}
	public function GetKeywords()
	{
		$this->_keywords = KeywordDBManager::GetKeywordsForUserId($this->_userId);
		return $this->_keywords;
	}	
	public function SetUserId($value)
	{
		$this->_userId = $value;
		$this->_isPersistent = false;
	}

	public function SetUsername($value)
	{
		$this->_username = $value;
		$this->_isPersistent = false;
	}
	public function SetGivenName($value)
	{
		$this->_givenName = $value;
		$this->_isPersistent = false;
	}
	public function SetAdditionalName($value)
	{
		$this->_additionalName = $value;
		$this->_isPersistent = false;
	}
	public function SetFamilyName($value)
	{
		$this->_familyName = $value;
		$this->_isPersistent = false;
	}
	public function SetEmail($value)
	{
		$this->_email = $value;
		$this->_isPersistent = false;
	}
	public function SetBirthday($value)
	{
		$this->_birthday = $value;
		$this->_isPersistent = false;
	}
	public function SetAddresses($value)
	{
		$this->_addresses = $value;
		$this->_isPersistent = false;
	}
	public function SetGender($value)
	{
		$this->_gender = $value;
		$this->_isPersistent = false;
	}
	public function SetGroup($value)
	{
		$this->_group = $value;
		$this->_isPersistent = false;
	}
	public function AddAddress(Address $address)
	{
		if(!isset($this->_addresses))
			$this->_addresses = Array();
		
		$this->_addresses[] = $address;
	}
	public function AddKeyword(Keyword $keyword)
	{
		if(!isset($this->_keywords))
			$this->_keywords = Array();
		$this->_keywords[] = $keyword;
	}	
	/**
	 * Subscribe to a category
	 * @param Category $category
	 */
	public function Subscribe(Category $category)
	{
		if(!isset($this->_categories))
			$this->_categories = Array();
		
		if(!$this->IsSubscriberToCategory($category))
			if(CategoryDBManager::AddSubscriber($this, $category))
				$this->_categories[] = $category;
	}
	/**
	 * Unsubscribe from a category
	 * @param Category $category
	 */
	public function Unsubscribe(Category $category)
	{
		if($this->IsSubscriberToCategory($category) && CategoryDBManager::RemoveSubscriber($this, $category))
		{
			$categories = Array();
			for($i=0; $i<count($this->_categories); $i++)
				if($this->_categories[$i]->GetId() != $category->GetId())
					$categories = $this->_categories[$i];
			$this->_categories = $categories;
		}
	}
	/**
	 * Unsubscribe from all subscriptions
	 */
	public function UnsubscribeAll()
	{
		if($return = CategoryDBManager::RemoveAllSubscriptionsForUser($this))
			$this->_categories = Array();
		return $return;
	}
	/**
	 * 
	 * @param Category $category
	 */
	public function IsSubscriberToCategory(Category $category)
	{
		return $category->UserIsSubscriber($this);
	}
	
	public function SaveToDisk()
	{
		if (!$this->_isPersistent)
		{
			UserDBManager::SaveChangesToDisk($this);
			$this->_isPersistent = true;
		}
	}
	public function __destruct()
	{
		$this->SaveToDisk();
	}

}