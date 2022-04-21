<?php

$serverName = "localhost";
$dBUserName = "root";
$dBPassword = "";
$dBName = "social";

$conn = mysqli_connect($serverName, $dBUserName, $dBPassword, $dBName);

if (!$conn) {
	die("Povezava ni uspela" . mysqli_connect_error());

}