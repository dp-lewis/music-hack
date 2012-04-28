<?php
	require_once("../SevenDigitalApi/SevenDigitalApi.php");
	require("../../../config.php");
	// Open connectio to the API	
	$api = new SevenDigitalApi();
	$api->ConsumerId = $SEVENDIGITAL["apikey"]; 
	$api->Country = "AU";
	$api->OutputType="json";
	$json = $api->GetTrackMP3(htmlspecialchars($_GET['id']));

	if (isset($_GET["callback"])) {
		echo $_GET["callback"] . "(" . $json . ")";
	} else {
		echo $json;
	}
?>

