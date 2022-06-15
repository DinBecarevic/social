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
        $_SESSION['S_userId'] =                 $uidExists["id"];
        $_SESSION['S_userUsername'] =           $uidExists["username"];
        $_SESSION['S_userFirstName'] =          $uidExists["first_name"];
        $_SESSION['S_userLastName'] =           $uidExists["last_name"];
        $_SESSION['S_userEmail'] =              $uidExists["email"];
        $_SESSION['S_userOpis'] =               $uidExists["opis"];
        $_SESSION['S_userRegija'] =             $uidExists["regija"];
        $_SESSION['S_userMesto'] =              $uidExists["mesto"];
        $_SESSION['S_userPronouns'] =           $uidExists["pronouns"];
        $_SESSION['S_userDatumRoj'] =           $uidExists["datum_roj"];

        $_SESSION['S_userProfileBanner'] =      $uidExists["banner_dir"];
        $_SESSION['S_userProfileImg'] =         $uidExists["img_dir"];

        $_SESSION['S_userRegistracija_date'] =  $uidExists["registracija_date"];
        $_SESSION['S_userUpdate_date'] =        $uidExists["update_date"];

        $_SESSION['S_userStatus'] = $uidExists["status_user"];
        $_SESSION['is_admin'] = $uidExists["is_admin"];

        // cookies
        $expiration = time() + (7 * 24 * 60 * 60); // 1 teden

        setcookie('C_userUsername', $uidExists["username"], $expiration, "/");
        setcookie('C_userEmail', $uidExists["email"], $expiration, "/");
        setcookie('C_userPwd', $uidExists["pwd"], $expiration, "/");


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
        $_SESSION['S_userId'] =                 $uidExists["id"];
        $_SESSION['S_userUsername'] =           $uidExists["username"];
        $_SESSION['S_userFirstName'] =          $uidExists["first_name"];
        $_SESSION['S_userLastName'] =           $uidExists["last_name"];
        $_SESSION['S_userEmail'] =              $uidExists["email"];
        $_SESSION['S_userOpis'] =               $uidExists["opis"];
        $_SESSION['S_userRegija'] =             $uidExists["regija"];
        $_SESSION['S_userMesto'] =              $uidExists["mesto"];
        $_SESSION['S_userPronouns'] =           $uidExists["pronouns"];
        $_SESSION['S_userDatumRoj'] =           $uidExists["datum_roj"];

        $_SESSION['S_userProfileBanner'] =      $uidExists["banner_dir"];
        $_SESSION['S_userProfileImg'] =         $uidExists["img_dir"];

        $_SESSION['S_userRegistracija_date'] =  $uidExists["registracija_date"];
        $_SESSION['S_userUpdate_date'] =        $uidExists["update_date"];

        $_SESSION['S_userStatus'] = $uidExists["status_user"];
        $_SESSION['is_admin'] = $uidExists["is_admin"];

        // cookies
        $expiration = time() + (7 * 24 * 60 * 60); // 1 teden

        setcookie('C_userUsername', $uidExists["username"], $expiration, "/");
        setcookie('C_userEmail', $uidExists["email"], $expiration, "/");
        setcookie('C_userPwd', $uidExists["pwd"], $expiration, "/");

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

function userExistsProfile($conn, $username, $email, $old_username, $old_email) {
    $oldusername = $_SESSION['S_userUsername'];
    $oldemail = $_SESSION['S_userEmail'];
    if ($_SESSION['is_admin'] == 1) {
        $oldusername = $old_username;
        $oldemail = $old_email;
    }
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
    //dobim ime datoteke v kateri se nahajam zaradi tega ker to funkcijo uporabljam večkrat in da vem kam morem redrectat v headeru :D
    $current_url_path = "$_SERVER[SCRIPT_NAME]";
    $break_url = explode('/', $current_url_path);
    $pfile = $break_url[count($break_url) - 1];

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
            $objava_uporabnik_username = $row2['username'];

            //preden izpišemo vsebino naredimo mysqli_real_escape_string in strip_tag da se znebimo borebitni nezačeleni vsebini...
            $vsebina = mysqli_real_escape_string($conn, htmlspecialchars($row['vsebina']));
            $vsebina = str_replace(array("\\\\r\\\\n","\\r\\n"),"<br>",$vsebina);

            echo "<div class='comment-box'>";
            echo   "<img class='objava-user-image' src='$usr_img'></img>";
            echo    "<div class='comment-possision'>";
            echo        "<span class='comment-info'>";
            echo            "<p class='username-color'><a href='uporabnik.php?uporabnik=$objava_uporabnik_username'>$objava_uporabnik_username</a></p>", '&nbsp;&nbsp;&nbsp;', $refactored_date."<br><br>";
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
                if (($_SESSION['S_userId'] == $row['uporabnik_id']) or ($_SESSION['is_admin'] == 1)) {
                    echo "<form class='delete-comment-form' method='POST' action='includes/deleteObjava.inc.php'>";
                    echo    "<input type='hidden' name='comment_id' value='".$row['id']."'>
                             <input type='hidden' name='back_url' value='$pfile'>
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
            echo    "<input type='hidden' name='url_file' value='$pfile'>";

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
                        <a href='komentiraj.php?id=$id_objave'><button class='comment-objava-btn'><ion-icon name='chatbox-outline'></ion-icon></button></a>
                    </div>";
            echo "</div>";
        }


    }
}


