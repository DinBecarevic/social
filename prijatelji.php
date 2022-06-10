<?php
include_once 'header.php';
session_abort();
include_once 'includes/dbh.inc.php';
include_once 'includes/functions.inc.php';
?>
<?php
if (isset($_SESSION["S_userId"])) {
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
            <li class="list active" style="--clr:#4b6cb7;">
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
    <div id="prijatelji-container01">
        <div id="requesti-box01">';
            getFriendRequests($conn);
        echo '</div>
    </div>
</div>';
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