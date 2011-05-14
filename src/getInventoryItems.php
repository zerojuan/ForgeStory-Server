<?php
require './database.php';

if (isset($_POST["uid"])){
	
	$uid = $_POST["uid"];
	$type = $_POST["type"];
	
	$cn = new DbConnection();
	$cn->Open();

	$query = "SELECT items.id, items.name, items.forger_id, items.price, items.type, items.taken, items.description FROM inventories, items WHERE inventories.player_id = '".$uid."' AND inventories.item_id = items.id AND items.TYPE = ".$type."";
	$result = $cn->GetDataSet($query);
	
	$cn->Close();
	
	echo json_encode($result);
}
?>