<?php

if (isset($_POST['sprememba-gesla-submit'])) {

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $old_pwd = mysqli_real_escape_string($conn, $_POST['current-pwd']);
    $pwd = mysqli_real_escape_string($conn, $_POST['new-pwd']);
    $pwdRepeat = mysqli_real_escape_string($conn, $_POST['new-pwd-repeat']);

    if (emptyInputChangePwd($old_pwd, $pwd, $pwdRepeat) !== false) {
        header("location: ../profil.php?error=emptyinput");
        exit();
    }
    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("location: ../profil.php?error=pwddontmatch");
        exit();
    }

    changePwd($conn, $old_pwd, $pwd);
}
else {
    header("location: ../profil.php?error=fail");
    exit();
}