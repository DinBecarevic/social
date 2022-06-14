<?php

if (isset($_COOKIE['C_userEmail']) AND ($_COOKIE['C_userPwd'])) {
    require_once 'dbh.inc.php';

    $userUsername = $_COOKIE['C_userUsername'];

    $sql = "SELECT * FROM uporabniki WHERE username = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $userUsername);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    while ($row = $resultData->fetch_assoc()) {

        $_SESSION['S_userId'] =                 $row['id'];
        $_SESSION['S_userUsername'] =           $row['username'];
        $_SESSION['S_userFirstName'] =          $row['first_name'];
        $_SESSION['S_userLastName'] =           $row['last_name'];
        $_SESSION['S_userEmail'] =              $row['email'];
        $_SESSION['S_userOpis'] =               $row['opis'];
        $_SESSION['S_userRegija'] =             $row['regija'];
        $_SESSION['S_userMesto'] =              $row['mesto'];
        $_SESSION['S_userPronouns'] =           $row['pronouns'];
        $_SESSION['S_userDatumRoj'] =           $row['datum_roj'];

        $_SESSION['S_userProfileBanner'] =      $row['banner_dir'];
        $_SESSION['S_userProfileImg'] =         $row['img_dir'];

        $_SESSION['S_userRegistracija_date'] =  $row["registracija_date"];
        $_SESSION['S_userUpdate_date'] =        $row["update_date"];

        $_SESSION['status'] = $row["status_user"];

        if ($row["is_admin"] == 1) {
            $_SESSION['is_admin'] = $row["is_admin"];
        }
    }

    mysqli_stmt_close($stmt);
}
