<?php

if (isset($_POST['UnSlediUporabniku-btn'])) {
    session_start();
    if($_SESSION['S_userStatus'] !== 'banned') {
    require_once 'dbh.inc.php';

    $followerId = $_SESSION['S_userId'];
    $userId = mysqli_real_escape_string($conn, $_POST['user_id']);
    $url_username = mysqli_real_escape_string($conn, $_POST['url_username']);

    $sql = "DELETE FROM sledilci WHERE (uporabnik_id = ?) AND (sledilec_id = ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../uporabnik.php?uporabnik=$url_username&error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $userId, $followerId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../uporabnik.php?uporabnik=$url_username&unfollowed");
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
