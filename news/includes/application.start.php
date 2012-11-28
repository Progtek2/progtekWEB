<?php
/**
 * Manually ask php to check if a session id has been sent with the request
 * Documentation: http://www.php.net/manual/en/book.session.php
 */
session_start();

define('APPLICATION_ROOT', dirname(dirname(__FILE__)));
spl_autoload_register ('application_autoloader');
function application_autoloader($class)
{
	
	$folders = explode('_', $class);
	if(count($folders) == 1)	
		require_once APPLICATION_ROOT.'/class/'.$class.'.php';
	else
		require_once APPLICATION_ROOT.'/'.implode('/', array_map('strtolower', array_slice($folders, 0, count($folders)-1))).'/'.$class.'.php';

}



function fetch($key)
{
	if(isset($_POST[$key]))
		return $_POST[$key];
	elseif(isset($_GET[$key]))
		return $_GET[$key];
	else
		return false;
}




?>