function getComment($conn, $objava_id) {
    //dobim ime datoteke v kateri se nahajam zaradi tega ker to funkcijo uporabljam večkrat in da vem kam morem redrectat v headeru :D
    $current_url_path = "$_SERVER[REQUEST_URI]";
    $break_url = explode('/', $current_url_path);
    $pfile = $break_url[count($break_url) - 1];

    $sql = "SELECT id, uporabnik_id, vsebina, DATE_FORMAT(created_date,'%b %e, %Y | %H:%i'), regija, is_image, DATE_FORMAT(update_date,'%b %e, %Y | %H:%i'), is_edited FROM objave WHERE id = ? ORDER BY created_date DESC ";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../social.php?error=stmtfailed");
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
            $objava_uporabnik_username = $row2['username'];
            //preden izpišemo vsebino naredimo mysqli_real_escape_string in strip_tag da se znebimo borebitni nezačeleni vsebini...
            $vsebina = mysqli_real_escape_string($conn, htmlspecialchars($row['vsebina']));
            $vsebina = str_replace(array("\\\\r\\\\n","\\r\\n"),"<br>",$vsebina);


            echo "<div id='objava-box'>";
            echo   "<img class='objava-user-image' src='$usr_img'></img>";
            echo    "<div class='comment-possision'>";
            echo        "<span class='comment-info'>";
            echo            "<p class='username-color'><a href='uporabnik.php?uporabnik=$objava_uporabnik_username'>$objava_uporabnik_username</a></p>", '&nbsp;&nbsp;&nbsp;', $refactored_date."<br><br>";
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
            if (isset($_SESSION['S_userId'])) {
                if (($_SESSION['S_userId'] == $row['uporabnik_id']) or ($_SESSION['is_admin'] == 1)) {
                    echo "<form class='delete-comment-form' method='POST' action='includes/deleteObjava.inc.php'>";
                    echo    "<input type='hidden' name='comment_id' value='".$row['id']."'>
                            <input type='hidden' name='back_url' value='$pfile'>
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

            if ($pfile !== 'editObjava.php') {

                echo "<div class='like-form-div'><form class='like-comment-form' method='POST' action='includes/likeObjava.inc.php'>";
                echo "<input type='hidden' name='comment_id' value='" . $row['id'] . "'>";
                echo "<input type='hidden' name='url_file' value='$pfile'>";
            }
//              dobimo podatke o vsecku da vidimo ce si ze lajku :D
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
                if ($pfile !== 'editObjava.php') {
                    if ($row = mysqli_fetch_assoc($resultData3)) {
                        echo "<button class='like-objava-btn' type='submit' name='komentar_like'><ion-icon name='heart'></ion-icon></button>";
                    }
                    //če je uporabnik že vseckal je vsecek vizualno prazen...
                    else {
                        echo "<button class='like-objava-btn' type='submit' name='komentar_like'><ion-icon name='heart-outline'></ion-icon></button>";
                    }
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

                echo "      </form>";
                if ($pfile !== 'editObjava.php') {
                            echo "<span class='st_vsekov'>$st_vseckov</span>";
                    }
                        echo "</div>";

                    echo "<div class='comment-form-div'>
                        <a href='komentiraj.php?id=$id_objave'><button class='comment-objava-btn'><ion-icon name='chatbox-outline'></ion-icon></button></a>
                    </div>";
            echo "</div>";
        }


    }
}
// -----------------------------------Objava komentarji-----------------------------------

function getComentKomentarje($conn, $objava_id)
{
    $sql = "SELECT id, objava_id, user_id, vsebina, DATE_FORMAT(created_date,'%b %e, %Y | %H:%i') FROM objave_komentarji WHERE objava_id = ? ORDER BY created_date DESC ";

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
        $upo_id = $row['user_id'];
        $sql2 = "SELECT username, img_dir FROM uporabniki WHERE id='$upo_id'";
        $result2 = $conn->query($sql2);


        if ($row2 = $result2->fetch_assoc()) {
            $usr_img = $row2['img_dir'];
            $refactored_date = $row["DATE_FORMAT(created_date,'%b %e, %Y | %H:%i')"];

            //preden izpišemo vsebino naredimo mysqli_real_escape_string in strip_tag da se znebimo borebitni nezačeleni vsebini...
            $vsebina = mysqli_real_escape_string($conn, htmlspecialchars($row['vsebina']));
            $vsebina = str_replace(array("\\\\r\\\\n", "\\r\\n"), "<br>", $vsebina);
            $objava_uporabnik_username = $row2['username'];
            echo "<div class='komentar-box'>";
            echo "<img class='komentar-user-image' src='$usr_img'></img>";
            echo "<div class='comment-possision'>";
            echo "<span class='comment-info'>";
            echo "<p class='username-color'><a href='uporabnik.php?uporabnik=$objava_uporabnik_username'>$objava_uporabnik_username</a></p>", '&nbsp;&nbsp;&nbsp;', $refactored_date . "<br><br>";
            echo "</span>";
            echo "<p class='comment-paragraph'>";
            echo $vsebina;
            echo "</p>";
            echo "</div><hr class='komentar-small-hr'>";
            if (isset($_SESSION['S_userId'])) {
                if (($_SESSION['S_userId'] == $row['user_id']) or ($_SESSION['is_admin'] == 1))  {
                    echo "<form class='delete-comment-form' method='POST' action='includes/deleteKomentar.inc.php'>";
                    echo "<input type='hidden' name='komentar_id' value='" . $row['id'] . "'>
                          <input type='hidden' name='url' value='".$row['objava_id']."'>
                            <button class='delete-objava-btn' type='submit' name='komentar_odstrani'>Odstrani</button>
                        </form>";
                }
            }


            echo "<div class='like-form-div'><form class='like-comment-form' method='POST' action='includes/likeObjavaKomantar.inc.php'>";
            echo    "<input type='hidden' name='komentar_id' value='".$row['id']."'>";
            echo    "<input type='hidden' name='objava_id' value='".$row['objava_id']."'>";

//            dobimo podatke o vsecku da vidimo ce si ze lajku :D
            $id_komentarja = $row['id'];
            $id_objave = $row['objava_id'];
            $userId = $_SESSION['S_userId'];

            $sql3 = "SELECT * FROM vsecki_komentarji WHERE (id_komentarja = ?) AND (id_uporabnika = ?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql3)) {
                header("location: ../social.php?error=stmtfailed");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "ss", $id_komentarja, $userId);
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

            //--------------------------$resultData3 = mysqli_stmt_get_result($stmt);------------------------------------------------------
            // dobimo podatke o številu všečkov
            $sql4 = "SELECT COUNT(*) FROM vsecki_komentarji WHERE (id_komentarja = ?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql4)) {
                header("location: ../social.php?error=stmtfailed");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "s", $id_komentarja);
            mysqli_stmt_execute($stmt);

            //dobimo podatke
            $resultData4 = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($resultData4)) {
                $st_vseckov = $row['COUNT(*)'];
            }
            mysqli_stmt_close($stmt);

            echo "      </form>
                        <span class='st_vsekov'>$st_vseckov</span>
                    </div>";
            echo "</div>";
        }
    }
}

