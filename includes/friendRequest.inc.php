<?php
// sprejem
if (isset($_POST['friend-accept-btn'])) {
    session_start();
    if($_SESSION['S_userStatus'] !== 'banned') {
        require_once 'dbh.inc.php';
        if (isset($_POST['friend-accept-btn'])) {
            $id = mysqli_real_escape_string($conn, $_POST['id']);

            $sql = "UPDATE prijatelji SET status = 'accepted' WHERE (id = ?);";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../prijatelji.php?error=stmtfailed");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("location: ../prijatelji.php?uporabnik_dodan");
            exit();
        }
        // zavrnitev
        else if (isset($_POST['friend-reject-btn'])) {
            $id = mysqli_real_escape_string($conn, $_POST['id']);

            $sql = "UPDATE prijatelji SET status = 'rejected' WHERE (id = ?);";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../prijatelji.php?error=stmtfailed");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("location: ../prijatelji.php?uporabnik_zavrnjen");
            exit();
        }
    }
    else {
        header("location: ../profil.php?error=uporabnik_banned");
    }
}
else {
    header("location: ../prijatelji.php");
    exit();
}