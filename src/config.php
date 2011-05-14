<?php

$appId = "@appId@";
$secret = "@appSecret@";

$httpString = "http://";

if ($_SERVER['HTTPS'] == "on") {
	$httpString = "https://";
}

$redirectURL = $httpString."@redirectURL@";
$baseDirectory = $httpString."@baseDirectory@";
	
$mainSWF = "@mainSWF@";

$dbUsername = "@dbUsername@";
$dbPassword = "@dbPassword@";
$dbName = "@dbName@";
?>