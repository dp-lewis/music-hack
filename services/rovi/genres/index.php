<?php
include("../../../config.php");
require("../rovi.php");

$myRovi = new Rovi($ROVI['apikey'], $ROVI["sharedsecret"]);
$myRovi->genres();

?>
