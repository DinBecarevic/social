<?php
	session_start();
    include_once 'includes/cookiedata.inc.php';
    if (isset($_SESSION['status'])) {
        if ($_SESSION['status'] == 'banned') {
            $buttun_status = 'disabled';
        }
        else {
            $buttun_status = 'enabled';
        }
    }
?>
<!DOCTYPE html>
<html lang="sl">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/social.css">
    <link rel="stylesheet" type="text/css" href="css/uporabnik.css">
    <link rel="stylesheet" type="text/css" href="css/prijatelji.css">
    <link rel="stylesheet" type="text/css" href="css/pogovori.css">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">

	<title>Socialno omrežje</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@500&display=swap" rel="stylesheet">

    <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
</head>
<body>