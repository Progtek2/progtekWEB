<?php
/**
 * All queries to the database is performed using this class.
 * It follows the singleton pattern, i.e. only one instance of this class can be created. 
 * @author Eivind Kleiven
 *
 */
class Database
{
	private static $instance = null;
	
	private $_mysqli;
	private $_charset = 'utf8';
	
	
	private function __construct()
	{
		

		$this->_mysqli = new mysqli(Configuration::DatabaseHost(), Configuration::DatabaseUsername(), Configuration::DatabasePassword(), Configuration::DatabaseName());
	
		if($this->_mysqli->connect_error)
		{
			die('Connect Error (' . $this->mysqli->connect_errno . ') '.$this->mysqli->connect_error);
		}
		
		if (!$this->_mysqli->set_charset("utf8")) 
		{
			die("Error loading character set utf8: ".$mysqli->error);
		}
	}
	
	
	public static function GetInstance()
	{
		if(self::$instance == null)
			self::$instance = new Database();
		return self::$instance;
	}
	
	public function Query($query)
	{
		if(!($result = $this->_mysqli->query($query)))
		{
			trigger_error("Error: ".$this->_mysqli->error. "\nSQL: $query");
			exit;
		}
		else
			return $result;
	}
	public function GetOne($query)
	{
		$result = $this->_mysqli->query($query)->fetch_array(MYSQLI_NUM);
		if(count($result) > 0)
			$value = $result[0];
		else
			$value = null;
		
		return $value;
	}
	public function GetRow($query)
	{
		if($result = $this->_mysqli->query($query))
		{	
			$row = $result->fetch_array(MYSQL_ASSOC);
		}
		else
		{ 
			trigger_error("Error: ".$this->_mysqli->error. "\nSQL: $query");
			$row = Array();
		}
		
		return $row;
	}
	public function GetAll($query)
	{
		$array = Array();
		
		if($result = $this->_mysqli->query($query))
		{
			while($row = $result->fetch_array(MYSQL_ASSOC))
				$array[] = $row;		
			
		}
		else
		{
			trigger_error("Error: $this->_mysqli->error");
				
		}	
		
		return $array;
	}
	public function Escape($str)
	{
		return $this->_mysqli->real_escape_string($str);
	}
}