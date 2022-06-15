<?php

if (isset($_POST['komentar_like'])) {
    session_start();
    if($_SESSION['S_userStatus'] !== 'banned') {
    require_once 'dbh.inc.php';

    $userId = $_SESSION['S_userId'];
    $id_komentarja = mysqli_real_escape_string($conn, $_POST['komentar_id']);
    $id_objave = mysqli_real_escape_string($conn, $_POST['objava_id']);

    // gledamo če je uporabnik že vsecku ali ne
    $sql = "SELECT * FROM vsecki_komentarji WHERE (id_komentarja = ?) AND (id_uporabnika = ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../komentiraj.php?id=$id_objave&error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $id_komentarja, $userId);
    mysqli_stmt_execute($stmt);

    //dobimo podatke
    $resultData = mysqli_stmt_get_result($stmt);

    //če je uporabnik že vseckal zbrišemo všeček
    if ($row = mysqli_fetch_assoc($resultData)) {
        $sql = "DELETE FROM vsecki_komentarji WHERE (id_komentarja = ?) AND (id_uporabnika = ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../komentiraj.php?id=$id_objave&error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $id_komentarja, $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../komentiraj.php?id=$id_objave&vsecek_odstranjen");
        exit();
    }
    // če objava še ni bila ušečkana z strani prijavljenega uporabnika se vpiše nov všeček pod novim id-jem
    else {
        $result = false;
        $sql = "INSERT INTO vsecki_komentarji (id_komentarja, id_uporabnika, date_liked) VALUES (?, ?, CURRENT_TIMESTAMP)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../komentiraj.php?id=$id_objave&error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $id_komentarja, $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../komentiraj.php?id=$id_objave&objava-vseckana");
        exit();
    }

    mysqli_stmt_close($stmt);
    }
    else {
        header("location: ../profil.php?error=uporabnik_banned");
    }
}
else {
    header("location: ../social.php");
    exit();
}