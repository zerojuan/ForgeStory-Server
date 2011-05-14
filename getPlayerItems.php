<?php
require './database.php';

if (isset($_POST["uid"])){
	
	$uid = $_POST["uid"];
	
	$cn = new DbConnection();
	$cn->Open();

	$query = "SELECT * FROM items WHERE forger_id='".$uid."'";
	$result = $cn->GetDataSet($query);
	
	$cn->Close();
	
	echo json_encode($result);
}
?>