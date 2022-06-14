<?php
echo "<p>serbus</p>";

global $url;
if (isset($_POST['komentar_odstrani'])) {
    if($_SESSION['status'] = 'banned') {
        header("location: ../profil.php?error=uporabnik_banned");
    }
    else {
        session_start();
        require_once 'dbh.inc.php';

        $userUsername = $_SESSION['S_userId'];
        $comment_id = mysqli_real_escape_string($conn, $_POST['comment_id']);
        $url = mysqli_real_escape_string($conn, $_POST['back_url']);
        if ($url == "editObjava.php") {
            $url = "social.php";
        } else if (strpos($url, "uporabnik.php?uporabnik=") !== false) {
            $url = $url . "&";
        }
        if ($_SESSION['is_admin'] == 1) {
            $sql = "DELETE FROM objave WHERE (id = ?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../$url?error=stmtfailed");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "s", $comment_id);
        } else {
            $sql = "DELETE FROM objave WHERE (id = ?) AND (uporabnik_id = ?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../$url?error=stmtfailed");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "ss", $comment_id, $userUsername);
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../$url?objava-zbrisana");
        exit();
    }
}
else {
    header("location: ../social.php");
    exit();
}