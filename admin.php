<?php
include_once 'includes/functions.inc.php';
session_abort();
include_once 'header.php';
include_once 'includes/dbh.inc.php';
?>
<?php
if (isset($_SESSION["S_userId"])) {
    if (isset($_SESSION["is_admin"])) {
        if ($_SESSION["is_admin"] == 1) {
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
                <div class="admin-container">';
                        echo '<h3>Uredi uporabnike: </h3>';
                        getAdminContainer($conn);
                    echo '</div>
            </div>';
        }
    }
    else {
        header('location: home.php?nisi_admin');
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