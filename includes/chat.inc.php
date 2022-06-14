<?php

if (isset($_POST['chat-input-btn'])) {
    if($_SESSION['status'] =! 'banned') {
        session_start();
        require_once 'dbh.inc.php';
        $S_userID = $_SESSION['S_userId'];
        $id_prijateljstva = mysqli_real_escape_string($conn, $_POST['id_prijateljstva']);

        getIdOfUsers($conn, $id_prijateljstva);

        global $id_user;
        global $id_friend;
        if ($S_userID != $id_user) {
            if ($S_userID != $id_friend) {
                header("location: ../chat.php?id=$id_prijateljstva&error=niprijateljstva");
                return 0;
            }
        }
        $message = mysqli_real_escape_string($conn, $_POST['chat-textarea']);

        $sql = "INSERT INTO messages (sender_id, message, message_date, id_prijateljstva) VALUES (?,?, CURRENT_TIMESTAMP, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../chat.php?id=$id_prijateljstva&error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sss", $S_userID, $message, $id_prijateljstva);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../chat.php?id=$id_prijateljstva&objavljeno");
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

function getIdOfUsers($conn, $id_prijateljstva) {
    $sql = "SELECT id_user, id_friend FROM prijatelji WHERE (id = ?) AND (status = 'accepted')";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: home.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id_prijateljstva);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_array($resultData)){
        global $id_user;
        global $id_friend;
        $id_user = $row['id_user'];
        $id_friend = $row['id_friend'];
    }
}