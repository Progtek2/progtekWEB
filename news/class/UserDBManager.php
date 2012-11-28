<?php
/**
 * Create and get Users. This class manages the relation between instances and database table containig user data
 * @author Eivind Kleiven
 *
 */
class UserDBManager
{
	/**
	 * 
	 * @param unknown_type $userId
	 * @return User
	 */
	public static function GetUserFromId($userId)
	{
		try
		{
			
			$db = Database::GetInstance();
			if(is_numeric($userId))
			{
				$query = "SELECT * FROM user WHERE id=".$db->Escape($userId);
				$row = $db->GetRow($query);
			}
			else
			{
				$row = Array();
			}
			
			if(count($row) > 0)
			{
				
				$user = self::GetInstanceFromDBRow($row);
				return $user;
			}
			else
			{
				throw new IdentificatorDoesNotExistException("User with id $userId does not exist in database table user");
			}
		}
		catch (Exception $e)
		{}
		
	}
	
	/**
	 * Returns user with the given username. If no user with username exist null is returned
	 * @param string $username
	 */
	public static function GetUserWithUsername($username)
	{
		$db = Database::GetInstance();
		$query = sprintf("SELECT * FROM user WHERE username = '%s'", $db->Escape($username));
		
		$row = $db->GetRow($query);
		
		if(!empty($row))
			$user = self::GetInstanceFromDBRow($row);
		else
			$user =  null;
		return $user;
	}
	
	/**
	 * Returns all users
	 * @param string $username
	 */
	public static function GetAllUsers()
	{
		$db = Database::GetInstance();
		$query = "SELECT * FROM user";
	
		$rows = $db->GetAll($query);
		
		$users = Array();
		foreach($rows as $row)
			$users[] = self::GetInstanceFromDBRow($row);
		
		return $users;
	}
	
	public static function AddKeyword(User $user, $keyword)
	{
		
	}
	public static function Create($username, $password, $givenName, $additionalName, $familyName, $email, $birthday, $gender, $group)
	{
		
		// First add the user with the Authenticate class
		$id = Authenticate::AddLogin($username, $password);
		
		try 
		{
			// Add remaining details to the database
			$user = self::GetUserFromId($id);
			$user->SetGivenName($givenName);
			$user->SetAdditionalName($additionalName);
			$user->SetFamilyName($familyName);
			$user->SetEmail($email);
			$user->SetBirthday($birthday);
			$user->SetGender($gender);
			$user->SetGroup($group);
			
			// Save the details to disk
			self::SaveChangesToDisk($user);
			
			return $user;
	
		}
		catch(IdentificatorDoesNotExistException $e)
		{
			return null;
		}
		
	}
	
