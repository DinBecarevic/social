<?php

if (isset($_POST['izbris-profila-submit'])) {
    session_start();
    if($_SESSION['S_userStatus'] !== 'banned') {
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $choice = mysqli_real_escape_string($conn, $_POST['izbris-radio-select']);

    if($choice == 'yes') {
        deleteAcc($conn, $choice);
    }
    else {
        header("location: ../profil.php?success=selected_ne");
        exit();
    }
    }
    else {
        header("location: ../profil.php?error=uporabnik_banned");
    }
}
else {
    header("location: ../profil.php?error=fail");
    exit();
}