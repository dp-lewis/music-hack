<?php
include("../../../config.php");
require '../rdio.php';


$rdio = new Rdio(array($RDIO["apikey"], $RDIO["sharedsecret"]));

$artist = $rdio->call("getPlaybackToken", array("domain" => "www.hackdays.com"));

print_r($artist);

/*

getPlaybackToken
$ian = $rdio->call("findUser", array("vanityName" => "ian"));
if ($ian->status == "ok") {
  print $ian->result->firstName." ".$ian->result->lastName."\n";
} else {
  print "ERROR: ".$ian->message."\n";
}
*/


?>