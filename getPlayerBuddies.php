<?php
require './database.php';

if (isset($_POST["uid"])){
	
	$uid = $_POST["uid"];
	
	$cn = new DbConnection();
	$cn->Open();
	
	$query = "SELECT buddies.buddy_id, players.username, players.head, players.body FROM players, buddies WHERE buddies.user_id='".$uid."' && buddies.buddy_id = players.uid";
	$result = $cn->GetDataSet($query);
	
	$cn->Close();
	
	echo json_encode($result);
}
?>