function KomentirajObjavo($conn, $vsebina, $url) {
    $uporabnik_id = $_SESSION['S_userId'];

    $sql = "INSERT INTO objave_komentarji (objava_id, user_id, vsebina, created_date) VALUES (?, ?, ?, CURRENT_TIMESTAMP);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../komentiraj.php?id=$url&error=stmtfailed");
        exit();
    }


    mysqli_stmt_bind_param($stmt, "sss", $url, $uporabnik_id, $vsebina);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../komentiraj.php?id=$url&objava-objavljena");
    exit();
}

function getUserProfile($conn, $user_username)
{
    $sql = "SELECT * FROM uporabniki WHERE username = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../home.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $user_username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $username = $row['username'];
        $firstname = $row['first_name'];
        $lastname = $row['last_name'];
        $email = $row['email'];
        $registracija_date = $row['registracija_date'];
        $opis = $row['opis'];
        $img_dir = $row['img_dir'];
        $banner_dir = $row['banner_dir'];
        $regija = $row['regija'];
        $mesto = $row['mesto'];
        $pronouns = $row['pronouns'];
        $datum_roj = $row['datum_roj'];
        $usernamelength = strlen($username);

        echo "
        <div class='uporabnik-card'>
            <div class='uporabnik-imgBx'>
                <img src='$img_dir' alt='uporabnik_profile-img'>
            </div>
            <div class='uporabnik-content'>
                <div class='uporabnik-details'>";
        if ($usernamelength < 30) {
            echo "<h2>$username<br><span>$firstname $lastname</span></h2>";
        }
        else {
            $length = $usernamelength - 28;
            $username2 = substr_replace($username, "", -$length);

            echo "    <h2 id='uporabnikH2-longusername'>$username2...<br><span>$firstname $lastname</span></h2>";
            echo "    <p id='uporabnikp-longusername-hidden'>$username</p>";
        }
                    echo "<div class='uporabnik-data'>
                        <h3>";stevlioObjav($conn, $id);echo"<br><span>Objav</span></h3>
                        <h3>";stevliovseckov($conn, $id);echo"<br><span>Všečkov</span></h3>
                        <h3>";stevlioSledilcev($conn, $id);echo"<br><span>Sledilcev</span></h3>
                        <h3>";stevlioSledi($conn, $id);echo"<br><span>Sledi</span></h3>
                    </div>    
                    <div class='uporabnik-actionBtn'>";

        //dobimo podatke če porabnik že sledi tej določeni osebi...
        $sql2 = "SELECT * FROM sledilci WHERE (uporabnik_id = ?) AND (sledilec_id = ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql2)) {
            header("location: ../home.php?error=stmtfailed");
            exit();
        }


        $userId = $_SESSION['S_userId'];
        mysqli_stmt_bind_param($stmt, "ss", $id, $userId);
        mysqli_stmt_execute($stmt);

        $result2 = mysqli_stmt_get_result($stmt);

        if ($row2 = mysqli_fetch_assoc($result2)) {
            echo "
                 <form action='includes/UnSlediUporabniku.inc.php' method='post'>
                 <button class='follow-user-css-btn' type='submit' name='UnSlediUporabniku-btn' style='margin-right: 5px'>Unfollow</button>";
        } else {
            echo "
                 <form action='includes/slediUporabniku.inc.php' method='post'>
                 <button class='follow-user-css-btn' type='submit' name='slediUporabniku-btn'>Sledi</button>";
        }

        echo "
                 <input type='hidden' name='user_id' value='$id'>
                 <input type='hidden' name='url_username' value='$username'>
             </form>";


        //dobimo podatke če je uporabnik že prijatelj z to določeno osebo...
        $sql3 = "SELECT *, DATE_FORMAT(added_date,'%b %e, %Y | %H:%i') FROM prijatelji WHERE ((id_user = ?) AND (id_friend = ?)) OR ((id_user = ?) AND (id_friend = ?)) ORDER BY added_date DESC";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql3)) {
            header("location: ../home.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ssss", $userId, $id, $id, $userId);
        mysqli_stmt_execute($stmt);
        $result3 = mysqli_stmt_get_result($stmt);

        $status = '0';
        while ($row3 = $result3->fetch_assoc()) {
            global $status;
            $status = $row3['status'];
            $added_date = $row3["DATE_FORMAT(added_date,'%b %e, %Y | %H:%i')"];

            if ($status == 'non-checked') {
                echo "
                     <form>
                     <button disabled type='button' name='' class='dodaj-prijatelja-css-btn' style='background: rgba(241,241,241,0.55); padding: 10px 35px;'>Poslano...</button>";
            }
            else if ($status == 'accepted') {
                echo "
                     <form action='includes/OdstraniPrijatelja.inc.php' method='post'>
                     <button type='submit' name='OdstraniPrijatelja-btn' class='dodaj-prijatelja-css-btn' style='background: rgba(241,241,241,0.55); padding: 10px 2px;'>Odstrani Prijatelja</button>";
            }
            else if ($status == 'rejected') {
                echo "
                     <form action='includes/DodajPrijatelja.inc.php' method='post'>
                     <button type='submit' name='DodajPrijatelja-btn' class='dodaj-prijatelja-css-btn'>*Dodaj Prijatelja</button>
                     <p id='rejected-info'>Uporabnik vam je zavrnil prošnjo za prijateljstvo, lahko pa poskusite ponovno...</p>";

            }
            echo "
                 <input type='hidden' name='user_id' value='$id'>
                 <input type='hidden' name='url_username' value='$username'>
             </form>";
            echo "
                        </div>    
                    </div>
                </div>
            </div>
                <!-- uporabnikov banner -->
                <div id='uporabnik-bannerBx'>
                    <img src='$banner_dir' alt='banner_uporabnika'>
                </div>
            ";
            return $status;
        }

        // -------------------------------------------------
        if ($row3 = mysqli_fetch_assoc($result3)) {
            echo "serbus";
        }
        else {
            echo "
                    <form action='includes/DodajPrijatelja.inc.php' method='post'>
                    <button type='submit' name='DodajPrijatelja-btn' class='dodaj-prijatelja-css-btn'>Dodaj Prijatelja</button>";
        }
        echo "
                 <input type='hidden' name='user_id' value='$id'>
                 <input type='hidden' name='url_username' value='$username'>
             </form>";
        echo "
                    </div>    
                </div>
            </div>
        </div>
        <!-- uporabnikov banner -->
                <div id='uporabnik-bannerBx'>
                    <img src='$banner_dir' alt='banner_uporabnika'>
                </div>
        ";
        // -------------------------------------------------
        mysqli_stmt_close($stmt);
    }
}
function getUserObjave($conn, $user_username) {
    $sql = "SELECT * FROM objave WHERE uporabnik_id IN (SELECT id FROM uporabniki WHERE username = ?) ORDER BY created_date DESC";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../home.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $user_username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    echo "<div id='uporabnikove-objave-box02'>";
    while ($row = $result->fetch_assoc()) {
        $objava_id = $row['id'];
        getComment($conn, $objava_id);
        echo "<hr id='hr-box2'>";
    }
    echo "</div>";
}


