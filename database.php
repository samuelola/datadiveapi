<?php
$servername = "localhost";
$username= "daggrega_datadive_api";
$password = "#?,+WxNCXW@@";
$db="daggrega_datadive_api";

$conn = mysqli_connect($servername, $username, $password,$db);

// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
  }


?>

