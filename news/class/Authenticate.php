<?php
require_once 'Database.php';

/**
 * This class is used to authenticate users and add new users.
 * The only user details known to this class is the username and user id. Other user details should be maintained using the User class.
 * @author Eivind Kleiven
 *
 */
class Authenticate
{
	
	/**
	 * If the user is authenticated an unsigned integer corresponding to the id field in the database table user, null otherwise.
	 * @var mixed
	 */
	private static $_userId = null;
	
	/**
	 * Characters used to prefix the password given by the user. 
	 * This way the MD5 hash stored in the database is harder to decode
	 * @var String
	 */
	private static $_passwordPrefix = '5V-?c#';


	/**
	 * If the user is authenticated its user id is returned, null is returned otherwise.
	 * 
	 * A user is authenticated if the following are true:
	 *  - The visitors host ip-adress is identical to the one saved in the database for the username given by the visitors session.
	 *  - The username given by the visitors session has not logged off since last login.
	 *  - The username stored in the visitor session and the session id exists in the database.
	 */
	private static function GetUserIdFromSession()
	{
		
		if(isset($_SESSION['username']))
		{
			$db = Database::GetInstance();
			
			$ip = $_SERVER['REMOTE_ADDR'];
			$sessionId = session_id();
			$username = $_SESSION['username'];
			
			$queryString = "SELECT id FROM user WHERE user_did_logout = 0 AND username = '".$db->Escape($username)."' AND ip='".$db->Escape($ip)."' AND php_session_id='".$db->Escape($sessionId)."'";

			$id = $db->GetOne($queryString);
			
			if(empty($id))
			{
				$id = null;
			}
		}
		else
		{
			$id = null;
			
		}
		

		return $id;
	}
	/**
	 * This method updates the class properties $_userId and $_isLoggedIn. If the username and password is correct $_userId is set to the userId for the given username, $_isLoggedIn is set to true and the $_SESSION['username'] is set to the username.
	 * If password and username does not match, $_userId is set to null, $_isLoggedIn to false and the $_session['username'] is unset.
	 * @param string $username Username for the user trying to login
	 * @param string $password Corresponding password
	 */
	public static function Login($username, $password)
	{
		$db = Database::GetInstance();
		
		$passwordHash = self::AddPrefixAndHash($password);
		$query = "SELECT id FROM user WHERE username='".$db->Escape($username)."' AND password='".$db->Escape($passwordHash)."'";
		$id = $db->GetOne($query);
		
		
		if(!empty($id))
		{
			$ip = $db->Escape($_SERVER['REMOTE_ADDR']);
			$sessionId = $db->Escape(session_id());
			
			$_SESSION['username'] = $username;
			self::$_userId = $id;
			$query = "UPDATE user SET user_did_logout = 0, php_session_id='".$sessionId."', ip='".$ip."', last_login_date=Now(), number_of_logins = (number_of_logins + 1) WHERE id = ".$db->Escape($id);
			$db->query($query);
			return true;
		}
		else
		{
			self::$_userId = null;
			unset($_SESSION['username']);
			return false;
		}
			
	}
	/**
	 * Update the table user and set user_did_logout to 1 (true). Unset the session.
	 */
	public static function Logout()
	{
		if(self::IsLoggedIn())
		{
			$db = Database::GetInstance();
			
			$db->query("UPDATE user SET user_did_logout = 1 WHERE id = ".$db->Escape(self::$_userId));
			self::$_userId = null;
			unset($_SESSION['username']);
		}
	}
	
	private static function AddPrefixAndHash($password)
	{
		return md5(self::$_passwordPrefix.$password);
	}
	public static function IsLoggedIn()
	{
		self::$_userId = self::GetUserId();
		if(self::$_userId != null)
			return true;
		else
			return false;
	}
	public static function GetUserId()
	{
		if(self::$_userId == null)
			self::$_userId = self::GetUserIdFromSession();
		return self::$_userId;
	}
	

	/**
	 * Adds a username and password to the database.
	 * @param String $username
	 * @param String $password
	 * @return mixed If user is added: user_id is returned. If username already exist: -1 is returned. Otherwhise null.
	 */
	public static function AddLogin($username, $password)
	{
		$existingUser = UserDBManager::GetUserWithUsername($username);
		
		if($existingUser === null)
		{
			$db = Database::GetInstance();
			$ip = $_SERVER['REMOTE_ADDR'];
			$phpSessionId = session_id();
			$passwordHash = self::AddPrefixAndHash($password);
			$query = "INSERT INTO user (username, password, ip, php_session_id, register_date) VALUES ('".$db->Escape($username)."', '".$db->Escape($passwordHash)."', '".$db->Escape($ip)."', '".$db->Escape($phpSessionId)."', Now())";
		
			if($db->Query($query))
			  	return $db->GetOne("SELECT LAST_INSERT_ID()");
			else
				return null;
		}
		else
		{
			return -1;
		}
		
	}
	

}
?>