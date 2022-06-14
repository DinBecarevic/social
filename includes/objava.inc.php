<?php

if (isset($_POST['objava-submit'])) {
    if($_SESSION['status'] =! 'banned') {
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $vsebina = mysqli_real_escape_string($conn, $_POST['objava-vsebina']);
    $regija = mysqli_real_escape_string($conn, $_POST['regija-objava']);
    $is_image = 0;

    if (empty($vsebina)) {
        header("location: ../social.php?error=praznavsebina");
        exit();
    }
    objaviObjavo($conn, $vsebina, $regija, $is_image);
    }
    else {
        header("location: ../profil.php?error=uporabnik_banned");
    }
}
else {
    header("location: ../social.php?error=fail");
    exit();
}
