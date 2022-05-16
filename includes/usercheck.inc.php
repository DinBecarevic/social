<?php

if (isset($_POST['email_id'])) {

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $email = mysqli_real_escape_string($conn, $_POST["email_id"]);
    echo $email;
    $email_query = "SELECT * FROM uporabniki WHERE email = '$email'";
    $email_query_run = mysqli_query($conn, $email_query);
    if(mysqli_num_rows($email_query_run) > 0) {
        echo " email je že uporabljen*";
    }
}
else {
    header("location: ../index.php");
    exit();
}