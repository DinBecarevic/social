<?php
echo "<p>serbus</p>";

if (isset($_POST['komentar_odstrani'])) {
    session_start();
    echo "<p>serbus2</p>";
    require_once 'dbh.inc.php';

    $userUsername = $_SESSION['S_userId'];
    $comment_id = $_POST['comment_id'];

    $sql = "DELETE FROM objave WHERE (id = ?) AND (uporabnik_id = ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../social.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $comment_id, $userUsername);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../social.php?objava-zbrisana");
    exit();
}