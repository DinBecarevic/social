<?php

if (isset($_POST['sprememba-gesla-submit'])) {

    $old_pwd = $_POST['current-pwd'];
    $pwd = $_POST['new-pwd'];
    $pwd_repeat = $_POST['new-pwd-repeat'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputLogin($email, $pwd) !== false) {
        header("location: ../index.php?error=emptyinput");
        exit();
    }
    loginUser($conn, $email, $pwd);
}
else {
    header("location: ../index.php?error=fail");
    exit();
}