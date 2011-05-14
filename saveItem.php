<?php
require './database.php';

if (isset($_POST["itemName"])){
	
	$uid = uniqid();
	
	$cn = new DbConnection();
	$cn->Open();

	$dbRec = new DbRecord();
	$dbRec->Connection = $cn;
	
	$description = $dbRec->Clean($_POST["itemDesc"]);
	$itemName = $dbRec->Clean($_POST["itemName"]);
	$forger = $_POST["forgerId"];
	$price = $_POST["itemPrice"];
	$type = $_POST["itemType"];
	
	$dbRec->Insert("INSERT INTO items(id, name, forger_id, description, price, type) VALUES ('".$uid."','".$itemName."','".$forger."','".$description."',".$price.",".$type.")");
	
	$cn->Close();
	
	echo $uid;
}
?>