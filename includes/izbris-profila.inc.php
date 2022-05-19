<?php

if (isset($_POST['izbris-profila-submit'])) {

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $choice = mysqli_real_escape_string($conn, $_POST['izbris-radio-select']);

    if($choice == 'yes') {
        deleteAcc($conn, $choice);
    }
    else {
        header("location: ../profile.php?error=selected_ne");
        exit();
    }
}
else {
    header("location: ../profile.php?error=fail");
    exit();
}