function getFriendRequests($conn) {
    $sql = "SELECT p.id, p.id_user, p.id_friend, p.status, DATE_FORMAT(p.added_date,'%b %e, %Y | %H:%i'), u.username, u.img_dir FROM prijatelji p INNER JOIN uporabniki u ON p.id_user = u.id WHERE (p.id_friend = ?) AND (status = 'non-checked') ORDER BY p.added_date DESC";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../home.php?error=stmtfailed001");
        exit();
    }

    $userId = $_SESSION['S_userId'];
    mysqli_stmt_bind_param($stmt, "s", $userId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $id_user = $row['id_user'];
        $id_friend = $row['id_friend'];
        $status = $row['status'];
        $added_date = $row["DATE_FORMAT(p.added_date,'%b %e, %Y | %H:%i')"];
        $username = $row['username'];
        $userImg_dir = $row['img_dir'];
        $usernamelength = strlen($username);

        echo "<div class='firend-requesti-boxi'>";
        echo "<div class='friend-request'>
                    <h4>Imate novo prošnjo za prijateljstvo!</h4>
                    <hr>
                    <div class='friendrequest-usr-info'>
                        <img class='friendrequest-usr-img' src='$userImg_dir' alt='slika_uporabnika'>";
                        if ($usernamelength < 16) {
                            echo " <p><a href='uporabnik.php?uporabnik=$username'>$username</a></p>";
                        }
                        else {
                            $length = $usernamelength - 15;
                            $username2 = substr_replace($username, "", -$length);
                            echo " <p class='longUsername'><a href='uporabnik.php?uporabnik=$username'>$username2</a>...</p>";
                        }
                    echo "</div>
                    <form action='includes/friendRequest.inc.php' method='post' class='friendrequest-form'>
                        <input type='hidden' name='id' value='$id'>
                        <div class='friendrequest-button-alignment'>
                            <button type='submit' name='friend-accept-btn' class='sprejmi-btn'>Sprejmi <ion-icon name='checkmark-circle-outline'</ion-icon> </button>
                            <button type='submit' name='friend-reject-btn' class='reject-btn'>Zavrni <ion-icon name='close-circle-outline'></ion-icon> </button>
                        </div>
                    </form>
                  </div>";
        echo "</div>";
    }
}

