<?php
session_start();

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
        loginUser2($conn, $username, $pwd);
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
        header("location: ../index.php?error=wronglogin_login");
        exit();
    }

    $salt = "m8p#m,^(HYKw[Zv.[:htY_!jf~UTyEyMuGtj&Utrv]j%TYa@v)(.,sr8MXR9Nhw{";
    $salted = $pwd.$salt;
    $pwdHased = $uidExists["pwd"];
    $checkPwd = password_verify($salted, $pwdHased);

    if ($checkPwd === false) {
        header("location: ../index.php?error=wrongpass_login");
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

        $_SESSION['S_userProfileBanner'] = $uidExists["banner_dir"];
        $_SESSION['S_userProfileImg'] = $uidExists["img_dir"];

        header("location: ../profil.php?success=user_logged_in");
        exit();
    }
}
function loginUser2($conn, $username, $pwd) {
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

        $_SESSION['S_userProfileBanner'] = $uidExists["banner_dir"];
        $_SESSION['S_userProfileImg'] = $uidExists["img_dir"];

        header("location: ../../profil.php?success=user_logged_in");
        exit();
    }
}
/* -----------------------------profil-edit-------------------------------------- */
function emptyInputEdit($username, $email) {
    $result;
    if (empty($username) || empty($email)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function userExistsProfile($conn, $username, $email) {
    $oldusername = $_SESSION['S_userUsername'];
    $oldemail = $_SESSION['S_userEmail'];
    $sql = "SELECT * FROM uporabniki WHERE (username = ? OR email = ?) AND (username != ? OR email != ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profil.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $oldusername, $oldemail);
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

function updateUser($conn, $username, $email, $firstname, $lastname, $pronouns, $datumroj, $opis, $regija, $mesto) {

    $_SESSION['S_userUsername'] = $username;
    $_SESSION['S_userFirstName'] = $firstname;
    $_SESSION['S_userLastName'] = $lastname;
    $_SESSION['S_userEmail'] = $email;
    $_SESSION['S_userOpis'] = $opis;
    $_SESSION['S_userRegija'] = $regija;
    $_SESSION['S_userMesto'] = $mesto;
    $_SESSION['S_userPronouns'] = $pronouns;
    $_SESSION['S_userDatumRoj'] = $datumroj;

    $sql = "UPDATE uporabniki SET username = ?, email = ?, first_name = ?, last_name = ?, pronouns = ?, datum_roj = ?, opis = ?, regija = ?, mesto = ?, update_date = CURRENT_TIMESTAMP WHERE (id = ".$_SESSION['S_userId'].");";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profil.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssssss", $username, $email, $firstname, $lastname, $pronouns, $datumroj, $opis, $regija, $mesto);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../profil.php?success=user_updated");
    exit();
}
function emptyInputChangePwd($old_pwd, $pwd, $pwdRepeat) {
    $result;
    if (empty($old_pwd) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}
function changePwd($conn, $old_pwd, $pwd) {
    $username = $_SESSION['S_userUsername'];
    $uidExists = userExists($conn, $username, $username);

    $salt = "m8p#m,^(HYKw[Zv.[:htY_!jf~UTyEyMuGtj&Utrv]j%TYa@v)(.,sr8MXR9Nhw{";
    $salted = $old_pwd.$salt;
    $pwdHased = $uidExists["pwd"];
    $checkPwd = password_verify($salted, $pwdHased);

    if ($checkPwd === false) {
        header("location: ../profil.php?error=oldwrongpass");
        exit();
    }

    $sql = "UPDATE uporabniki SET pwd = ? WHERE id = ".$_SESSION['S_userId'].";";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profil.php?error=stmtfailed");
        exit();
    }

    $salt = "m8p#m,^(HYKw[Zv.[:htY_!jf~UTyEyMuGtj&Utrv]j%TYa@v)(.,sr8MXR9Nhw{";
    $salted = $pwd.$salt;
    $hashedPwd = password_hash($salted, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "s", $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../profil.php?success=pwdSpremenjen");
    exit();
}
function updateBanner($conn, $fileDestinationDatabase) {

    $_SESSION['S_userProfileBanner'] = $fileDestinationDatabase;

    $sql = "UPDATE uporabniki SET banner_dir = ? WHERE (id = ".$_SESSION['S_userId'].");";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profil.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $fileDestinationDatabase);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../profil.php?user_banner_updated");
    exit();
}
function updateIcon($conn, $fileDestinationDatabase) {

    $_SESSION['S_userProfileImg'] = $fileDestinationDatabase;

    $sql = "UPDATE uporabniki SET img_dir = ? WHERE (id = ".$_SESSION['S_userId'].");";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profil.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $fileDestinationDatabase);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../profil.php?user_icon_updated");
    exit();
}
function deleteAcc($conn, $choice) {
    $userId = $_SESSION['S_userId'];
    $sql = "DELETE FROM uporabniki WHERE id = ?";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profil.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: logout.inc.php?uporabnik_zbrisan");
    exit();
}

/* -----------------------------objave-------------------------------------- */

function objaviObjavo($conn, $vsebina, $regija, $is_image) {
    $uporabnik_id = $_SESSION['S_userId'];

    $sql = "INSERT INTO objave (uporabnik_id, vsebina, regija, is_image) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../social.php?error=stmtfailed");
        exit();
    }


    mysqli_stmt_bind_param($stmt, "ssss", $uporabnik_id, $vsebina, $regija, $is_image);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../social.php?objava-objavljena");
    exit();
}

