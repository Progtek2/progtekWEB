<?php
/**
 * Class used by presentation files
 * @author Eivind Kleiven
 *
 */
class View_User_Registrer
{
	public $user;
	public $registeredUser = null;
	public $registerForm;
	public $registerFormWasSubmitted = false;
	public $userRegisterSuccess = false;
	public $isLoggedIn = false;
	public $loginAttemptFailed = false;
	public $attemptedLoginWithUserName;
	public $requestRegister = false;
	
	public $module = "user";
	public $controller = "register";
	public $action = "index";
	
	public function __construct()
	{
		
		// Get the module and controller from $_POST or $_GET
		$module = fetch('Module');
		$controller = fetch('Controller');

		// Get the requested action
		if($module == $this->module && $controller == $this->controller)
		{
			$action = Fetch('Action');
			
			if($action == 'register')
				$this->action = 'register';
			else
				$this->action = 'index';
		}
		
		
		// Get the logged in user that are registering a new user
		$this->user = UserDBManager::GetUserFromId(Authenticate::GetUserId());
		if($this->action == 'register')
		{
			$this->Register();
		}
				
	}
	
	private function Register()
	{
		$this->registerFormWasSubmitted = true;
			
		$form['Username']['Value'] = fetch('Username');
		$form['Password']['Value'] = fetch('Password');
		$form['RepeatPassword']['Value'] = fetch('RepeatPassword');
		
		$form['GivenName']['Value'] = fetch('GivenName');
		$form['AdditionalName']['Value'] = fetch('AdditionalName');
		$form['FamilyName']['Value'] = fetch('FamilyName');
		$form['Email']['Value'] = fetch('Email');
		$form['Gender']['Value'] = fetch('Gender');
		$form['Birthday']['Value'] = fetch('Birthday');
		
		if(key_exists('Group', $form))
			$form['Group']['Value'] = fetch('Group');

		$form = UserDBManager::ValidateHtmlForm($form, $this->user);		

		if(!key_exists('Group', $form))
		{
			$form['Group']['Value'] = 'User';
			$form['Group']['Error'] = false;
			$form['Group']['ErrorMessage'] = '';
		}
		print_r($form);
		
		if($form['IsRegisterValid'])
		{
			$this->registeredUser = UserDBManager::Create($form['Username']['Value'], $form['Password']['Value'], $form['GivenName']['Value'], $form['AdditionalName']['Value'], $form['FamilyName']['Value'], $form['Email']['Value'], $form['Birthday']['Value'], $form['Gender']['Value'], $form['Group']['Value']);
		
			if($this->registeredUser !== null)
			{
				$this->userRegisterSuccess = true;
				
				// If no user was logged in then log in the registered user
				if($this->user == null)
				{
					// Login the user
					Authenticate::Login($form['Username']['Value'], $form['Password']['Value']);
				}
			}
		}
		
		$this->registerForm = $form;
	}
	
	
}