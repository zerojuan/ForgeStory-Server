<?php
/*
 * Created on May 22, 2011
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 	class Player{
 		var $uid;
 		var $username;
 		var $coins;
 		var $head;
 		var $body;
 		var $wins;
 		var $loses;
 		var $isNew;
 		var $armor;
 		var $weapon;
 		
 		var $_explicitType = "Player";
 		
 		function fill($result){
 			$this->uid = $result["uid"];
 			$this->username = $result["username"];
 			$this->coins = $result["coins"];
 			$this->head = $result["head"];
 			$this->body = $result["body"];
 			$this->wins = $result["wins"];
 			$this->loses = $result["loses"];
 			$this->isNew = $result["isNew"];
 			$this->armor = $result["armor"];
 			$this->weapon = $result["weapon"];
 		}

 	}
?>
