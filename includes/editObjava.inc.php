<?php
if (isset($_POST['editObjava-btn'])) {
    session_start();
    if($_SESSION['S_userStatus'] !== 'banned') {
        include_once 'dbh.inc.php';

        $userId = $_SESSION['S_userId'];
        $comment_id = mysqli_real_escape_string($conn, $_POST['objava_id']);
        $sporocilo = mysqli_real_escape_string($conn, $_POST['new-objava']);
        $url = $_POST['back_url'];


        if($_SESSION['is_admin'] == 1) {
            $sql = "UPDATE objave SET vsebina = ?, update_date = CURRENT_TIMESTAMP, is_edited = is_edited + 1 WHERE (id = ?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../$url?error=stmtfailed");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "ss", $sporocilo, $comment_id);
        }
        else {
            $sql = "UPDATE objave SET vsebina = ?, update_date = CURRENT_TIMESTAMP, is_edited = is_edited + 1 WHERE (id = ?) AND (uporabnik_id = ?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../$url?error=stmtfailed");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "sss", $sporocilo, $comment_id, $userId);
        }
    }
    else {
        header("location: ../profil.php?error=uporabnik_banned");
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../$url?objava-urejena");
    echo $url;
    exit();
}
else {
    header("location: ../social.php");
    exit();
}
