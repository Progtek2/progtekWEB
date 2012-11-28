<?php
/**
 * Configurations used by the webapplication
 * @author Eivind Kleiven
 *
 */
class Configuration
{
	private static $databaseHost 		= 'localhost';
	private static $databaseUsername 	= 'gruppe2';
	private static $databasePassword 	= 'gruppe2';
	private static $databaseName 		= 'gruppe2';

	public static function DatabaseHost()
	{
		return self::$databaseHost;
	}
	
	public static function DatabaseUsername()
	{
		return self::$databaseUsername;
	}
	
	public static function DatabasePassword()
	{
		return self::$databasePassword;
	}
	
	public static function DatabaseName()
	{
		return self::$databaseName;
	}
}