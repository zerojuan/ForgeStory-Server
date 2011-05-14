<?php
require './database.php';

if (isset($_POST["uid"])){
	
	$uid = $_POST["uid"];
	$name = $_POST["name"];
	$head = $_POST["head"];
	$body = $_POST["body"];
	$armor = $_POST["armor"];
	$weapon = $_POST["weapon"];
	
	$cn = new DbConnection();
	$cn->Open();

	$dbRec = new DbRecord();
	$dbRec->Connection = $cn;
	
	$dbRec->Update("UPDATE players SET username = '".$name."', head = '".$head."', body = '".$body."', armor = '".$armor."', weapon = '".$weapon."'
					WHERE uid = '".$uid."'");
	
	
	$cn->Close();
	
	echo $uid;
}
?>