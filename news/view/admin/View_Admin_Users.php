<?php
class View_Admin_Users
{
	public $value;
	
	public function __construct()
	{
		if(isset($_GET['Value']))
			$this->value = $_GET['Value'];
	}
}