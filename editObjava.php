<?php
include_once 'includes/functions.inc.php';
session_abort();
include_once 'header.php';
include_once 'includes/dbh.inc.php';
?>
<?php
//dobim ime datoteke v kateri se nahajam zaradi tega ker to funkcijo uporabljam večkrat in da vem kam morem redrectat v headeru :D
$current_url_path = "$_SERVER[REQUEST_URI]";
$break_url = explode('/', $current_url_path);
$pfile = $break_url[count($break_url) - 1];

if (isset($_SESSION["S_userId"])) {
    if (isset($_POST['komentar_edit'])) {
    echo '
<div class="home-background">
    <div class="navigation">
        <div class="menuToggle"></div>
        <ul>';

    include_once 'includes/admin-navidation.inc.php';
            echo '<li class="list" style="--clr:#4b6cb7;">
                <a href="#">
                    <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                    <span class="text">Home</span>
                </a>
            </li>
            <li class="list active" style="--clr:#4b6cb7;">
                <a href="#">
                    <span class="icon"><ion-icon name="create-outline"></ion-icon></span>
                    <span class="text">Social</span>
                </a>
            </li>
            <li class="list" style="--clr:#4b6cb7;">
                <a href="#">
                    <span class="icon"><ion-icon name="map-outline"></ion-icon></span>
                    <span class="text">Regije</span>
                </a>
            </li>
            <li class="list" style="--clr:#4b6cb7;">
                <a href="#">
                    <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                    <span class="text">Prijatelji</span>
                </a>
            </li>
            <li class="list" style="--clr:#4b6cb7;">
                <a href="#">
                    <span class="icon"><ion-icon name="chatbox-outline"></ion-icon></span>
                    <span class="text">Pogovori</span>
                </a>
            </li>
            <li class="list" style="--clr:#4b6cb7;">
                <a href="#">
                    <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                    <span class="text">Profil</span>
                </a>
            </li>
            <li class="list" style="--clr:#4b6cb7;">
                <a href="#">
                    <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                    <span class="text">Odjava</span>
                </a>
            </li>
        </ul>
    </div>
    <div id="edit-container">
        <div class="edit-comment-box">
            <div id="home-pozdrav">';
                echo '<h3>Uredi svojo objavo...</h3>
                <form action="includes/editObjava.inc.php" method="post" id="edit-old-objava">';

                    $objava_id = mysqli_real_escape_string($conn,$_POST["id"]);
                    $old_objava = $_POST["sporocila"];

                    $old_objava = mysqli_real_escape_string($conn, htmlspecialchars($old_objava));
                    $old_objava = str_replace(array("\\\\r\\\\n","\\r\\n"),"\r",$old_objava);
                    echo "
                        <textarea type='text' name='new-objava' class='edit-objava-texarea'>$old_objava</textarea>
                        <input type='hidden' name='objava_id' value='$objava_id'>
                        <input type='hidden' name='back_url' value='$pfile'>";


                    echo '<button type="submit" name="editObjava-btn" class="edit-objava-button">Uredi</button>
                </form>';
                echo '<a href="social.php"><button type="button" class="edit-objava-button" id="nazaj-objava-button"><ion-icon name="return-down-back-outline"></ion-icon><p>Nazaj</p></button></a>
            </div>
        </div>
        <h4>Predogled</h4> ';

        getComment($conn, $objava_id);

    echo '</div>
</div>';

    }
    else {
        header("location: social.php");
    }
}
else {
    include_once 'niste-prijavljeni.php';
}
?>


<?php
include_once 'footer.php';
?>
<script src="js/main.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="js/live-editObjava.js"></script>