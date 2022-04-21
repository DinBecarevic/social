<?php

if (isset($_POST['username'])) {

    require_once '../dbh.inc.php';
    require_once '../functions.inc.php';

    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $pwd = mysqli_real_escape_string($conn, $_POST["pwd"]);
    $pwdRepeat = mysqli_real_escape_string($conn, $_POST["pwdrepeat"]);
    $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
    $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
    $datumroj = mysqli_real_escape_string($conn, $_POST["datumroj"]);
    $regija = "Podravska";

    if (emptyInputSignup($username, $email, $pwd, $pwdRepeat) !== false) {
        header("location: ../../index.php?error=emptyinput");
        exit();
    }
    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("location: ../../index.php?error=pwddontmatch");
        exit();
    }
    if (userExists($conn, $username, $email) !== false) {
        header("location: ../../index.php?error=usernametaken");
        exit();
    }
    createUser($conn, $username, $email, $pwd, $firstname, $lastname, $datumroj, $regija);

}
else {
    header("location: ../index.php");
    exit();
}