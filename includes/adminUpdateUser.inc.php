<?php

if (isset($_POST['update-upo-btn'])) {

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $id = mysqli_real_escape_string($conn, $_POST["id_u"]);
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $firstname = mysqli_real_escape_string($conn, $_POST["first_name"]);
    $lastname = mysqli_real_escape_string($conn, $_POST["lastname_name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $pwd = mysqli_real_escape_string($conn, $_POST["pass"]);
    $datumroj = mysqli_real_escape_string($conn, $_POST["datum_roj"]);
    $datum_reg = mysqli_real_escape_string($conn, $_POST["datum_reg"]);
    $opis = mysqli_real_escape_string($conn, $_POST["opis"]);
    $img_dir = mysqli_real_escape_string($conn, $_POST["img_dir"]);
    $banner_dir = mysqli_real_escape_string($conn, $_POST["banner_dir"]);
    $pronouns = mysqli_real_escape_string($conn, $_POST["pronouns"]);
    $regija = mysqli_real_escape_string($conn, $_POST["Regija"]);
    $mesto = mysqli_real_escape_string($conn, $_POST["Mesto"]);
    $status = mysqli_real_escape_string($conn, $_POST["Status"]);
    $is_admin = mysqli_real_escape_string($conn, $_POST["is_admin"]);

    $old_username = mysqli_real_escape_string($conn, $_POST["old_username"]);
    $old_email = mysqli_real_escape_string($conn, $_POST["old_email"]);

    $opis = mysqli_real_escape_string($conn, htmlspecialchars($opis));
    $opis = str_replace(array("\\\\r\\\\n","\\r\\n")," ",$opis);

    if (emptyInputEdit($username, $email) !== false) {
        header("location: ../admin.php?error=emptyinput");
        exit();
    }
    if (userExistsProfile($conn, $username, $email, $old_username, $old_email) !== false) {
        header("location: ../admin.php?error=usernameoremailtaken");
        exit();
    }

    $sql = "SELECT pwd FROM uporabniki WHERE username = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultDataP = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_array($resultDataP)) {
        $data_pwd = $row['pwd'];
    }
    if ($pwd == $data_pwd){
        $hashedPwd = $pwd;
    }
    else {
        $salt = "m8p#m,^(HYKw[Zv.[:htY_!jf~UTyEyMuGtj&Utrv]j%TYa@v)(.,sr8MXR9Nhw{";
        $salted = $pwd.$salt;
        $hashedPwd = password_hash($salted, PASSWORD_DEFAULT);
    }



    $sql = "UPDATE uporabniki SET pwd = ?, username = ?, first_name = ?, last_name = ?, email = ?, registracija_date = ?, update_date = CURRENT_TIMESTAMP, opis = ?, img_dir = ?, banner_dir = ?, regija = ?, mesto = ?, pronouns = ?, datum_roj = ?, status_user = ?, is_admin = ? WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin.php?error=stmtfailedeeee");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssssssssssssssss", $hashedPwd, $username, $firstname, $lastname, $email, $datum_reg, $opis, $img_dir, $banner_dir, $regija, $mesto, $pronouns, $datumroj, $status, $is_admin, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../admin.php?username=$username&isci-upo-btn=&uporabnik_posodobljen");
    exit();
}
else {
    header("location: ../admin.php");
    exit();
}