	public static function GetUsersForCategory(Category $category)
	{
		$db = Database::GetInstance();
		$query = "SELECT * FROM user WHERE id IN (SELECT user_id FROM user_category WHERE category_id=".$db->Escape($category->GetId()).")";
		$rows = $db->GetAll($query);
	
		$users = Array();
		foreach($rows as $row)
			$users[] = self::GetInstanceFromDBRow($row);
	
		return $users;
	}
	private static function GetInstanceFromDBRow($row)
	{
		return	$user = new User($row['id'], $row['username'], $row['given_name'], $row['additional_name'], $row['family_name'], $row['email'], $row['birthday'], $row['gender'], $row['register_date'], $row['last_login_date'], $row['number_of_logins'], $row['group']);
	}
	public static function SaveChangesToDisk(User $user)
	{
		$db = Database::GetInstance();
		
		$fields['username'] 		= "'".$db->Escape(	$user->GetUsername()	)."'";
		$fields['given_name'] 		= "'".$db->Escape(	$user->GetGivenName()	)."'";
		$fields['additional_name'] 	= "'".$db->Escape(	$user->GetAdditionalName()	)."'";
		$fields['family_name'] 		= "'".$db->Escape(	$user->GetFamilyName()	)."'";
		$fields['email'] 			= "'".$db->Escape(	$user->GetEmail()	)."'";
		$fields['birthday'] 		= "'".$db->Escape(	$user->GetBirthday()	)."'";
		$fields['gender'] 			= "'".$db->Escape(	$user->GetGender()	)."'";
		$fields['user.group'] 			= "'".$db->Escape(	$user->GetGroup()	)."'";
		
		$count = count($fields);
		$i = 1;
		$query = "UPDATE user SET ";
		foreach ($fields as $fieldName => $value)
		{
			$query .= $fieldName . "=" . $value . ($i == $count ? ' ' : ', ');
			$i++;
		}
		
		$query .= "WHERE id=".$user->GetUserId();
		
		$db->Query($query);
		
	}
	
	
	public static function ValidateHtmlForm($form, User $user = null)
	{
		// Validate gender
		if($form['Gender']['Value'] != "Female" && $form['Gender']['Value'] != "Male" && $form['Gender']['Value'] != "Unknown")
		{
			$form['Gender']['Error'] = true;
			$form['Gender']['ErrorMessage'] ='Gyldige valg er: Female, Male, Unknown';
		}
		else
		{
			$form['Gender']['Error'] = false;
			$form['Gender']['ErrorMessage'] = '';
		}
		
		// Validate email
		$pattern = '#[[:alnum:].-_]+[[:alnum:]]+@[[:alnum:]]+[[:alnum:].-_]+[a-zA-Z]+$#';
		if(!preg_match($pattern, $form['Email']['Value'],$match))
		{
			$form['Email']['Error'] = true;
			$form['Email']['ErrorMessage'] = 'Ugyldig e-postadresse';
		}
		else
		{
			$form['Email']['Error'] = false;
			$form['Email']['ErrorMessage'] = '';
		}
		
		// Validate the username
		if(key_exists('Username', $form))
		{
			// If creating a new user or updating the username, then we must check if the username is available
			$pattern = '#^[[:alnum:]]+[[:alnum:]-_.]+[[:alnum:]]+$#';
			if(UserDBManager::GetUserWithUsername($form['Username']['Value']) != null)
			{
				$form['Username']['Error'] = true;
				$form['Username']['ErrorMessage'] = 'Brukernavn er opptatt';
			}
			elseif(strlen($form['Username']['Value']) < 3)
			{
				$form['Username']['Error'] = true;
				$form['Username']['ErrorMessage'] = 'Brukernavn m&aring; innholde minst 4 tegn';
			}
			elseif(!preg_match($pattern, $form['Username']['Value']))
			{
				$form['Username']['Error'] = true;
				$form['Username']['ErrorMessage'] = 'Gyldige tegn er: [a-z], [0-9], [-], [_] og [.]. Brukernavn m&aring; starte med bokstav eller tall';
			}
			else
			{
				$form['Username']['Error'] = false;
				$form['Username']['ErrorMessage'] = '';
			}
		}
		
		// Validate the password when registering a user
		if(array_key_exists('Password', $form))
		{
			if($form['Password']['Value'] != $form['RepeatPassword']['Value'] )
			{
				$form['RepeatPassword']['Error'] = true;
				$form['RepeatPassword']['ErrorMessage'] = 'Passord matcher ikke';
			}
			else
			{
				$form['RepeatPassword']['Error'] = false;
				$form['RepeatPassword']['ErrorMessage'] = '';
			}
			
			if(strlen($form['Password']['Value']) < 6)
			{
				$form['Password']['Error'] = true;
				$form['Password']['ErrorMessage'] = 'Passord m&aring; ha minst 7 tegn';
			}
			else
			{
				$form['Password']['Error'] = false;
				$form['Password']['ErrorMessage'] = '';
			}
		}
		
		// Validate Group
		if(key_exists('Group', $form))
		{
			// Only Administrators may change the group for a user	
			if($user != null && $user->GetGroup() == 'Admin')
			{
				if($form['Group']['Value'] != 'Admin' && $form['Group']['Value'] != 'Moderator' && $form['Group']['Value'] != 'User')
				{
					$form['Group']['Error'] = true;
					$form['Group']['ErrorMessage'] = 'Ugyldig gruppe. Velg: Admin, Moderator eller User';
				}
				else
				{
					$form['Group']['Error'] = false;
					$form['Group']['ErrorMessage'] = '';
				}
			}
			else
			{
				
				$form['Group']['Error'] = true;
				$form['Group']['ErrorMessage'] = 'Kun administrator kan endre gruppe';
				$form['Group']['Value'] = '';
			}
		}
	
		
		
		if(key_exists('Group', $form) && !$form['Email']['Error'] && !$form['Gender']['Error']  && !$form['Group']['Error'])
			$form['IsAdminEditValid'] = true;
		else
			$form['IsAdminEditValid'] = false;
		
		if(!$form['Email']['Error'] && !$form['Gender']['Error'])
			$form['IsUserEditValid'] = true;
		else
			$form['IsUserEditValid'] = false;
		
	
		if(key_exists('Username', $form) && key_exists('Password', $form) && key_exists('RepeatPassword', $form) && key_exists('Gender', $form))
		{
			if(!$form['Email']['Error'] && !$form['Username']['Error'] && !$form['Password']['Error'] && !$form['RepeatPassword']['Error'] && !$form['Gender']['Error'])
				$form['IsRegisterValid'] = true;
			else
				$form['IsRegisterValid'] = false;
		}
		else
		{
			$form['IsRegisterValid'] = false;
		}
		return $form;
	}
}