function getFriendObjave($conn) {
    $sql = "SELECT o.*, DATE_FORMAT(o.created_date,'%b %e, %Y | %H:%i'), DATE_FORMAT(o.update_date,'%b %e, %Y | %H:%i') FROM objave o WHERE (o.uporabnik_id IN (SELECT p.id_user FROM prijatelji p WHERE (p.id_friend = ?) AND (status = 'accepted'))) OR (o.uporabnik_id IN (SELECT p.id_friend FROM prijatelji p WHERE (p.id_user = ?) AND (status = 'accepted'))) ORDER BY o.created_date DESC ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../home.php?error=stmtfailed01");
        exit();
    }

    $userId = $_SESSION['S_userId'];
    mysqli_stmt_bind_param($stmt, "ss", $userId, $userId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    while ($row = $result->fetch_assoc()) {
        $upo_id = $row['uporabnik_id'];
        $sql2 = "SELECT username, img_dir FROM uporabniki WHERE id='$upo_id'";
        $result2 = $conn->query($sql2);


        if ($row2 = $result2->fetch_assoc()) {
            $usr_img = $row2['img_dir'];
            $is_edited = $row['is_edited'];
            $refactored_date = $row["DATE_FORMAT(o.created_date,'%b %e, %Y | %H:%i')"];
            $objava_uporabnik_username = $row2['username'];

            //preden izpišemo vsebino naredimo mysqli_real_escape_string in strip_tag da se znebimo borebitni nezačeleni vsebini...
            $vsebina = mysqli_real_escape_string($conn, htmlspecialchars($row['vsebina']));
            $vsebina = str_replace(array("\\\\r\\\\n","\\r\\n"),"<br>",$vsebina);

            echo "<div class='comment-box'>";
            echo   "<img class='objava-user-image' src='$usr_img'></img>";
            echo    "<div class='comment-possision'>";
            echo        "<span class='comment-info'>";
            echo            "<p class='username-color'><a href='uporabnik.php?uporabnik=$objava_uporabnik_username'>$objava_uporabnik_username</a></p>", '&nbsp;&nbsp;&nbsp;', $refactored_date."<br><br>";
            echo        "</span>";
            if ($is_edited > 0) {
                $edited_time = $row["DATE_FORMAT(o.update_date,'%b %e, %Y | %H:%i')"];
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
                            <buttonclass='edit-objava-btn' name='komentar_edit'>Uredi</button>
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
                header("location: ../social.php?error=stmtfailed02");
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
                header("location: ../social.php?error=stmtfailed03");
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
                        <a href='komentiraj.php?id=$id_objave'><button class='comment-objava-btn'><ion-icon name='chatbox-outline'></ion-icon></button></a>
                    </div>";
            echo "</div>";
        }
    }
}
function stevliovseckov($conn, $id) {
    $sql = "SELECT COUNT(*) FROM vsecki WHERE id_objave IN (SELECT id FROM objave WHERE uporabnik_id = ?) ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_array($resultData)) {
        $stevilo_vseckov = $row['COUNT(*)'];
        echo $stevilo_vseckov;
    }

    mysqli_stmt_close($stmt);
}
function stevlioObjav($conn, $id) {
    $sql = "SELECT COUNT(*) FROM objave WHERE uporabnik_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_array($resultData)) {
        $stevilo_objav = $row['COUNT(*)'];
        echo $stevilo_objav;
    }

    mysqli_stmt_close($stmt);
}
function stevlioSledilcev($conn, $id) {
    $sql = "SELECT COUNT(*) FROM sledilci WHERE (uporabnik_id = ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_array($resultData)) {
        $stevilo_sledilcev = $row['COUNT(*)'];
        echo $stevilo_sledilcev;
    }

    mysqli_stmt_close($stmt);
}
function stevlioSledi($conn, $id) {
    $sql = "SELECT COUNT(*) FROM sledilci WHERE (sledilec_id = ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_array($resultData)) {
        $stevilo_sledi = $row['COUNT(*)'];
        echo $stevilo_sledi;
    }

    mysqli_stmt_close($stmt);
}

