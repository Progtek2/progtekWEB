<?php
/**
 * This class manages the relation between instances and database table containing news
 * @author Eivind Kleiven
 *
 */
class NewsDBManager
{
	public static function GetNewsFromId($id)
	{
		$db = Database::GetInstance();
		$query = "SELECT * FROM news WHERE id=".$db->Escape($id);
		$row = $db->GetRow($query);
		
		return self::GetInstanceFromDBRow($row);
	}

	public static function GetNewsForUserId($userId)
	{
		$db = Database::GetInstance();
		$query = 'SELECT news.* FROM news WHERE id IN (SELECT DISTINCT news_id FROM news_category a INNER JOIN user_category b ON a.category_id = b.category_id WHERE b.user_id='.$db->Escape($userId).' ) ORDER BY publish_date DESC';
		$rows = $db->GetAll($query);

		$result = Array();
		foreach($rows as $row)
			$result[] = self::GetInstanceFromDBRow($row);
		
		return $result;
	}
	
	public static function GetNewsForKeyword(Keyword $keyword)
	{
		$db = Database::GetInstance();
		
		$query = "SELECT * FROM news WHERE description LIKE '%".$keyword->GetKeyword()."%' OR title LIKE '%".$keyword->GetKeyword()."%' ORDER BY publish_date DESC";
		$rows = $db->GetAll($query);
	
		$result = Array();
		foreach($rows as $row)
			$result[] = self::GetInstanceFromDBRow($row);
	
		return $result;
	}


	public static function GetAllNews($startAtRow = null, $numberOfRows = null)
	{
		if($numberOfRows == null && $startAtRow == null)
		{
			$limit = '';
		}
		elseif(is_numeric($startAtRow) && $startAtRow >= 0 && $numberOfRows == null)
		{
			$limit = ' LIMIT '.(int)$startAtRow.' ';
		}
		elseif(is_numeric($startAtRow) && is_numeric($numberOfRows) && $startAtRow >= 0)
		{
			$limit = ' LIMIT '.(int)$startAtRow.' , '.(int)$numberOfRows.' ';
		}
		else
		{
			$limit = '';
		}
		
		$db = Database::GetInstance();
		$query = 'SELECT * FROM news ORDER BY publish_date DESC'.$limit;
		$rows = $db->GetAll($query);
	
		$result = Array();
		foreach($rows as $row)
			$result[] = self::GetInstanceFromDBRow($row);
	
		return $result;
	}
	
	
	private static function GetInstanceFromDBRow($row)
	{
		return new News($row['id'], $row['title'], $row['description'], $row['link'], $row['author'], $row['publish_date'], $row['guid']);
	}
}