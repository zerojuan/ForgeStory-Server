<?php
require './database.php';

if (isset($_POST["uid"])){
	
	$uid = $_POST["uid"];
	
	$cn = new DbConnection();
	$cn->Open();

	$dbRec = new DbRecord();
	$dbRec->Connection = $cn;
	$query = "SELECT * FROM players WHERE uid='".$uid."'";
	$result = $dbRec->Get($query);
	
	$cn->Close();
	
	echo json_encode($result);
}
?>