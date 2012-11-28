<?php
/**
 * Create and get categories. This class manages the relation between instances and database table for categories
 * @author Eivind Kleiven
 *
 */
class CategoryDBManager
{
	/**
	 * 
	 * @param int $id
	 * @return Category
	 */
	public static function GetCategoryFromId($id)
	{
		try
		{
			
			$db = Database::GetInstance();
			if(is_numeric($id))
			{
				$query = "SELECT * FROM category WHERE id=".$db->Escape($id);
				$row = $db->GetRow($query);
			}
			else
			{
				$row = Array();
			}
			
			if(count($row) > 0)
			{
				$category = self::GetInstanceFromDBRow($row);
				return $category;
			}
			else
			{
				throw new IdentificatorDoesNotExistException("Category with id $id does not exist in database table category");
				return null;
			}
		}
		catch (Exception $e)
		{}
		
	}
	public static function GetCategoryFromIds($ids)
	{
		$db = Database::GetInstance();
		$escapedIds = array_map("$db->Escape", $ids);
		$inString = "(".implode(',', $escapedIds).")";
		$query = "SELECT * FROM category WHERE id IN $inString";
		
		$categories = Array();
		$rows = $db->GetAll($query);
		foreach($rows as $row)
			$categories[] = self::GetInstanceFromDBRow($row);
		
		return $categories;	
	}
	
	public static function GetActiveCategories()
	{
		$db = Database::GetInstance();
		$query = "SELECT * FROM category WHERE is_active = 1 ORDER BY sort_number ASC";
		
		$categories = Array();
		$rows = $db->GetAll($query);
		foreach($rows as $row)
			$categories[] = self::GetInstanceFromDBRow($row);
		
		return $categories;
	}
	
	public static function GetCategoriesForUserId($userId)
	{
		$db = Database::GetInstance();
		$query = "SELECT * FROM category WHERE id IN (SELECT category_id FROM user_category WHERE user_id=".$db->Escape($userId).")";
		$rows = $db->GetAll($query);
		
		$categories = Array();
		foreach($rows as $row)
			$categories[] = self::GetInstanceFromDBRow($row);
		
		return $categories;
	}
	/**
	 * Place the category right next (below) to the given sibling.
	 * @param Category $category
	 * @param Category $sibling
	 * @param Category $siblingIsParent If true, then the category is placed as the first sibling to $sibling. If false the category is set as the sibling to $sibling.
	 */
	public static function Move(Category $category, Category $sibling, $siblingIsParent=false)
	{
		$db = Database::GetInstance();
		
		$originalSortNumber = $category->GetSortNumber();
		$tempSortNumber = self::GetHighestSortNumber() + 2;
		$sortNumber = $sibling->GetSortNumber() + 1;
		
		if($siblingIsParent)
		{
			$parentId = $sibling->GetId();
			$level = $sibling->GetLevel() + 1;
		}
		else
		{
			$parentId = $sibling->GetParentId();
			$level = $sibling->GetLevel();
		}
		
		$category->SetSortNumber($tempSortNumber);
		$category->saveToDisk();
		
		self::IncrementSortNumbers($originalSortNumber+1, -1);
		self::IncrementSortNumbers($sortNumber, 1);
		
		
		$category->SetParentId($parentId);
		$category->SetSortNumber($sortNumber);
		$category->SetLevel($level);
		
		$category->saveToDisk();

	}
	/**
	 * Return all children having the given parentId
	 * @param int $parentId
	 */
	public static function GetChildren($parentId)
	{
		$db = Database::GetInstance();
		$children = Array();
		
		if(is_numeric($parentId))
		{
			$query = "SELECT * FROM category WHERE parent_id=".$db->Escape($parentId).' ORDER BY sort_number ASC';
			
			if($rows = $db->GetAll($query))
				foreach($rows as $row)
					$children[] = self::GetInstanceFromDBRow($row);
		}
		
		return $children;
	}
	
