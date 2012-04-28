<?php
include("../../../config.php");
require("../rovi.php");

$myRovi = new Rovi($ROVI['apikey'], $ROVI["sharedsecret"]);

$from = "19950101";
$to = "19960101";

if (isset($_GET["from"] )) {
   $from = htmlspecialchars($_GET["from"]);	
} 

if (isset($_GET["to"] )) {
   $to = htmlspecialchars($_GET["to"]);	
}

if (isset($_GET["callback"])) {
	echo $_GET["callback"] . "(" . $myRovi->datesearch($from, $to) . ")";
} else {
	echo $myRovi->datesearch($from, $to);
}
	

?>
