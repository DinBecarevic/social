<?php

# $serverName = "152.89.234.175";
# $dBUserName = "dinbecar_social";
# $dBPassword = "GeS€tjmghapd/420";
# $dBName = "dinbecar_social";

$serverName = "localhost";
$dBUserName = "root";
$dBPassword = "";
$dBName = "social";

$conn = mysqli_connect($serverName, $dBUserName, $dBPassword, $dBName);

if (!$conn) {
	die("Povezava ni uspela" . mysqli_connect_error());

}