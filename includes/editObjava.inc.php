<?php
if (isset($_POST['editObjava-btn'])) {

    session_start();
    include_once 'dbh.inc.php';

    $userId = $_SESSION['S_userId'];
    $comment_id = $_POST['objava_id'];
    $sporocilo = $_POST['new-objava'];

    $sql = "UPDATE objave SET vsebina = ?, update_date = CURRENT_TIMESTAMP, is_edited = is_edited + 1 WHERE (id = ?) AND (uporabnik_id = ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../social.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $sporocilo, $comment_id, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../social.php?objava-urejena");
    exit();
}
