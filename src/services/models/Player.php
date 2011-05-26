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
 		
 		var $_explicitType = "model.Player";
 		
 		function fill($result){
 			$uid = $result["uid"];
 			$username = $result["username"];
 			$coins = $result["coins"];
 			$head = $result["head"];
 			$body = $result["wins"];
 			$wins = $result["loses"];
 			$loses = $result["isNew"];
 			$armor = $result["armor"];
 			$weapon = $result["weapon"];
 		}
 	}
?>