	public static function Create($parentId, $name, $description, $isActive = false)
	{
		
		// The level for this category should be the level of the parentId + 1 and the sort_number one bigger than the
		// sibling with the highest number or the parent (if no siblings exist)
		if($parentId == 0)
		{
			$level = 0;
			$sortNumber = self::GetHighestSortNumber() + 1;
		}
		else
		{
			$parent = self::GetCategoryFromId($parentId);
			$level = $parent->GetLevel() + 1;

			// Get the siblings for the category to be inserted
			$siblings = self::GetChildren($parentId);
			$numberOfSiblings = count($siblings);

			
			if($numberOfSiblings > 0)
				$sortNumber = $siblings[$numberOfSiblings - 1]->GetSortNumber() + 1;
			else
				$sortNumber = $parent->GetSortNumber() + 1;
		

		}
		
		// sort_numbers must be unique, therefore we must add 1 to all categories with sort_numbe greater or equal to $sortNumber
		// before we can insert the new category
		self::IncrementSortNumbers($sortNumber, 1);
		
		$db = Database::GetInstance();
		
		$fields['parent_id'] 		= $db->Escape($parentId);
		$fields['name'] 			= "'".$db->Escape($name)."'";
		$fields['description'] 		= "'".$db->Escape($description)."'";
		$fields['sort_number'] 		= $db->Escape($sortNumber);
		$fields['level'] 			= $db->Escape($level);
		$fields['is_active'] 		= ($isActive ? 1 : 0);
		
		
		$fieldnames = '('.implode(',', array_keys($fields)).')';
		$values = 'VALUES ('.implode(',', $fields).')';
		
		$query = "INSERT INTO category $fieldnames $values";
		if($db->Query($query))
		{
			$id = $db->GetOne("SELECT LAST_INSERT_ID()");
			$category = self::GetCategoryFromId($id);
		}
		else
			$category = null;
		
		return $category;
		
	}
	/**
	 * Return true if the user subcribes to the category
	 * @param User $user
	 * @param Category $category
	 */
	public static function UserIsSubscriber(User $user, Category $category)
	{
		$db = Database::GetInstance();
		$query = "SELECT count(*) FROM user_category WHERE user_id=".$db->Escape($user->GetUserId()).' AND category_id='.$db->Escape($category->GetId());
		$result = $db->GetOne($query);
		if($result > 0)
			return true;
		else
			return false;
	}
	/**
	 * Add user as subscriber to a category.
	 * @param User $user
	 * @param Category $category
	 * @return boolean true on success, false otherwise.
	 */
	public static function AddSubscriber(User $user, Category $category)
	{
		$db = Database::GetInstance();
		$query = "INSERT INTO user_category (user_id, category_id) VALUES (".$db->Escape($user->GetUserId()).', '.$db->Escape($category->GetId()).')';
		if($db->Query($query))
			return true;
		else
			return false;
	}
	/**
	 * Remove a user from the subcribers of a category
	 * @param User $user
	 * @param Category $category
	 * @return boolean true on success, false otherwise.
	 */
	public static function RemoveSubscriber(User $user, Category $category)
	{
		$db = Database::GetInstance();
		$query = "DELETE FROM user_category WHERE user_id=".$db->Escape($user->GetUserId()).' AND category_id='.$db->Escape($category->GetId()).' LIMIT 1';
		if($db->Query($query))
			return true;
		else
			return false;
	}
	/**
	 * Remove all subscriptions for a user
	 * @param User $user
	 * @return boolean
	 */
	public static function RemoveAllSubscriptionsForUser(User $user)
	{
		$db = Database::GetInstance();
		$query = "DELETE FROM user_category WHERE user_id=".$db->Escape($user->GetUserId());
		if($db->Query($query))
			return true;
		else
			return false;
	}
	
	public static function SaveChangesToDisk(Category $category)
	{
		$db = Database::GetInstance();
		
		$fields['parent_id'] 		= $db->Escape(	$category->GetParentId()	);
		$fields['name'] 			= "'".$db->Escape(	$category->GetName()	)."'";
		$fields['description'] 		= "'".$db->Escape(	$category->GetDescription()	)."'";
		$fields['sort_number'] 		= $db->Escape(	$category->GetSortNumber()	);
		$fields['level'] 			= $db->Escape(	$category->GetLevel()	);
		$fields['is_active'] 		= $db->Escape(	$category->GetIsActive()	);
		
		$count = count($fields);
		$i = 1;
		$query = "UPDATE category SET ";
		foreach ($fields as $fieldName => $value)
		{
			$query .= $fieldName . "=" . $value . ($i == $count ? ' ' : ', ');
			$i++;
		}
		
		$query .= "WHERE id=".$category->GetId();
		
		$db->Query($query);
		
	}
	private static function GetInstanceFromDBRow($row)
	{
		return new Category($row['id'], $row['parent_id'], $row['name'], $row['description'], $row['sort_number'], $row['level'], $row['is_active']);
	}
	/**
	 * All categories with sort_numbers >= $startSortNumber are incremented by the value of $increment
	 * @param int $minimumSortNumber
	 * @param int $increment
	 */
	private static function IncrementSortNumbers($startSortNumber, $increment)
	{
		$db = Database::GetInstance();
		$query = "UPDATE category SET sort_number = (sort_number + ".$db->Escape($increment).") WHERE sort_number >= ".$db->Escape($startSortNumber)." ORDER BY sort_number DESC";

		if($result = $db->Query($query))
			return true;
		else
			return false;

	}
	/**
	 * All categories with sort_numbers <= $startSortNumber are incremented by the value of $increment
	 * @param int $minimumSortNumber
	 * @param int $increment
	 */
	private static function IncrementSortNumbersBelow($startSortNumber, $increment)
	{
		$db = Database::GetInstance();
		$query = "UPDATE category SET sort_number = (sort_number + ".$db->Escape($increment).") WHERE sort_number <= ".$db->Escape($startSortNumber)." ORDER BY sort_number DESC";
	
		if($result = $db->Query($query))
			return true;
		else
			return false;
	
	}

	/**
	 * Return the highest sort_number
	 */
	private static function GetHighestSortNumber()
	{
		$db = Database::GetInstance();
		$query = "SELECT Max(sort_number) FROM category";
		
		$id = $db->GetOne($query);
		if($id == null)
			$id =  0;
		return $id;
	}
}