function getFriends($conn, $S_userID) {
    $sql = "SELECT * FROM uporabniki WHERE (id IN (SELECT id_user FROM prijatelji WHERE (id_friend = ?) AND (status = 'accepted'))) OR (id IN (SELECT id_friend FROM prijatelji WHERE (id_user = ?) AND (status = 'accepted'))) ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: home.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $S_userID, $S_userID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_array($resultData)) {
        $id = $row['id'];
        $username = $row['username'];
        $img_dir = $row['img_dir'];
        global $id_prijateljstva;

        getIdPrijateljstva($conn, $id);

        echo "<a class='pogovori-prijatel-box-a' href='chat.php?id=$id_prijateljstva'><div class='pogovori-prijatel-box'>
                <img src='$img_dir' alt='prijatelj_img'>
                <div class='pogovori-prijatel-info'>
                    <h4>$username</h4>
                    <p>Prijatelja že od: ";prijateljaZeOd($conn, $id);echo"</p>
                </div>
            </div>
            </a>";
    }

    mysqli_stmt_close($stmt);
}
//
function prijateljaZeOd($conn, $id) {
    $S_userID = $_SESSION['S_userId'];
    $sql = "SELECT DATE_FORMAT(added_date,'%b %e, %Y | %H:%i') FROM prijatelji WHERE ((id_user = ? AND id_friend = ?) OR (id_friend = ? AND id_user = ?)) AND (status = 'accepted') ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: home.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $S_userID, $id, $S_userID, $id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_array($resultData)) {
        $date_added = $row["DATE_FORMAT(added_date,'%b %e, %Y | %H:%i')"];
        echo $date_added;
    }

    mysqli_stmt_close($stmt);
}
function getIdPrijateljstva($conn, $id) {
    $S_userID = $_SESSION['S_userId'];
    $sql = "SELECT id FROM prijatelji WHERE ((id_user = ? AND id_friend = ?) OR (id_friend = ? AND id_user = ?)) AND (status = 'accepted') ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: home.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $S_userID, $id, $S_userID, $id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_array($resultData)) {
        global $id_prijateljstva;
        $id_prijateljstva = $row["id"];
        return $id_prijateljstva;
    }

    mysqli_stmt_close($stmt);
}

