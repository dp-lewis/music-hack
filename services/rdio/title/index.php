<?php
include("../../../config.php");
require '../rdio.php';


$rdio = new Rdio(array($RDIO["apikey"], $RDIO["sharedsecret"]));

$artist = $rdio->call("search", array("query" => htmlspecialchars($_GET["title"]) . " " . htmlspecialchars($_GET["artist"]), "types" => "Track, Artist"));

//echo "" . $artist->result->results[0]->key . "";
$json = "{key: '" . $artist->result->results[0]->key . "'}";

if (isset($_GET["callback"])) {
	echo $_GET["callback"] . "(" . $json . ")";
} else {
	echo $json;
}
/*
$ian = $rdio->call("findUser", array("vanityName" => "ian"));
if ($ian->status == "ok") {
  print $ian->result->firstName." ".$ian->result->lastName."\n";
} else {
  print "ERROR: ".$ian->message."\n";
}
*/


?>