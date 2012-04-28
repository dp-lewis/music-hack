<?php
include("../../../config.php");
require '../rdio.php';


$rdio = new Rdio(array($RDIO["apikey"], $RDIO["sharedsecret"]));

$artist = $rdio->call("search", array("query" => "Bobbi Humphrey", "types" => "Artist"));

print_r($artist->result->results[0]->key);

/*
$ian = $rdio->call("findUser", array("vanityName" => "ian"));
if ($ian->status == "ok") {
  print $ian->result->firstName." ".$ian->result->lastName."\n";
} else {
  print "ERROR: ".$ian->message."\n";
}
*/


?>