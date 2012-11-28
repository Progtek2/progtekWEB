<?php
/**
 * Instances of this class represents keywords that users create to indicate what news they would like to read. 
 * All information about keywords are saved in a database. All relations between class instances and the corresponding
* database entry are managed by the class KeywordDBManager. Always use KeywordDBManager to create instances of this class.
* @author Eivind Kleiven
*
*/
class Keyword
{
	private $_id;
	private $_userId;
	private $_keyword;
	private $_isPersistent;

	public function __construct($id, $userId, $keyword)
	{
		$this->_id 			= $id;
		$this->_userId 		= $userId;
		$this->_keyword		= $keyword;
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
	public function GetKeyword()
	{
		return $this->_keyword;
	}

	public function SetUserId($value)
	{
		$this->_userId = $value;
		$this->_isPersistent = false;
	}
	public function SetKeyword($value)
	{
		$this->_keyword = $value;
		$this->_isPersistent = false;
	}
	
	public function SaveToDisk()
	{
		if (!$this->_isPersistent)
		{
			KeywordDBManager::SaveChangesToDisk($this);
			$this->_isPersistent = true;
		}
	}
	public function __destruct()
	{
		$this->SaveToDisk();
	}

}
?>