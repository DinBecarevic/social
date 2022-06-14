<?php

if (isset($_POST['osebni-submit'])) {
    if($_SESSION['status'] =! 'banned') {
        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
        $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
        $pronouns = mysqli_real_escape_string($conn, $_POST["pronouns"]);
        $datumroj = mysqli_real_escape_string($conn, $_POST["datumroj"]);
        $opis = mysqli_real_escape_string($conn, $_POST["opis"]);
        $regija = mysqli_real_escape_string($conn, $_POST["regija"]);
        $mesto = mysqli_real_escape_string($conn, $_POST["mesto"]);

        $old_email = $_SESSION['S_userEmail'];
        $old_username = $_SESSION['S_userUsername'];
        if (emptyInputEdit($username, $email) !== false) {
            header("location: ../index.php?error=emptyinput");
            exit();
        }
        if (userExistsProfile($conn, $username, $email, $old_username, $old_email) !== false) {
            header("location: ../profil.php?error=usernameoremailtaken");
            exit();
        }
        updateUser($conn, $username, $email, $firstname, $lastname, $pronouns, $datumroj, $opis, $regija, $mesto);
    }
    else {
        header("location: ../profil.php?error=uporabnik_banned");
    }
} else {
    header("location: ../profil.php");
    exit();
}