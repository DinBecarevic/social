<?php
include_once 'includes/functions.inc.php';
session_abort();
include_once 'header.php';
include_once 'includes/dbh.inc.php';
?>
<?php
if (isset($_SESSION["S_userId"])) {

echo '
<div class="social-background" id="scroll-social">
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
</div>
<!--  -----social-objava  -->
    <div id="objvava-container">
        <div class="objava-box">';
echo "          <span class='user-img-circle' style='background-image: url(".$_SESSION["S_userProfileImg"].")'></span>";
echo '          <div id="objava-textarea">
                <form action="includes/objava.inc.php" method="post">
                <textarea name="objava-vsebina" value="" class="objava-input" rows="3" cols="70" placeholder="objavi nekaj..."></textarea>
                <div class="objava-dodatno">
                    <span id="objava-slike-button"><ion-icon name="images" onclic></ion-icon></span>
                    <span class="username-input">
                        <select name="regija-objava">
                            <option value='.$_SESSION["S_userRegija"].' selected> '.$_SESSION["S_userRegija"].'</option>
                            <option value="Slovenija">Slovenija</option>
                            <option value="Pomurska">Pomurska</option>
                            <option value="Podravska">Podravska</option>
                            <option value="Koroska">Koroska</option>
                            <option value="Savinjska">Savinjska</option>
                            <option value="Zasavska">Zasavska</option>
                            <option value="Jugo-Vzhodna Slo">Jugo-Vzhodna Slo</option>
                            <option value="Primorsko-Notranjska">Primorsko-Notranjska</option>
                            <option value="Goriska">Goriska</option>
                            <option value="Obalno-Kraška">Obalno-Kraška</option>
                            <option value="Gorenjska">Gorenjska</option>
                            <option value="Osrednje-Slovenska">Osrednje-Slovenska</option>
                        </select>
                    </span>
                </div>
                <button type="submit" name="objava-submit" id="objava-button" >objavi</button>
                </form>

            </div>

            
    </div>
    <div class="scroll-comments" id="scroll-comments-anywhere">';

        getComments($conn);
    echo ' </div>
    </div>
    
    <div class="objave-box">';
echo '    </div>
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