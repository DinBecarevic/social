<?php
if (isset($_POST['submit_login'])) {

        $email = $_POST['email'];
        $pwd = $_POST['pass'];

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
