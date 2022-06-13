<?php

if (isset($_POST['komentar_like'])) {
    session_start();
    require_once 'dbh.inc.php';

    $userId = $_SESSION['S_userId'];
    $id_objave = mysqli_real_escape_string($conn, $_POST['comment_id']);
    $url_file = mysqli_real_escape_string($conn, $_POST['url_file']);

    // gledamo če je uporabnik že vsecku ali ne
    $sql = "SELECT * FROM vsecki WHERE (id_objave = ?) AND (id_uporabnika = ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../$url_file?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $id_objave, $userId);
    mysqli_stmt_execute($stmt);

    //dobimo podatke
    $resultData = mysqli_stmt_get_result($stmt);

    //če je uporabnik že vseckal zbrišemo všeček
    if ($row = mysqli_fetch_assoc($resultData)) {
        $sql = "DELETE FROM vsecki WHERE (id_objave = ?) AND (id_uporabnika = ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../$url_file?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $id_objave, $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../$url_file?vsecek_odstranjen");
        exit();
    }
    // če objava še ni bila ušečkana z strani prijavljenega uporabnika se vpiše nov všeček pod novim id-jem
    else {
        $result = false;
        $sql = "INSERT INTO vsecki (id_objave, id_uporabnika, date_liked) VALUES (?, ?, CURRENT_TIMESTAMP)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../$url_file?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $id_objave, $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../$url_file?objava-vseckana");
        exit()  ;
    }

    mysqli_stmt_close($stmt);
}
else {
    header("location: ../social.php");
    exit();
}