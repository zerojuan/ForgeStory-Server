<?php

if (isset($GLOBALS["HTTP_RAW_POST_DATA"]))
{
	// get bytearray
	$jpg = $GLOBALS["HTTP_RAW_POST_DATA"];

	// add headers for download dialog-box
	//header('Content-Type: image/jpeg');
	//header("Content-Disposition: attachment; filename=".$_GET['name']);
	//imagejpeg($jpg, 'simpletext.jpg');
	// Free up memory
	//imagedestroy($jpg);
	mkdir($_GET['folder'], 0777);
	//file_put_contents($_GET['folder'].'/'.$_GET['name'], $jpg, LOCK_EX);
	file_put_contents($_GET['name'], $jpg, LOCK_EX);
}

?>