<?php
	require_once "/facebook.php";
	require_once "/database.php";
	require_once "/config.php";
	require_once "/models/Player.php";
	
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
		
		function get($uid){
			$cn = new DbConnection();
			$cn->Open();
		
			$dbRec = new DbRecord();
			$dbRec->Connection = $cn;
			$query = "SELECT * FROM players WHERE uid='".$uid."'";
			$result = $dbRec->Get($query);
			
			$cn->Close();
			
			$player = new Player();
			$player->fill($result);
			
			return $player;
		}
		
		function create(){
			
		}
		
	}



?>