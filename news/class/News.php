<?php
/**
 * Instances of this class represents news and it is only possible to read news. The news data is maintaned by another process All information about news are saved in a database. All relations between instances of this class and the corresponding
 * database entry are managed by the class NewsDBManager. Always use NewsDBManager to create instances of this class.
 * @author Eivind Kleiven
 *
 */
class News
{
	private $_id;
	private $_title;
	private $_description;
	private $_link;
	private $_author;
	private $_publishDate;
	private $_guid;
	
	public function __construct($id, $title, $description, $link, $author, $publishDate, $guid)
	{
		$this->_id = $id;
		$this->_title = $title;
		$this->_description = $description;
		$this->_link = $link;
		$this->_author = $author;
		$this->_publishDate = $publishDate;
		$this->_guid = $guid;
	}

	public function GetId()
	{
		return $this->_id;
	}
	public function GetTitle()
	{
		return $this->_title;
	}
	public function GetDescription()
	{
		return $this->_description;
	}
	public function GetLink()
	{
		return $this->_link;
	}
	public function GetAuthor()
	{
		return $this->_author;
	}
	public function GetPublishDate()
	{
		return $this->_publishDAte;
	}
	public function GetGuid()
	{
		return $this->_guid;
	}	
	
}