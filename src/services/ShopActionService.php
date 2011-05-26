<?php

	require_once "/facebook.php";
	require_once "/database.php";
	require_once "/config.php";
	
	class ShopActionService{
		
		function buyItem($item, $player, $isFree){
			if($isFree){
				$item_buy_price = 0;
			}else{
				$item_buy_price = $item->price;
			}

			$cn = new DbConnection();
			$cn->Open();
			
			$dbRec = new DbRecord();
			$dbRec->Connection = $cn;
			
			$dbRec->Insert("INSERT INTO inventories(player_id, item_id) VALUES ('".$player->uid."','".$item->id."') ");
			
			//Deduct the price value from the buyer
			$rec = $dbRec->Get("SELECT coins FROM players WHERE uid = '".$player->uid."'");
			$origMoney = $rec["coins"] - $item_buy_price;
			$dbRec->Update("UPDATE players SET coins = ".$origMoney." WHERE uid = '".$player->uid."'");
			
			//Increment the price value to the seller
			$rec = $dbRec->Get("SELECT coins FROM players WHERE uid = '".$item->forgerId."'");
			$origMoney = $rec["coins"] + $item->price;
			$dbRec->Update("UPDATE players SET coins = ".$origMoney." WHERE uid = '".$player->uid."'");
			
			$cn->Close();
			
			return "Success";
		}
		
		
		function getShopInventory($uid){
			$cn = new DbConnection();
			$cn->Open();
			
			$query = "SELECT * FROM items WHERE forger_id='".$uid."'";
			$result = $cn->GetDataSet($query);
	
			$cn->Close();
			
			return json_encode($result);
		}
		
		
	}

?>