<?php
include_once 'includes/functions.inc.php';
session_abort();
include_once 'header.php';
include_once 'includes/dbh.inc.php';
?>
<?php
if (isset($_SESSION["S_userId"])) {
    echo '
<div class="home-background">
<div class="navigation">
    <div class="menuToggle"></div>
    <ul>';

    include_once 'includes/admin-navidation.inc.php';
       echo '<li class="list active" style="--clr:#4b6cb7;">
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
<div class="home-container">
    <div class="home-content">
        <div id="home-pozdrav">
            <h3>Pozdravljeni!</h3>
            <h4>na najbolj??em Slovenskem socialnem omre??ju...</h4><br>
            <span class="icon"><a href="objavi.php"><ion-icon name="create-outline"></ion-icon></a></span>
            <p>Delite svoja mnenja, trenutke, slike in ??e vec, preprosto in popolnoma brezplacno :D</p>
        </div>
    </div>
    <div class="home-content">
        <div id="home-info">
            <h3>Regije</h3>
            <h4>predstavljajo velik del tega socialnega omre??ja</h4><br>
            <span class="icon"><a href="regije.php"><ion-icon name="map-outline"></a></ion-icon></span>
            <p>Opredelite se po svoji regiji ter spremljajte samo lokalne dogodke...</p>
        </div>
    </div>
    <div class="home-content">
        <div id="home-more">
            <h3>Informacije</h3>
            <h4>,vec o spletni stani lahko zveste na <a  id="info-link" href="info.php">info...</a></h4><br>
            <span><a href="info.php"><ion-icon name="information-circle-outline"></ion-icon></a></span>
            <p>Delite svoja mnenja, trenutke, slike in ??e vec preprosto in popolnoma brezplacno :D</p>
        </div>
    </div>



</div>
</div>';
}
else {
    include_once 'niste-prijavljeni.php';
}
?>

<?php
include_once 'footer.php';
?>
<script src="js/main.js"></script>