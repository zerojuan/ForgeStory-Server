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
 		 
 		 var $_explicitType = "Item";
 		 
 		 function fill($result){
 		 	$this->id = $result["id"];
 		 	$this->name = $result["name"];
 		 	$this->forgerId = $result["forger_id"];
 		 	$this->price = $result["price"];
 		 	$this->type = $result["type"];
 		 	$this->taken = $result["taken"];
 		 	$this->description = $result["description"];
 		 }
 	}
?>