function getComments($conn) {
    $sql = "SELECT id, uporabnik_id, vsebina, DATE_FORMAT(created_date,'%b %e, %Y | %H:%i'), regija, is_image, DATE_FORMAT(update_date,'%b %e, %Y | %H:%i'), is_edited FROM objave order by created_date DESC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $upo_id = $row['uporabnik_id'];
        $sql2 = "SELECT username, img_dir FROM uporabniki WHERE id='$upo_id'";
        $result2 = $conn->query($sql2);


        if ($row2 = $result2->fetch_assoc()) {
            $usr_img = $row2['img_dir'];
            $is_edited = $row['is_edited'];
            $refactored_date = $row["DATE_FORMAT(created_date,'%b %e, %Y | %H:%i')"];

            //preden izpišemo vsebino naredimo mysqli_real_escape_string in strip_tag da se znebimo borebitni nezačeleni vsebini...
            $vsebina = mysqli_real_escape_string($conn, htmlspecialchars($row['vsebina']));
            $vsebina = str_replace(array("\\\\r\\\\n","\\r\\n"),"<br>",$vsebina);

            echo "<div class='comment-box'>";
            echo   "<img class='objava-user-image' src='$usr_img'></img>";
            echo    "<div class='comment-possision'>";
            echo        "<span class='comment-info'>";
            echo            "<p class='username-color'>", $row2['username'], "</p>", '&nbsp;&nbsp;&nbsp;', $refactored_date."<br><br>";
            echo        "</span>";
            if ($is_edited > 0) {
                $edited_time = $row["DATE_FORMAT(update_date,'%b %e, %Y | %H:%i')"];
                echo    "<p class='oznaka-urejeno'><ion-icon name='bookmark'></ion-icon>urejeno...</p>";
                echo    "<p class='oznaka-urejeno2'>$edited_time</p>";
            }
            echo     "<p class='comment-paragraph'>";
            echo        $vsebina;
            echo    "</p>";
            echo    "</div>";
            echo    "<hr>";
            if (isset($_SESSION['S_userId'])) {
                if ($_SESSION['S_userId'] == $row['uporabnik_id']) {
                    echo "<form class='delete-comment-form' method='POST' action='includes/deleteObjava.inc.php'>";
                    echo    "<input type='hidden' name='comment_id' value='".$row['id']."'>
                            <button class='delete-objava-btn' type='submit' name='komentar_odstrani'>Odstrani</button>
                        </form>
                        <!-- ----------------------------------------------------------------- -->
                    	<form class='edit-comment-form' method='POST' action='editObjava.php'>
                            <input type='hidden' name='id' value='".$row['id']."'>
                            <input type='hidden' name='sporocila' value='".$row['vsebina']."'>
                            <button class='edit-objava-btn' name='komentar_edit'>Uredi</button>
                        </form>";
               }
            }
            echo "<div class='like-form-div'><form class='like-comment-form' method='POST' action='includes/likeObjava.inc.php'>";
            echo    "<input type='hidden' name='comment_id' value='".$row['id']."'>";

//            dobimo podatke o vsecku da vidimo ce si ze lajku :D
            $id_objave = $row['id'];
            $userId = $_SESSION['S_userId'];

            $sql3 = "SELECT * FROM vsecki WHERE (id_objave = ?) AND (id_uporabnika = ?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql3)) {
                header("location: ../social.php?error=stmtfailed");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "ss", $id_objave, $userId);
            mysqli_stmt_execute($stmt);

            //dobimo podatke
            $resultData3 = mysqli_stmt_get_result($stmt);

            //če je uporabnik že vseckal je vsecek vizualno polen...
            if ($row = mysqli_fetch_assoc($resultData3)) {
                echo "<button class='like-objava-btn' type='submit' name='komentar_like'><ion-icon name='heart'></ion-icon></button>";
            }
            //če je uporabnik že vseckal je vsecek vizualno prazen...
            else {
                echo "<button class='like-objava-btn' type='submit' name='komentar_like'><ion-icon name='heart-outline'></ion-icon></button>";
            }
            mysqli_stmt_close($stmt);

            //--------------------------------------------------------------------------------
            // dobimo podatke o številu všečkov
            $sql4 = "SELECT COUNT(*) FROM vsecki WHERE (id_objave = ?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql4)) {
                header("location: ../social.php?error=stmtfailed");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "s", $id_objave);
            mysqli_stmt_execute($stmt);

            //dobimo podatke
            $resultData4 = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($resultData4)) {
                $st_vseckov = $row['COUNT(*)'];
            }
            mysqli_stmt_close($stmt);

            echo "      </form>
                        <span class='st_vsekov'>$st_vseckov</span>
                    </div>
                    <div class='comment-form-div'>
                        <a href='../social/komentiraj.php?id=$id_objave'><button class='comment-objava-btn'><ion-icon name='chatbox-outline'></ion-icon></button></a>
                    </div>";
            echo "</div>";
        }


    }
}


