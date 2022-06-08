<?php

if (isset($_POST['komentirajObjavo-btn'])) {

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $vsebina = mysqli_real_escape_string($conn, $_POST['komentar_vsebina']);
    $url = mysqli_real_escape_string($conn, $_POST['url']);

    if (empty($vsebina)) {
        header("location: ../komentiraj.php?id=$url&error=praznavsebina");
        exit();
    }
    KomentirajObjavo($conn, $vsebina, $url);
}
else {
    header("location: ../social.php?error=fail");
    exit();
}
