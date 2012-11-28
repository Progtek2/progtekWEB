<?php
/**
 * Class used by presentation files
 * @author Eivind Kleiven
 *
 */
class View_User_Login
{
	public $user = null;
	public $isLoggedIn = false;
	public $loginAttemptFailed = false;
	public $attemptedLoginWithUserName;
	public $requestRegister = false;
	
	public $module = "user";
	public $controller = "login";
	public $action = "index";
	
	public function __construct()
	{
		// Get the module and controller from $_POST or $_GET
		$module = fetch('Module');
		$controller = fetch('Controller');

		
		// Set to true if user is logged in
		$this->isLoggedIn = Authenticate::IsLoggedIn();
		
		// If user is logged in get the user
		if($this->isLoggedIn)
			$this->user = UserDBManager::GetUserFromId(Authenticate::GetUserId());
		

		// Get the requested action
		if($module == $this->module && $controller == $this->controller)
		{
			$action = Fetch('Action');
			if($action == 'login')
				$this->action = 'login';
			elseif ($action == 'logout')
				$this->action = 'logout';
			elseif ($action == 'requestRegister')
				$this->action = 'requestRegister';
			else
				$this->action = 'index';
		}
		
		//echo "Action: ".$this->action." Module: ".$this->module." Controller: ".$controller;
		
		if($this->action == 'login')
		{
			$username = Fetch('Username');
			$password = Fetch('Password');
			
			if(Authenticate::Login($username, $password))
			{
				$this->isLoggedIn = true;
				$this->user = UserDBManager::GetUserFromId(Authenticate::GetUserId());
				$this->loginAttemptFailed = false;
			}
			else
			{
				$this->isLoggedIn = false;
				$this->user = null;
				$this->loginAttemptFailed = true;
				$this->attemptedLoginWithUserName = $username;
			}	
		}
		elseif($this->action == 'logout')
		{
			Authenticate::Logout();
			$this->user = null;
			$this->isLoggedIn = false;
		}
		elseif($this->action == 'requestRegister')
		{
			$this->requestRegister = true;
		}
		
	}
}