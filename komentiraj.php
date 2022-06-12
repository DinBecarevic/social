<?php
include_once 'includes/functions.inc.php';
session_abort();
include_once 'header.php';
include_once 'includes/dbh.inc.php';
?>
<div class="home-background">
    <div class="navigation">
        <div class="menuToggle"></div>
        <ul>
            <li class="list" style="--clr:#4b6cb7;">
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
    <div class="komentarji-container">
        <?php
        $objava_id = $_GET['id'];
        getComment($conn, $objava_id);
        echo "<hr id='komentar-hr'>
            <div id='komentirajObjavo-div'>
                <form action='includes/komentirajObjavo.inc.php' method='post' id='komentirajObjavoId'>
                    <h4><span>komentiraj objavo</span> <ion-icon name='arrow-up-outline'></ion-icon><button type='submit' name='komentirajObjavo-btn'>Komentiraj</button></h4>
                    <hr id='komentiraj-objavo-hr'>
                    <textarea name='komentar_vsebina' cols='80' rows='5' placeholder='Komentiraj...'></textarea>
                    <input type='hidden' name='url' value='$objava_id'>
                </form>
            </div>"
        ?>
        <?php
        $objava_id = $_GET['id'];
        echo "<div id='izpis-komantarjev-box'>";
        getComentKomentarje($conn, $objava_id);
        echo "</div>";
        ?>
    </div>
    </div>
</div>


<?php
include_once 'footer.php';
?>
<script src="js/main.js"></script>