function getComment($conn, $objava_id) {
    $sql = "SELECT id, uporabnik_id, vsebina, DATE_FORMAT(created_date,'%b %e, %Y | %H:%i'), regija, is_image, DATE_FORMAT(update_date,'%b %e, %Y | %H:%i'), is_edited FROM objave WHERE id = ? ORDER BY created_date DESC ";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: social.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $objava_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    while ($row = $result->fetch_assoc()) {
        $upo_id = $row['uporabnik_id'];
        $sql2 = "SELECT username, img_dir FROM uporabniki WHERE id='$upo_id'";
        $result2 = $conn->query($sql2);


        if ($row2 = $result2->fetch_assoc()) {
            $usr_img = $row2['img_dir'];
            $is_edited = $row['is_edited'];
            $refactored_date = $row["DATE_FORMAT(created_date,'%b %e, %Y | %H:%i')"];

            //preden izpišemo vsebino naredimo mysqli_real_escape_string in strip_tag da se znebimo borebitni nezačeleni vsebini...
            $vsebina = mysqli_real_escape_string($conn, htmlspecialchars($row['vsebina']));
            $vsebina = str_replace(array("\\\\r\\\\n","\\r\\n"),"<br>",$vsebina);


            echo "<div id='objava-box'>";
            echo   "<img class='objava-user-image' src='$usr_img'></img>";
            echo    "<div class='comment-possision'>";
            echo        "<span class='comment-info'>";
            echo            "<p class='username-color'>", $row2['username'], "</p>", '&nbsp;&nbsp;&nbsp;', $refactored_date."<br><br>";
            echo        "</span>";
            if ($is_edited > 0) {
                $edited_time = $row["DATE_FORMAT(update_date,'%b %e, %Y | %H:%i')"];
                echo    "<p class='oznaka-urejeno'><ion-icon name='bookmark'></ion-icon>urejeno...</p>";
                echo    "<p class='oznaka-urejeno2'>$edited_time</p>";
            }
            echo     "<p class='comment-paragraph-edit'>";
            echo        $vsebina;
            echo    "</p>";
            echo    "</div>";

            echo "</div>";
        }


    }
}


