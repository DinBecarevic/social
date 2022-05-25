<?php
include_once 'header.php';
include_once 'includes/dbh.inc.php';
?>
<div class="navigation">
    <div class="menuToggle"></div>
    <ul>
        <li class="list active" style="--clr:#4b6cb7;">
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
                <span class="text">Skupine</span>
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
            <h4>na najboljšem Slovenskem socialnem omrežju...</h4><br>
            <p>Delite svoja mnenja, trenutke, slike in še več preprosto in popolnoma brezplacno :D</p>
        </div>
    </div>

</div>



<?php
include_once 'footer.php';
?>
<script src="js/main.js"></script>
<script src="js/home.js"></script>