<?php
/**
 * This class manages the relation between instances and database table containig address data
 * Each user may have many addresses, therefore addresses is stored on a separate table in the database.
 * @author Eivind Kleiven
 *
 */
class AddressDBManager
{
	public static function GetAddressFromId($id)
	{
		$db = Database::GetInstance();
		$query = "SELECT * FROM address WHERE id=".$db->Escape($id);
		$row = $db->GetRow($query);
		
		return self::GetInstanceFromDBRow($row);
	}

	public static function GetAddressesForUserId($userId)
	{
		$db = Database::GetInstance();
		$query = "SELECT * FROM address WHERE user_id=".$db->Escape($userId);
		$rows = $db->GetAll($query);

		$addresses = Array();
		foreach($rows as $row)
			$addresses[] = self::GetInstanceFromDBRow($row);
		
		return $addresses;
	}
	public static function DeleteAddressWithId($addressId)
	{
		$db = Database::GetInstance();
		
		$query = "DELETE FROM address WHERE id=".$db->Escape($addressId);
		if($db->Query($query))
			return true;
		else
			return false;
	}
	public static function Create($user, $label, $addressLine1, $addressLine2, $addressLine3, $city, $state, $postalCode, $countryName)
	{
		$db = Database::GetInstance();
		
		$fields['user_id'] 			= "'".$db->Escape($user->GetUserId())."'";
		$fields['label'] 			= "'".$db->Escape($label)."'";
		$fields['address_line1'] 	= "'".$db->Escape($addressLine1)."'";
		$fields['address_line2'] 	= "'".$db->Escape($addressLine2)."'";
		$fields['address_line3'] 	= "'".$db->Escape($addressLine3)."'";
		$fields['city'] 			= "'".$db->Escape($city)."'";
		$fields['state'] 			= "'".$db->Escape($state)."'";
		$fields['postal_code'] 		= "'".$db->Escape($postalCode)."'";
		$fields['country_name'] 	= "'".$db->Escape($countryName)."'";
	
		
		$fieldnames = '('.implode(',', array_keys($fields)).')';
		$values = 'VALUES ('.implode(',', $fields).')';
		
		$query = "INSERT INTO address $fieldnames $values";
		if($db->Query($query))
		{
			$id = $db->GetOne("SELECT LAST_INSERT_ID()");
			$address = self::GetAddressFromId($id);
			$user->AddAddress($address);
		}
	
	}
	public static function SaveChangesToDisk(Address $address)
	{
		$db = Database::GetInstance();

		$fields['user_id'] 			= "'".$db->Escape(	$address->GetUserId()	)."'";
		$fields['label'] 			= "'".$db->Escape(	$address->GetLabel()	)."'";
		$fields['address_line1'] 	= "'".$db->Escape(	$address->GetAddressLine1()	)."'";
		$fields['address_line2'] 	= "'".$db->Escape(	$address->GetAddressLine2()	)."'";
		$fields['address_line3'] 	= "'".$db->Escape(	$address->GetAddressLine3()	)."'";
		$fields['city'] 			= "'".$db->Escape(	$address->GetCity()	)."'";
		$fields['state'] 			= "'".$db->Escape(	$address->GetState()	)."'";
		$fields['postal_code'] 		= "'".$db->Escape(	$address->GetPostalCode()	)."'";
		$fields['country_name'] 	= "'".$db->Escape(	$address->GetCountryName()	)."'";
		
		$count = count($fields);
		$i = 1;
		$query = "UPDATE address SET ";
		foreach ($fields as $fieldName => $value)
		{
			$query .= $fieldName . "=" . $value . ($i == $count ? ' ' : ', ');
			$i++;
		}

		$query .= "WHERE id=".$address->GetId();

		$db->Query($query);
	}
	
	private static function GetInstanceFromDBRow($row)
	{
		return new Address($row['id'], $row['user_id'], $row['label'], $row['address_line1'], $row['address_line2'], $row['address_line3'], $row['postal_code'], $row['city'], $row['state'], $row['country_name']);
	}
}