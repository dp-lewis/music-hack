<?php
	require_once("../SevenDigitalApi/SevenDigitalApi.php");
	require("../../../config.php");
	// Open connectio to the API	
	$api = new SevenDigitalApi();
	$api->ConsumerId = $SEVENDIGITAL["apikey"]; 
	$api->Country = "GB";
	$api->OutputType="json";
	
	$date = 19950101;

	if (isset($_GET["date"] )) {
	   $date = htmlspecialchars($_GET["date"]);	
	} 

	$json = $api->GetReleasesByDate($date - 10000, $date);

	if (isset($_GET["callback"])) {
		echo $_GET["callback"] . "(" . $json . ")";
	} else {
		echo $json;
	}
	
?>

