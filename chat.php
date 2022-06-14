<?php
include_once 'includes/functions.inc.php';
session_abort();
include_once 'header.php';
include_once 'includes/dbh.inc.php';

// $url1=$_SERVER['REQUEST_URI'];
// header("Refresh: 10; URL=$url1");

?>
<?php
if (isset($_SESSION["S_userId"])) {
    if(isset($_GET["id"])) {

    echo '<div class="home-background">
    <div class="navigation">
        <div class="menuToggle"></div>
        <ul>';

        include_once 'includes/admin-navidation.inc.php';
        echo '    <li class="list" style="--clr:#4b6cb7;">
                <a href="#">
                    <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                    <span class="text">Home</span>
                </a>
            </li>
            <li class="list" style="--clr:#4b6cb7;">
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
            <li class="list active" style="--clr:#4b6cb7;">
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
        <div id="chat-container01">';

            $S_userID = $_SESSION['S_userId'];
            $id_prijateljstva = $_GET['id'];

            getChatBoxMesages($conn, $id_prijateljstva);
    echo '  </div>
    </div>';
    }
    else {
        header('Location: pogovori.php?izberi_pogovor');
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