function getChatBoxMesages($conn, $id_prijateljstva) {
    $S_userID = $_SESSION['S_userId'];
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
        $id_user = $row['id_user'];
        $id_friend = $row['id_friend'];

        if ($S_userID != $id_user){
            if ($S_userID != $id_friend) {
                header("location: pogovori.php?error=ni_prijateljstva");
                return 0;
            }
        }
        echo "<div class='chat-chat-container'>";
        $id_userInfo = getUserInfoChatIdUser($conn, $id_user);
        $id_friendInfo = getUserInfoChatIdFriend($conn, $id_friend);
        getUserChatChat($conn, $id_user, $id_friend, $id_prijateljstva);

        //gledam kdo je friend in kdo je user zato da lahko v pravionem vstnem redu prikažem slike
        $usr_img_dir = $id_userInfo["img_dir"];
        $friend_img_dir = $id_friendInfo["img_dir"];

        if(strpos($usr_img_dir, $_SESSION['S_userUsername']) !== false){
            echo "    <div id='chat-inputBx'>
                            <hr>
                            <div id='chat-prijatelsvo-user-slike'>
                                <img src='$friend_img_dir' alt='friend_img_dir'>
                                <img src='$usr_img_dir' alt='friend_img_dir'>
                            </div>";
        } else{
            echo "    <div id='chat-inputBx'>
                            <hr>
                            <div id='chat-prijatelsvo-user-slike'>
                                <img src='$usr_img_dir' alt='friend_img_dir'>
                                <img src='$friend_img_dir' alt='friend_img_dir'>
                            </div>";
        }
                            echo "<form action='includes/chat.inc.php' method='post'>
                                <input type='hidden' name='id_prijateljstva' value='$id_prijateljstva'>
                                <textarea id='chat-input-textarea' name='chat-textarea' placeholder='Napiši...'></textarea>
                                <button type='submit' name='chat-input-btn'><ion-icon name='send-outline'></ion-icon></button>
                            </form>
                          </div>
              </div>";
    }

    mysqli_stmt_close($stmt);
}
function getUserInfoChatIdUser($conn, $id_user) {
    $sql = "SELECT * FROM uporabniki WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: home.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id_user);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_array($resultData)) {
        return $row;
    }
    return 0;
}
function getUserChatChat($conn, $id_user, $id_friend, $id_prijateljstva) {
    // ---> objave uporabnika
    $S_userId = $_SESSION['S_userId'];
    $sql = "SELECT m.*, DATE_FORMAT(m.message_date,'%b %e, %Y | %H:%i'), u.username, u.img_dir, u.id AS user_id FROM messages m INNER JOIN uporabniki u ON u.id = m.sender_id WHERE ((m.sender_id = ?) OR (m.sender_id = ?)) AND (m.id_prijateljstva = ?) ORDER BY m.message_date DESC";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: home.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $id_user, $id_friend, $id_prijateljstva);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);


    while ($row = mysqli_fetch_array($resultData)) {


        $message = $row['message'];
        $username = $row['username'];
        $message_date = $row["DATE_FORMAT(m.message_date,'%b %e, %Y | %H:%i')"];
        $id_message = $row['id'];
        $u_id = $row['user_id'];
        $u_img_dir = $row['img_dir'];

        //preden izpišemo vsebino naredimo mysqli_real_escape_string in strip_tag da se znebimo borebitni nezačeleni vsebini...
        $message = mysqli_real_escape_string($conn, htmlspecialchars($message));
        $message = str_replace(array("\\\\r\\\\n","\\r\\n"),"<br>",$message);

        echo "<div class='chat-chat-content'>";
                if ($u_id == $S_userId) {
                    echo "
                            <span class='chat-chat-info1'>
                                <p>$message_date</p>
                                <h4 class='chat-username'>$username</h4>
                          </span><br>";

                    echo "<div class='chat-message01'>
                              <span class='chat-message-echo1'>
                                <p>$message</p>
                              </span>
                          </div>";
                }
                else {
                    echo "
                            <span class='chat-chat-info2'>
                                <h4 class='chat-username'>$username</h4>
                                <p>$message_date</p>
                          </span>";

                    echo "<div class='chat-message02'>
                              <span class='chat-message-echo2'>
                                <p>$message</p>
                              </span>
                          </div>";
                }
        echo "</div>";

    }
}
function getUserInfoChatIdFriend($conn, $id_friend) {
    $sql = "SELECT * FROM uporabniki WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: home.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id_friend);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_array($resultData)) {
        return $row;
    }
    return 0;
}


