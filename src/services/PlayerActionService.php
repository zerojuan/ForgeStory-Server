<?php
	require_once "/facebook.php";
	require_once "/database.php";
	require_once "/config.php";
	require_once "/models/Player.php";
	require_once "/models/Item.php";
	
	class PlayerActionService{
		
		function update($player){			
			$cn = new DbConnection();
			$cn->Open();

			$dbRec = new DbRecord();
			$dbRec->Connection = $cn;
	
			$dbRec->Update("UPDATE players SET username = '".$player->name."', head = '".$player->head."', body = '".$player->body."', armor = '".$player->armor."', weapon = '".$player->weapon."'
					WHERE uid = '".$player->uid."'");
	
	
			$cn->Close();
	
			return $player;
		}
		
		public function get($player){
			$cn = new DbConnection();
			$cn->Open();
		
			$dbRec = new DbRecord();
			$dbRec->Connection = $cn;
			$query = "SELECT * FROM players WHERE uid='".$player->uid."'";
			$result = $dbRec->Get($query);
			
			$cn->Close();
			
			$player = new Player();
			$player->fill($result);
			
			return $player;
		}
		
		public function getMyInventory($player, $item){
			$cn = new DbConnection();
			$cn->Open();
		
			$query = "SELECT items.id, items.name, items.forger_id, items.price, items.type, items.taken, items.description FROM inventories, items WHERE inventories.player_id = '".$player->uid."' AND inventories.item_id = items.id AND items.TYPE = ".$item->type."";
			$results = $cn->GetDataSet($query);
			
			$cn->Close();
			
			$itemList = array();
			foreach($results as $result){
				$item = new Item();
				$item->fill($result);
				array_push($itemList, $item);
			}
			
			echo $itemList;
		}
		
		function getPlayerBuddies($player){
			
			$cn = new DbConnection();
			$cn->Open();
			
			$query = "SELECT buddies.buddy_id, players.username, players.head, players.body FROM players, buddies WHERE buddies.user_id='".$player->uid."' && buddies.buddy_id = players.uid";
			$results = $cn->GetDataSet($query);
			$cn->Close();
			
			$playerList = array();
			
			foreach($results as $result){
				$player = new Player();
				$player->fill($result);
				$player->uid = $result["buddy_id"];
				array_push($playerList, $player);
			}
			
			return $playerList;
		}
		
		function create(){
			
		}
		
	}



?>