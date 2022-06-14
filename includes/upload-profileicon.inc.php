<?php


if (isset($_POST['iconSubmit'])) {
    if($_SESSION['status'] =! 'banned') {
    session_start();

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $file = $_FILES['icon-image'];
    print_r($file);
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    //pridobi končnico datoteke (naprimer .png)
    $fileExt = explode('.', $fileName);
    //pretvori $fileExt v spodnje črke ce bi končnica slučajno bila .PNG, end() uzame samo PNG
    $fileActualExtension = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'jfif', 'png', 'gif');

    //preveri če je objavljena slika dovoljena
    if (in_array($fileActualExtension, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 10000000) {
                //končno ime slike je username_banner.png
                $fileNameNew = $_SESSION['S_userUsername'] . '_profileicon.' . $fileActualExtension;
                //sharnimo directory slike v spremenljivko
                $fileDestination = '../slike/img/' . $fileNameNew;
                //sliko prestavimo
                move_uploaded_file($fileTmpName, $fileDestination);

                //updatamo se databazo...
                $fileDestinationDatabase = 'slike/img/' . $fileNameNew;
                updateIcon($conn, $fileDestinationDatabase);
                header("location: ../profil.php?error=iconUploadSuccess");
            } else {
                header("location: ../profil.php?error=FileTooBig");
            }
        } else {
            header("location: ../profil.php?error=FileUploadError");
        }
    } else {
        header("location: ../profil.php?error=FileNotSupported");
    }
    }
    else {
        header("location: ../profil.php?error=uporabnik_banned");
    }
} else {
    header("location: ../profil.php?error=fail");
    exit();
}