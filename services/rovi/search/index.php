<?php
include("../../../config.php");
require("../rovi.php");

$myRovi = new Rovi($ROVI['apikey'], $ROVI["sharedsecret"]);

$date = "19950101";

if (isset($_GET["date"] )) {
   $date = $_GET["date"];	
} 

if (isset($_GET["callback"])) {
	echo $_GET["callback"] . "(" . $myRovi->datesearch($date) . ")";
} else {
	"hi there";
	echo $myRovi->datesearch($date);
}
	

?>
