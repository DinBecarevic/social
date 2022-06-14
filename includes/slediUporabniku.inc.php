<?php

if (isset($_POST['slediUporabniku-btn'])) {
    if($_SESSION['status'] =! 'banned') {
    session_start();
    require_once 'dbh.inc.php';

    $followerId = $_SESSION['S_userId'];
    $userId = mysqli_real_escape_string($conn, $_POST['user_id']);
    $komentar_id = mysqli_real_escape_string($conn, $_POST['komentar_id']);
    $url_username = mysqli_real_escape_string($conn, $_POST['url_username']);

    $sql = "INSERT INTO sledilci (uporabnik_id, sledilec_id, followed_date) VALUES (?, ?, CURRENT_TIMESTAMP)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../uporabnik.php?uporabnik=$url_username&error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $userId, $followerId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../uporabnik.php?uporabnik=$url_username&followed");
    exit();
    }
    else {
        header("location: ../profil.php?uporabnik_banned");
    }
}
else {
    header("location: ../social.php");
    exit();
}
