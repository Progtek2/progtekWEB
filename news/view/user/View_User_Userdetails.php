<?php
/**
 * Class used by presentation files
 * @author Eivind Kleiven
 *
 */
class View_User_Userdetails
{
	public $user;
	public $editUser;
	public $categories;
	public $detailsForm = Array();
	public $detailsFormWasSubmitted = false;
	public $requestedAddAddress = false;
	private $allUsers;
	
	public $module = "user";
	public $controller = "userdetails";
	public $action = "index";
	
	public function __construct()
	{		
		// Get the module and controller from $_POST or $_GET
		$module = fetch('Module');
		$controller = fetch('Controller');
		
		
		$this->categories = CategoryDBManager::GetActiveCategories();
				
		// Get the user that is editing user information
		if(($userId = Authenticate::GetUserId()) !== null)
			$this->user = UserDBManager::GetUserFromId(Authenticate::GetUserId());
		else 	
			$this->user = null;
		
		// Get the user id of the user that are edited
		$editUserId = (int)fetch('EditUserId');
		if($this->user != null && $editUserId == $this->user->GetUserId())
			$this->editUser = $this->user;
		else
			$this->editUser = UserDBManager::GetUserFromId($editUserId);
		
		// If no edit user is given, assume the user is editing itself
		if($this->editUser == null)
		{
			$this->editUser = $this->user;
		}
		
		// Only administrators can edit other users information
		if($this->user != null && $this->editUser != null && $this->editUser->GetUserId() != $this->user->GetUserId() && $this->user->GetGroup() != 'Admin')
		{
			$this->editUser = null;
			$this->user = null;
		}
		
		
		// Get the requested action
		if($module == $this->module && $controller == $this->controller)
		{
			$action = Fetch('Action');
			if($action == 'saveCategories')
				$this->action = 'saveCategories';
			elseif ($action == 'saveDetails')
				$this->action = 'saveDetails';
			elseif ($action == 'saveAddresses')
				$this->action = 'saveAddresses';
			elseif ($action == 'deleteAddress')
				$this->action = 'deleteAddress';
			elseif ($action == 'addAddress')
				$this->action = 'addAddress';
			elseif ($action == 'requestAddAddress')
				$this->action = 'requestAddAddress';
			elseif ($action == 'deleteSelectedKeywords')
				$this->action = 'deleteSelectedKeywords';
			elseif ($action == 'addKeyword')
				$this->action = 'addKeyword';
			elseif ($action == 'logout')
				$this->action = 'logout';
			else
				$this->action = 'index';
		}
		
		
		if($this->action == 'saveCategories')
		{
			$this->SaveCategories();
		}
		elseif($this->action == 'saveDetails')
		{
			$this->SaveDetails();
		}
		elseif($this->action == 'saveAddresses')
		{
			$this->SaveAddresses();
		}
		elseif($this->action == 'deleteAddress')
		{
			$addresses = $this->editUser->GetAddresses();
			$deleteAddressId = fetch('AddressId');
			foreach($addresses as $address)
				if($address->GetId() == $deleteAddressId)
				{
					AddressDBManager::DeleteAddressWithId($deleteAddressId);
					$this->editUser->SetAddresses(AddressDBManager::GetAddressesForUserId($this->editUser->GetUserId()));
				}				
		}
		elseif($this->action == 'requestAddAddress')
		{
			$this->requestedAddAddress = true;
		}
		elseif($this->action == 'addKeyword')
		{
			$keyword = fetch('Keyword');
			KeywordDBManager::Create($this->editUser, $keyword);
			
			$this->editUser->GetKeywords();
		}
		elseif($this->action == 'deleteSelectedKeywords')
		{
			$ids = fetch('KeywordIds');
			if(!is_array($ids))
				return;
			$ids = array_keys($ids);
			
			foreach($ids as $id)
			{
				KeywordDBManager::DeleteKeywordWithId($id);				
			}
			
		}	
	}
	
	public function GetAllUsers()
	{
		if(!isset($this->allUsers))
			$this->allUsers = UserDBManager::GetAllUsers();
		return $this->allUsers;
	}
	
