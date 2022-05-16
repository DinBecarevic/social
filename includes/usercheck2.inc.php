<?php

if (isset($_POST['username_id'])) {

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $username = mysqli_real_escape_string($conn, $_POST["username_id"]);
    echo $username;
    $email_query = "SELECT * FROM uporabniki WHERE username = '$username'";
    $email_query_run = mysqli_query($conn, $email_query);
    if(mysqli_num_rows($email_query_run) > 0) {
        echo " uporabniško ime je že uporabljeno*";
    }
}
else {
    header("location: ../index.php");
    exit();
}