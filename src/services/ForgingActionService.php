<?php

	require_once "/facebook.php";
	require_once "/database.php";
	require_once "/config.php";
	
	class ForgingActionService{
		
		function createItem($item, $imageData){
			//save image first			
			$jpg = $imageData;
			
			mkdir("items", 0777);
			file_put_contents("./items/".$item->name, $jpg, LOCK_EX);
			
			$uid = uniqid();
	
			$cn = new DbConnection();
			$cn->Open();
		
			$dbRec = new DbRecord();
			$dbRec->Connection = $cn;
			
			$description = $dbRec->Clean($item->description);
			$itemName = $dbRec->Clean($item->name);
			$forger = $item->forgerId;
			$price = $item->price;
			$type = $item->type;
			
			$dbRec->Insert("INSERT INTO items(id, name, forger_id, description, price, type) VALUES ('".$uid."','".$itemName."','".$forger."','".$description."',".$price.",".$type.")");
			
			$cn->Close();
			
			$item->uid = uid;
			
			return $item;
		}
		
	}

?>