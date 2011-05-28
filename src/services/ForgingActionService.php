<?php

	require_once "/facebook.php";
	require_once "/database.php";
	require_once "/config.php";
	require_once "/models/Item.php";
	
	class ForgingActionService{
		
		function createItem($item, $imageData, $compressed=true){
			//save image first			
			//$jpg = $imageData;
			
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
			
			$item->uid = $uid;
			
			
			
			
			$data = $imageData->data;
			if($compressed){
				if (function_exists(gzuncompress)){
                    $data = gzuncompress($data);
                }
                else{
                    error_log("gzuncompress method does not exists, please send uncompressed data");
                }
			}
			
			$filename = "../forgestory/items/".$item->uid.".png";
			$result = file_put_contents($filename, $data, LOCK_EX);
			
			@chmod($filename, 0777);
						
			return $item;
		}
		
	}

?>