<?php
/**
 * Instances of this class represents categories which users can subscribe to. All information about categories are saved in a database. All relations between user instances and the corresponding
 * database entry are managed by the class CategoryDBManager. Always use CategoryDBManager to create instances of this class.
 * @author Eivind Kleiven
 *
 */
class Category
{
	// Members stored in the database
	private $_id;
	private $_parentId;
	private $_name;
	private $_description;
	private $_sortNumber;
	private $_level;
	private $_isActive;

	// Other members
	private $_isPersistent;

	public function __construct($id, $parentId, $name, $description, $sortNumber, $level, $isActive)
	{
		$this->_id 			= $id;
		$this->_parentId 	= $parentId;
		$this->_name 		= $name;
		$this->_description = $description;
		$this->_sortNumber	= $sortNumber;
		$this->_level 		= $level;
		$this->_isActive 	= $isActive;
		
		$this->_isPersistent = true;
	}
	
	public function GetId()
	{
		return $this->_id;
	}
	public function GetParentId()
	{
		return $this->_parentId;
	}
	public function GetName()
	{
		return $this->_name;
	}
	public function GetDescription()
	{
		return $this->_description;
	}
	public function GetSortNumber()
	{
		return $this->_sortNumber;
	}
	public function GetLevel()
	{
		return $this->_level;
	}
	public function GetIsActive()
	{
		return $this->_isActive;
	}
	
	public function GetParent()
	{
		if($this->GetParentId() == 0)
			return null;
		else
			return CategoryDBManager::GetCategoryFromId($this->GetParentId());
	}
	public function GetChildren()
	{
		return CategoryDBManager::GetChildren($this->GetId());
	}
		
	public function SetId($value)
	{
		$this->_id = $value;
		$this->_isPersistent = false;
	}
	public function SetParentId($value)
	{
		$this->_parentId = $value;
		$this->_isPersistent = false;
	}
	public function SetName($value)
	{
		$this->_Name = $value;
		$this->_isPersistent = false;
	}
	public function SetDescription($value)
	{
		$this->_description = $value;
		$this->_isPersistent = false;
	}
	public function SetIsActive($value)
	{
		$this->_isActive = $value;
		$this->_isPersistent = false;
	}
	
	public function GetSubscribers()
	{
		return UserDBManager::GetUsersForCategory($this);
	}
	
	public function UserIsSubscriber(User $user)
	{
		return CategoryDBManager::UserIsSubscriber($user, $this);
	}
	
	public function SetSortNumber($value)
	{
		$this->_sortNumber = $value;
		$this->_isPersistent = false;
	}
	public function SetLevel($value)
	{
		$this->_level = $value;
		$this->_isPersistent = false;
	}
	
	public function saveToDisk()
	{
		if (!$this->_isPersistent)
		{
			CategoryDBManager::SaveChangesToDisk($this);
			$this->_isPersistent = true;
		}
	}
	public function __destruct()
	{
		$this->saveToDisk();
	}

}