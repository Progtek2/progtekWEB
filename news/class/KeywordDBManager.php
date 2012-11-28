<?php
/**
 * This class manages the relation between instances and database table containig keyword
 * Each user may have many keywords, therefore keywords is stored on a separate table in the database.
 * @author Eivind Kleiven
 *
 */
class KeywordDBManager
{
	public static function GetKeywordFromId($id)
	{
		$db = Database::GetInstance();
		$query = "SELECT * FROM keyword WHERE id=".$db->Escape($id);
		$row = $db->GetRow($query);
		
		return self::GetInstanceFromDBRow($row);
	}

	public static function GetKeywordsForUserId($userId)
	{
		$db = Database::GetInstance();
		$query = "SELECT * FROM keyword WHERE user_id=".$db->Escape($userId);
		$rows = $db->GetAll($query);

		$result = Array();
		foreach($rows as $row)
			$result[] = self::GetInstanceFromDBRow($row);
		
		return $result;
	}
	public static function DeleteKeywordWithId($id)
	{
		$db = Database::GetInstance();
		
		$query = "DELETE FROM keyword WHERE id=".$db->Escape($id);
		if($db->Query($query))
			return true;
		else
			return false;
	}
	public static function Create(User $user, $keyword)
	{
		$db = Database::GetInstance();
		
		$fields['user_id'] 			= $db->Escape($user->GetUserId());
		$fields['keyword'] 			= "'".$db->Escape($keyword)."'";
	
		
		$fieldnames = '('.implode(',', array_keys($fields)).')';
		$values = 'VALUES ('.implode(',', $fields).')';
		
		$query = "INSERT INTO keyword $fieldnames $values";
		if($db->Query($query))
		{
			$id = $db->GetOne("SELECT LAST_INSERT_ID()");
			$keyword = self::GetKeywordFromId($id);
			$user->AddKeyword($keyword);
		}
	
	}
	
	private static function GetInstanceFromDBRow($row)
	{
		return new Keyword($row['id'], $row['user_id'], $row['keyword']);
	}
}