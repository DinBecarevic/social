<?php

if (isset($_POST['DodajPrijatelja-btn'])) {
    session_start();
    require_once 'dbh.inc.php';

    $userId = $_SESSION['S_userId'];
    $prijateljId = mysqli_real_escape_string($conn, $_POST['user_id']);
    $url_username = mysqli_real_escape_string($conn, $_POST['url_username']);

    $sql = "INSERT INTO prijatelji (id_user, id_friend, added_date) VALUES (?, ?, CURRENT_TIMESTAMP)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../uporabnik.php?uporabnik=$url_username&error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $userId, $prijateljId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../uporabnik.php?uporabnik=$url_username&dodan");
    exit();
}
else {
    header("location: ../social.php");
    exit();
}