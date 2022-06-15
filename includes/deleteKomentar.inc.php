<?php

if (isset($_POST['komentar_odstrani'])) {
    session_start();
    if($_SESSION['S_userStatus'] !== 'banned') {
    require_once 'dbh.inc.php';

    $userId = $_SESSION['S_userId'];
    $komentar_id = mysqli_real_escape_string($conn, $_POST['komentar_id']);
    $url = mysqli_real_escape_string($conn, $_POST['url']);

    if($_SESSION['is_admin'] == 1) {
        $sql = "DELETE FROM objave_komentarji WHERE (id = ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../komentiraj.php?id=$url&error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $komentar_id);
    }
    else {
        $sql = "DELETE FROM objave_komentarji WHERE (id = ?) AND (user_id = ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../komentiraj.php?id=$url&error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $komentar_id, $userId);
    }


    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../komentiraj.php?id=$url&komentar_zbrisan");
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