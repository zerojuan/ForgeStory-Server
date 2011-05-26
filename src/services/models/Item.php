<?php
/*
 * Created on May 22, 2011
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 	class Item{
 		 var $id;
 		 var $name;
 		 var $forgerId;
 		 var $price;
 		 var $type;
 		 var $taken;
 		 var $description;
 		 
 		 var $_explicitType = "model.Item";
 		 
 		 function fill($result){
 		 	$id = $result["id"];
 		 	$name = $result["name"];
 		 	$forgerId = $result["forger_id"];
 		 	$price = $result["price"];
 		 	$type = $result["type"];
 		 	$taken = $result["taken"];
 		 	$description = $result["description"];
 		 }
 	}
?>
