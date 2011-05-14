<?php
require './database.php';

if (isset($_POST["uid"])){
	
	$uid = $_POST["uid"];
	$forger_id = $_POST["forger_id"];
	$item_id = $_POST["item_id"];
	$item_sell_price = $_POST["item_sell_price"];
	$item_buy_price = $_POST["item_buy_price"];
	
	$cn = new DbConnection();
	$cn->Open();
	
	$dbRec = new DbRecord();
	$dbRec->Connection = $cn;
	
	$dbRec->Insert("INSERT INTO inventories(player_id, item_id) VALUES ('".$uid."','".$item_id."') ");
	
	//Deduct the price value from the buyer
	$rec = $dbRec->Get("SELECT coins FROM players WHERE uid = '".$uid."'");
	$origMoney = $rec["coins"] - $item_buy_price;
	$dbRec->Update("UPDATE players SET coins = ".$origMoney." WHERE uid = '".$uid."'");
	
	//Increment the price value to the seller
	$rec = $dbRec->Get("SELECT coins FROM players WHERE uid = '".$forger_id."'");
	$origMoney = $rec["coins"] + $item_sell_price;
	$dbRec->Update("UPDATE players SET coins = ".$origMoney." WHERE uid = '".$forger_id."'");
	
	$cn->Close();
	
	echo "Success";
}
?>