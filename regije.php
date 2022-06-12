<?php
include_once 'includes/functions.inc.php';
session_abort();
include_once 'header.php';
include_once 'includes/dbh.inc.php';
?>
<div class="regije-background">
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
            <li class="list active" style="--clr:#4b6cb7;">
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
        <div class="outer-trikotnik">
            <div class="home-content2">
                <div class="trikotnik1"></div>
                <div class="home-trikotnik-text">
                    <h2>Pomurska</h2>
                    <p>Število objav: </p>
                    <p>Šteilo vseckov: </p>
                </div>
            </div>
            <div class="trikotnik2">
                <div class="home-trikotnik2-text">
                    <h2>Zadnja objava</h2>
                    <hr>
                </div>
            </div>
            <img class="regije-bcg-slika" src="media/pomurska.jpg" alt="pomurska">
        </div>

        <div class="outer-trikotnik">
            <div class="home-content2">
                <div class="trikotnik1"></div>
                <div class="home-trikotnik-text">
                    <h2>Podravska</h2>
                    <p>Število objav: </p>
                    <p>Šteilo vseckov: </p>
                </div>
            </div>
            <div class="trikotnik2">
                <div class="home-trikotnik2-text">
                    <h2>Zadnja objava</h2>
                    <hr>
                </div>
            </div>
            <img class="regije-bcg-slika" src="media/podravska.jpg" alt="podravska.jpg">
        </div>

        <div class="outer-trikotnik">
            <div class="home-content2">
                <div class="trikotnik1"></div>
                <div class="home-trikotnik-text">
                    <h2>Koroška</h2>
                    <p>Število objav: </p>
                    <p>Šteilo vseckov: </p>
                </div>
            </div>
            <div class="trikotnik2">
                <div class="home-trikotnik2-text">
                    <h2>Zadnja objava</h2>
                    <hr>
                </div>
            </div>
            <img class="regije-bcg-slika" src="media/koroska.jpg" alt="koroska.jpg">
        </div>

        <div class="outer-trikotnik">
            <div class="home-content2">
                <div class="trikotnik1"></div>
                <div class="home-trikotnik-text">
                    <h2>Savinjska</h2>
                    <p>Število objav: </p>
                    <p>Šteilo vseckov: </p>
                </div>
            </div>
            <div class="trikotnik2">
                <div class="home-trikotnik2-text">
                    <h2>Zadnja objava</h2>
                    <hr>
                </div>
            </div>
            <img class="regije-bcg-slika" src="media/savinjska.jpg" alt="savinjska">
        </div>

        <div class="outer-trikotnik">
            <div class="home-content2">
                <div class="trikotnik1"></div>
                <div class="home-trikotnik-text">
                    <h2>Posavska</h2>
                    <p>Število objav: </p>
                    <p>Šteilo vseckov: </p>
                </div>
            </div>
            <div class="trikotnik2">
                <div class="home-trikotnik2-text">
                    <h2>Zadnja objava</h2>
                    <hr>
                </div>
            </div>
            <img class="regije-bcg-slika" src="media/posavska.jpg" alt="posavska.jpg">
        </div>

        <div class="outer-trikotnik">
            <div class="home-content2">
                <div class="trikotnik1"></div>
                <div class="home-trikotnik-text">
                    <h2>Zasavska</h2>
                    <p>Število objav: </p>
                    <p>Šteilo vseckov: </p>
                </div>
            </div>
            <div class="trikotnik2">
                <div class="home-trikotnik2-text">
                    <h2>Zadnja objava</h2>
                    <hr>
                </div>
            </div>
            <img class="regije-bcg-slika" src="media/zasavje.jpg" alt="zasavje.jpg">
        </div>

        <div class="outer-trikotnik">
            <div class="home-content2">
                <div class="trikotnik1"></div>
                <div class="home-trikotnik-text">
                    <h2>Osrednje-Slovenska</h2>
                    <p>Število objav: </p>
                    <p>Šteilo vseckov: </p>
                </div>
            </div>
            <div class="trikotnik2">
                <div class="home-trikotnik2-text">
                    <h2>Zadnja objava</h2>
                    <hr>
                </div>
            </div>
            <img class="regije-bcg-slika" src="media/Osrednje-Slovenska.jpg" alt="Osrednje-Slovenska.jpg">
        </div>

        <div class="outer-trikotnik">
            <div class="home-content2">
                <div class="trikotnik1"></div>
                <div class="home-trikotnik-text">
                    <h2>Jugo-Vzhodna Slo</h2>
                    <p>Število objav: </p>
                    <p>Šteilo vseckov: </p>
                </div>
            </div>
            <div class="trikotnik2">
                <div class="home-trikotnik2-text">
                    <h2>Zadnja objava</h2>
                    <hr>
                </div>
            </div>
            <img class="regije-bcg-slika" src="media/jugovzhodna.jpg" alt="jugovzhodna.jpg">
        </div>

        <div class="outer-trikotnik">
            <div class="home-content2">
                <div class="trikotnik1"></div>
                <div class="home-trikotnik-text">
                    <h2>Goriška</h2>
                    <p>Število objav: </p>
                    <p>Šteilo vseckov: </p>
                </div>
            </div>
            <div class="trikotnik2">
                <div class="home-trikotnik2-text">
                    <h2>Zadnja objava</h2>
                    <hr>
                </div>
            </div>
            <img class="regije-bcg-slika" src="media/goriska.jpg" alt="goriska.jpg">
        </div>

        <div class="outer-trikotnik">
            <div class="home-content2">
                <div class="trikotnik1"></div>
                <div class="home-trikotnik-text">
                    <h2>Primorsko-Notranjska</h2>
                    <p>Število objav: </p>
                    <p>Šteilo vseckov: </p>
                </div>
            </div>
            <div class="trikotnik2">
                <div class="home-trikotnik2-text">
                    <h2>Zadnja objava</h2>
                    <hr>
                </div>
            </div>
            <img class="regije-bcg-slika" src="media/primorskonotranjska.jpg" alt="primorskonotranjska.jpg">
        </div>

        <div class="outer-trikotnik">
            <div class="home-content2">
                <div class="trikotnik1"></div>
                <div class="home-trikotnik-text">
                    <h2>Obalno-Kraška</h2>
                    <p>Število objav: </p>
                    <p>Šteilo vseckov: </p>
                </div>
            </div>
            <div class="trikotnik2">
                <div class="home-trikotnik2-text">
                    <h2>Zadnja objava</h2>
                    <hr>
                </div>
            </div>
            <img class="regije-bcg-slika" src="media/Obalno-Kraska.jpg" alt="Obalno-Kraska.jpg">
        </div>

        <div class="outer-trikotnik">
            <div class="home-content2">
                <div class="trikotnik1"></div>
                <div class="home-trikotnik-text">
                    <h2>Gorenjska</h2>
                    <p>Število objav: </p>
                    <p>Šteilo vseckov: </p>
                </div>
            </div>
            <div class="trikotnik2">
                <div class="home-trikotnik2-text">
                    <h2>Zadnja objava</h2>
                    <hr>
                </div>
            </div>
            <img class="regije-bcg-slika" src="media/gorenjska.jpeg" alt="gorenjska.jpeg">
        </div>

    </div>
</div>


<?php
include_once 'footer.php';
?>
<script src="js/main.js"></script>
<script src="js/home.js"></script>