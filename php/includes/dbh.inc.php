<?php

$servername = "********";
$dBUsername = "********";
$dBPassword = "********";
$dBName = "proftalk";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if(!$conn){
  die("connection failed: ".mysqli_connect_error());
}
