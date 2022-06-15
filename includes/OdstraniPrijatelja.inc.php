<?php

if (isset($_POST['OdstraniPrijatelja-btn'])) {
    session_start();
    if($_SESSION['S_userStatus'] !== 'banned') {
    require_once 'dbh.inc.php';

    $userId = $_SESSION['S_userId'];
    $prijateljId = mysqli_real_escape_string($conn, $_POST['user_id']);
    $url_username = mysqli_real_escape_string($conn, $_POST['url_username']);

    $sql = "DELETE FROM prijatelji WHERE ((id_user = ?) AND (id_friend = ?)) OR ((id_user = ?) AND (id_friend = ?))";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../uporabnik.php?uporabnik=$url_username&error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $userId, $prijateljId, $prijateljId, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../uporabnik.php?uporabnik=$url_username&odstranjen");
    exit();
    }
    else {
        header("location: ../profil.php?error=uporabnik_banned");
    }
}
else {
    header("location: ../social.php");
    exit();
}