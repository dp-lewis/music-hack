<?php
	require_once("../SevenDigitalApi/SevenDigitalApi.php");
	require("../../../config.php");
	// Open connectio to the API	
	$api = new SevenDigitalApi();
	$api->ConsumerId = $SEVENDIGITAL["apikey"]; 
	$api->Country = "GB";
	$api->OutputType="json";
	
	$date = 1;

	if (isset($_GET["id"] )) {
	   $id = $_GET["id"];	
	} 

	$json = $api->GetTracksByRelease($id);

	if (isset($_GET["callback"])) {
		echo $_GET["callback"] . "(" . $json . ")";
	} else {
		echo $json;
	}
	
?>