	private function SaveCategories()
	{
		$userCategories = $this->editUser->GetCategories();
		$selectedCategoryIds = fetch('CategoryIds');

		if(!is_array($selectedCategoryIds))
			return;
		
		$selectedCategoryIds = array_keys($selectedCategoryIds);
		
		foreach($selectedCategoryIds as $categoryId)
			if (!is_numeric($categoryId))
				return;
		
		// Unsubscribe from all categories
		$this->editUser->UnsubscribeAll();
		
		foreach($selectedCategoryIds as $categoryId)
			if(($category = CategoryDBManager::GetCategoryFromId($categoryId)) !== null)
				$this->editUser->Subscribe($category);
	}
	private function SaveAddresses()
	{
		$addressLine1 = Fetch('AddressLine1');
		$addressLine2 = Fetch('AddressLine2');
		$addressLine3 = Fetch('AddressLine3');
		$city = Fetch('City');
		$postalCode = Fetch('PostalCode');
		$countryName = Fetch('CountryName');
		$label = fetch('Label');
		
		if(!$addressLine1)
			return;

		
		$addresses = $this->editUser->GetAddresses();
		$ids = array_keys($addressLine1);
		
		foreach($addresses as $address)
		{	
			if(in_array($address->GetId(),$ids))
			{
				if(!empty($addressLine1[$address->GetId()]))
					 $address->SetAddressLine1($addressLine1[$address->GetId()]);
				else
					$address->SetAddressLine1("");
				
				if(!empty($addressLine2[$address->GetId()]))
					$address->SetAddressLine2($addressLine2[$address->GetId()]);
				else
					$address->SetAddressLine2("");
				
				if(!empty($addressLine3[$address->GetId()]))
					$address->SetAddressLine3($addressLine3[$address->GetId()]);
				else
					$address->SetAddressLine3("");

				
				if(!empty($city[$address->GetId()]))
					$address->SetCity($city[$address->GetId()]);
				else
					$address->SetCity("");
				
				if(!empty($postalCode[$address->GetId()]))
					$address->SetPostalCode($postalCode[$address->GetId()]);
				else
					$address->SetPostalCode("");
				
				if(!empty($countryName[$address->GetId()]))
					$address->SetCountryName($countryName[$address->GetId()]);
				else
					$address->SetCountryName("");
				
				$address->SaveToDisk();
			}
		}
		
		// If an id=0 is sent, it means the address does not yet exist and needs to be created
		if(in_array(0,$ids))
		{
			if(!empty($label[0]))
			{	
				AddressDBManager::Create($this->editUser, $label[0], $addressLine1[0], $addressLine2[0], $addressLine3[0], $city[0], '', $postalCode[0], $countryName[0]);
				$this->editUser = UserDBManager::GetUserFromId($this->editUser->GetUserId());
			}
		}

		
	
	}
	private function SaveDetails()
	{
		$this->detailsFormWasSubmitted = true;
		
		$form['GivenName']['Value'] = fetch('GivenName');
		$form['AdditionalName']['Value'] = fetch('AdditionalName');
		$form['FamilyName']['Value'] = fetch('FamilyName');
		$form['Email']['Value'] = fetch('Email');
		$form['Gender']['Value'] = fetch('Gender');
		$form['Birthday']['Value'] = fetch('Birthday');
		$form['Group']['Value'] = fetch('Group');
		
		
		$form = UserDBManager::ValidateHtmlForm($form, $this->user);
		
		if($form['IsUserEditValid'])
		{
			$this->editUser->SetGivenName($form['GivenName']['Value']);
			$this->editUser->SetAdditionalName($form['AdditionalName']['Value']);
			$this->editUser->SetFamilyName($form['FamilyName']['Value']);
			$this->editUser->SetEmail($form['Email']['Value']);
			$this->editUser->SetBirthday($form['Birthday']['Value']);
			$this->editUser->SetGender($form['Gender']['Value']);
		}		

		if($form['IsAdminEditValid'])
		{
			$this->editUser->SetGroup($form['Group']['Value']);
		}
		
		$this->editUser->SaveToDisk();
		
		$this->detailsForm = $form;

	}
}