<?php
include_once 'includes/functions.inc.php';
session_abort();
include_once 'header.php';
include_once 'includes/dbh.inc.php';
?>
<?php
if (isset($_SESSION["S_userId"])) {
    if(isset($_GET["id"])) {

    echo '<div class="home-background">
    <div class="navigation">
        <div class="menuToggle"></div>
        <ul>
            <li class="list" style="--clr:#4b6cb7;">
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
        <div id="pogovori-container01">';

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
    echo "<section class='banner'> ";
    echo "	<div class='box2'> ";
    echo "		<div class='content-profile'> ";
    echo "			<div class='profilep'> ";
    echo "				<p>Niste prijavljeni!</p>";
    echo "				<p><a style='text-decoration: none; color: #3e849e;' href='index.php'>Prijavite se...</a></p>";
    echo "			</div> ";
    echo "		</div> ";
    echo "	</div> ";
    echo "</section>";
}
?>

<?php
include_once 'footer.php';
?>
<script src="js/main.js"></script>