function getAdminContainer($conn) {
    $sql = "SELECT * FROM uporabniki WHERE id != ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: home.php?error=stmtfailed");
        exit();
    }
    $S_userId = $_SESSION['S_userId'];
    mysqli_stmt_bind_param($stmt, "s", $S_userId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    echo '<div id="admin-users-box">
             <table class="GeneratedTable">';
    echo '<thead>
                  <tr>
                    <th>id</th>
                    <th>username</th>';
    echo '</tr>
                </thead>
                <tbody>';


    while ($row = mysqli_fetch_array($resultData)) {
        $id = $row['id'];
        $username = $row['username'];

        echo '<tr>
                  <td>';echo $id; echo '</td>
                  <td>';echo "<a href='admin.php?username=$username&isci-upo-btn='>$username</a>"; echo '</td>
              </tr>';
    }
    echo '</tbody>
            </table>
        </div>';

    echo '<div id="search-user-container">
            <div id="search-user-from">
                <form action="" method="get">
                    <input type="text" name="username" placeholder="username...">
                    <button type="submit" name="isci-upo-btn"><ion-icon name="search-outline"></ion-icon></button>
                </form>     
            </div>';

    if(isset($_GET['isci-upo-btn'])) {
        echo "<div id='search-user-box'>";
        $username2 = mysqli_real_escape_string($conn, $_GET['username']);

        $sql = "SELECT * FROM uporabniki WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: home.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $username2);
        mysqli_stmt_execute($stmt);

        $resultData2 = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_array($resultData2)) {
            $id =                   $row['id'];
            $username =             $row['username'];
            $firstname =            $row['first_name'];
            $lastname =             $row['last_name'];
            $email =                $row['email'];
            $pass =                $row['pwd'];
            $registracija_date =    $row['registracija_date'];
            $update_date =          $row['update_date'];
            $opis =                 $row['opis'];
            $img_dir =              $row['img_dir'];
            $banner_dir =           $row['banner_dir'];
            $regija =               $row['regija'];
            $mesto =                $row['mesto'];
            $pronouns =             $row['pronouns'];
            $datum_roj =            $row['datum_roj'];
            $status_user =          $row['status_user'];
            $is_admin =             $row['is_admin'];

            //preden izpišemo vsebino naredimo mysqli_real_escape_string in strip_tag da se znebimo borebitni nezačeleni vsebini...
            $opis = mysqli_real_escape_string($conn, htmlspecialchars($opis));
            $opis = str_replace(array("\\\\r\\\\n","\\r\\n")," ",$opis);

            echo "<form method='post' action='includes/adminUpdateUser.inc.php'>
                        <input type='hidden' name='id_u' value='$id'>
                        <input type='hidden' name='old_username' value='$username'>
                        <input type='hidden' name='old_email' value='$email'>
                    <table class='GeneratedTable2'>
                            <tbody>
                              <tr>
                                <td>*id:</td>
                                <td><input type='text' name='' value='$id' disabled></td>
                              </tr>
                              <tr>
                                <td>username:</td>
                                <td><input type='text' name='username' value='$username'></td>
                              </tr>
                              <tr>
                                <td>Ime:</td>
                                <td><input type='text' name='first_name' value='$firstname'></td>
                              </tr>
                              <tr>
                                <td>Priimek:</td>
                                <td><input type='text' name='lastname_name' value='$lastname'></td>
                              </tr>
                              <tr>
                                <td>Email:</td>
                                <td><input type='email' name='email' value='$email'></td>
                              </tr>
                              <tr>
                                <td>Geslo:</td>
                                <td><input type='password' name='pass' value='$pass'></td>
                              </tr>
                              <tr>
                                <td>Datum rojstva:</td>
                                <td><input type='date' name='datum_roj' value='$datum_roj'></td>
                              </tr>
                              <tr>
                                <td>Datum registracije: </td>
                                <td><input type='text' name='datum_reg' value='$registracija_date'></td>
                              </tr>
                              <tr>
                                <td>*Datum posodobitve:  </td>
                                <td><input type='text' name='datum_pos' value='$update_date' disabled></td>
                              </tr>
                              <tr>
                                <td>Opis:</td>
                                <td><textarea type='text' name='opis'>$opis</textarea></td>
                              </tr>
                              <tr>
                                <td>img_dir:</td>
                                <td>
                                    <select name='img_dir'>
                                        <option value='$img_dir'>$img_dir</option>
                                        <option value='default.png'>slike/img/default.png</option>
                                        <option value='banned.png'>slike/img/banned.png</option>
                                    </select>
                                </td>
                              </tr>
                              <tr>
                                <td>banner_dir:</td>
                                <td>
                                    <select name='banner_dir'>
                                        <option value='$banner_dir'>$banner_dir</option>
                                        <option value='default.png'>slike/banner/default.png</option>
                                        <option value='banned.png'>slike/banner/banned.png</option>
                                    </select>
                                </td>
                              </tr>
                              <tr>
                                <td>pronouns:</td>
                                <td><input type='text' name='pronouns' value='$pronouns'></td>
                              </tr>
                              <tr>
                                <td>Regija:</td>
                                <td>
                                    <select name='Regija'>
                                        <option value='$regija'>$regija</option>
                                        <option value='Slovenija'>Slovenija</option>
                                        <option value='Pomurska'>Pomurska</option>
                                        <option value='Podravska'>Podravska</option>
                                        <option value='Koroska'>Koroska</option>
                                        <option value='Savinjska'>Savinjska</option>
                                        <option value='Zasavska'>Zasavska</option>
                                        <option value='Jugo-Vzhodna Slo'>Jugo-Vzhodna Slo</option>
                                        <option value='Primorsko-Notranjska'>Primorsko-Notranjska</option>
                                        <option value='Goriska'>Goriska</option>
                                        <option value='Obalno-Kraška'>Obalno-Kraška</option>
                                        <option value='Gorenjska'>Gorenjska</option>
                                        <option value='Osrednje-Slovenska'>Osrednje-Slovenska</option>
                                    </select>
                                </td>
                              </tr>
                              <tr>
                                <td>Mesto:</td>
                                <td><input type='text' name='Mesto' value='$mesto'></td>
                              </tr>
                              <tr>
                                <td>Status:</td>
                                <td>
                                    <select name='Status'>
                                        <option value='$status_user'>$status_user</option>
                                        <option value='active'>active</option>
                                        <option value='innactive'>innactive</option>
                                        <option value='banned'>banned</option>
                                    </select>
                                </td>
                              </tr>
                              <tr>
                                <td>is_admin:</td>
                                <td><input type='number' name='is_admin' value='$is_admin'></td>
                              </tr>
                            </tbody>
                       </table>
                    <br>
                    
                    <button type='submit' name='update-upo-btn'>Uredi</button><br><br>
                    <hr>
                    <p class='search-user-box-opomba'>Prostori z oznako * se ne morejo oz. ne smejo urejati...</p><br>
                    <p class='search-user-box-opomba'>Legenda:</p>
                    <hr id='search-user-box-opomba-hr'>
                    <p class='search-user-box-opomba2'>BAN USER: nastavi staus na \"banned\"</p>
                    <p class='search-user-box-opomba2'>ADMIN UPORABNIK: nastavi is_admin na \"1\"</p>
                </form>";
        }
        echo "</div>";
    }
        echo '</div>';




    return 0;
}