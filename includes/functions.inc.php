<?php

function emptyInputSignup($username, $email, $pwd, $pwdRepeat) {
    $result;
    if (empty($username) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidUsername($username) {
    $result;
    if (!preg_match("/^((.{2,32})#\d{4})/", $username)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
    $result;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function userExists($conn, $username, $email) {
    $sql = "SELECT * FROM uporabniki WHERE username = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $username, $email, $pwd, $firstname, $lastname, $datumroj, $regija) {
    $sql = "INSERT INTO uporabniki (username, email, pwd, first_name, last_name, datum_roj, regija) VALUES (?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    $salt = "m8p#m,^(HYKw[Zv.[:htY_!jf~UTyEyMuGtj&Utrv]j%TYa@v)(.,sr8MXR9Nhw{";
    $salted = $pwd.$salt;
    $hashedPwd = password_hash($salted, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssssss", $username, $email, $hashedPwd, $firstname, $lastname, $datumroj, $regija);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if($regija == "Slovenija") {
        loginUser($conn, $username, $pwd);
    }
    else {
        loginUser($conn, $username, $pwd);
    }
    exit();
}

/* -----------------------------login-------------------------------------- */

function emptyInputLogin($username, $pwd) {
    $result;
    if (empty($username) || empty($pwd)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd) {
    $uidExists = userExists($conn, $username, $username);

    if ($uidExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $salt = "m8p#m,^(HYKw[Zv.[:htY_!jf~UTyEyMuGtj&Utrv]j%TYa@v)(.,sr8MXR9Nhw{";
    $salted = $pwd.$salt;
    $pwdHased = $uidExists["pwd"];
    $checkPwd = password_verify($salted, $pwdHased);

    if ($checkPwd === false) {
        header("location: ../index.php?error=wrongpass");
        exit();
    }
    else if ($checkPwd == true) {
        session_start();
        $_SESSION['S_userId'] = $uidExists["id"];
        $_SESSION['S_userUsername'] = $uidExists["username"];
        $_SESSION['S_userFirstName'] = $uidExists["first_name"];
        $_SESSION['S_userLastName'] = $uidExists["last_name"];
        $_SESSION['S_userEmail'] = $uidExists["email"];
        $_SESSION['S_userOpis'] = $uidExists["opis"];
        $_SESSION['S_userRegija'] = $uidExists["regija"];
        $_SESSION['S_userMesto'] = $uidExists["mesto_id"];
        $_SESSION['S_userPronouns'] = $uidExists["pronouns"];
        $_SESSION['S_userDatumRoj'] = $uidExists["datum_roj"];

        header("location: ../profile.php?logedin");
        exit();
    }
}