<?php
include_once 'header2.php';
?>
<?php
include_once 'includes/dbh.inc.php';


if (isset($_SESSION['S_userId'])) {
    echo "  <div class='outer-profile-container'>
                <div class='profile-left'>
                    <div id='profile-container-left'>";
    echo "                <div class='banner-image'>
                            <span id='banner-profile-bg' style='background-image: url(".$_SESSION['S_userProfileBanner'].")'></span>
                            <div id='image-upload_b'>
                            
                                <form id='upload-banner-form' action='includes/upload-banner.inc.php' method='post' enctype='multipart/form-data'>
                                    <input type='file' name='banner-image' id='profile-upload-banner-button' onchange='upload_banner_upload_submit()'></input>
                                    <label for='profile-upload-banner-button'>
                                        <img src='media/upload_icon.svg' alt='upload_icon.svg'>
                                    </label>
                                    <div id='upload-banner-popup'>
                                        <button id='upload-banner-submit-button' name='bannerSubmit' type='submit'>Shrani</button>
                                    </div>
                                </form>
                                
                            </div>
                        </div>";

                        if (isset($_GET['error'])) {
                            //error-messages :(
                            if ($_GET['error'] == 'FileNotSupported') {
                                echo "<p class='error-message'>Ta vrsta datoteke ni podprta...</p>";
                            }
                            else if ($_GET['error'] == 'FileUploadError') {
                                echo "<p class='error-message'>Zgodila se je napaka pri objavljanu slike...</p>";
                            }
                            else if ($_GET['error'] == 'FileTooBig') {
                                echo "<p class='error-message'>Datoteka presega makismalno velikost 10mb...</p>";
                            }
                            else if ($_GET['error'] == 'stmtfailed') {
                                echo "<p class='error-message'>Napaka...</p>";
                            }
                            else if ($_GET['error'] == 'oldwrongpass') {
                                echo "<p class='error-message'>Staro geslo ste napisali napacno...</p>";
                            }
                            else if ($_GET['error'] == 'pwddontmatch') {
                                echo "<p class='error-message'>Novi gesli se ne ujemata...</p>";
                            }
                            else if ($_GET['error'] == 'emptyinput') {
                                echo "<p class='error-message'>Polja so prazna...</p>";
                            }
                        }
                        if (isset($_GET['success'])) {
                            if ($_GET['success'] == 'user_logged_in') {
                                echo "<p class='success-message'>Pozdravljeni...</p>";
                            }
                            else if ($_GET['success'] == 'selected_ne') {
                                echo "<p class='success-message'>Profil se ni izbrisal :D</p>";
                            }
                            else if ($_GET['success'] == 'pwdSpremenjen') {
                                echo "<p class='success-message'>Geslo spremenjeno :D</p>";
                            }
                            else if ($_GET['success'] == 'user_updated') {
                                echo "<p class='success-message'>Podatki spremenjeni :D</p>";
                            }
                        }
                            echo "<script type='text/javascript'>
                                            setTimeout(function() {
                                                var errors = document.getElementsByClassName('error-message');
                                                var success = document.getElementsByClassName('success-message');
                                                
                                                try {
                                                    errors[0].style.opacity = '0';
                                                } catch (e) {}
                                                try {
                                                    errors[1].style.opacity = '0';
                                                } catch (e) {}
                                                try {
                                                    errors[2].style.opacity = '0';
                                                } catch (e) {}
                                                try {
                                                    errors[3].style.opacity = '0';
                                                } catch (e) {}
                                                try {
                                                    errors[4].style.opacity = '0';
                                                } catch (e) {}
                                                try {
                                                    errors[5].style.opacity = '0';
                                                } catch (e) {}
                                                try {
                                                    errors[6].style.opacity = '0';
                                                } catch (e) {}
                                                //success messages :D
                                                try {
                                                    success[0].style.opacity = '0';
                                                } catch (e) {}
                                                try {
                                                    success[1].style.opacity = '0';
                                                } catch (e) {}
                                                try {
                                                    success[2].style.opacity = '0';
                                                } catch (e) {}
                                                try {
                                                    success[3].style.opacity = '0';
                                                } catch (e) {}
                                                
                                                
                                            }, 3000);
                                      </script>";

    echo "              <h2 id='h2-profile'>" . $_SESSION['S_userUsername'] . "</h2>
                        
                        <br>
                        <div class='profile-icon'>
                            <span id='dot-profile_id' class='dot-profile' style='background-image: url(".$_SESSION['S_userProfileImg'].")'>
                                <div id='image-upload'>
                                    <form id='upload-profileicon-form' action='includes/upload-profileicon.inc.php' method='post' enctype='multipart/form-data'>
                                        <input type='file' name='icon-image' id='profile-upload-icon-button' onchange='upload_profileicon_upload_submit()'></input>
                                        <label for='profile-upload-icon-button'>
                                            <img src='media/upload_icon.svg' alt='upload_icon.svg'>
                                        </label>
                                        <div id='upload-profileicon-popup'>
                                            <button id='upload-profileicon-submit-button' name='iconSubmit' type='submit'>Shrani</button>
                                        </div>
                                    </form>
                                </div>
                            </span>
                        </div>
                        
                        <!-- -----------profile-select-option----------------->
                        <div class='profile-select-option'>
                            <div class='select-content' onclick='podatki_select()'>
                                <h3>Osebni Podatki</h3>
                                <p>Uredi svoje osebne podatke...</p>
                            </div>
                            <div class='select-content' onclick='geslo_select()'>
                                <h3>Spremeba gesla</h3>
                                <p>Spemeni svoje geslo...</p>
                                
                            </div>
                            <div class='select-content' onclick='izbris_select()'>
                                <h3>Izbris profila</h3>
                                <p>Izbriši svoj profil...</p>
                            </div>
                            <div class='select-content' onclick='info_select()'>
                                <h3>Ostale informacije</h3>
                                <p>Ostale informacije...</p>
                            </div>
                            <button id='odjava-button'><a id='odjava-link' href='includes/logout.inc.php'>Odjava</a></button>
                        </div>
                        <!-- -------------------------------------------------->
                        
                        
                    </div>
                </div><div class='profile-right'>
                    <div id='profile-container-right'>
                    
                        <div id='spremba-osebnih-podatkov-container'>
                            <div id='osebni-podatki-container'>
                            
                                <form action='includes/sprememba-osebnih.inc.php' method='POST'>
                                    <h3>Osebni Podatki</h3> <button type='submit' class='update-osebni-button' name='osebni-submit'>Shrani</button><hr id='spremembe-hr'>
                                    <div class='osebni-block'>
                                        <label>*Uporabniško ime</label><br>
                                        <input type='text' name='username' value='" . $_SESSION['S_userUsername'] . "' class='username-input'>
                                    </div><br>
                                    <div class='osebni-block'>
                                        <label>*Email</label><br>
                                        <input type='email' name='email' value='" . $_SESSION['S_userEmail'] . "' class='username-input'>
                                    </div><br>
                                    <div class='osebni-inline'>
                                        <label>Ime</label><br>
                                        <input type='text' name='firstname' value='" . $_SESSION['S_userFirstName'] . "' class='username-input'>
                                    </div>
                                    <div class='osebni-inline'>
                                        <label>Priimek</label><br>
                                        <input type='text' name='lastname' value='" . $_SESSION['S_userLastName'] . "' class='username-input'>
                                    </div><br><br>
                                    <div class='osebni-inline'>
                                        <label>Zaimek</label><br>
                                        <input type='text' name='pronouns' value='" . $_SESSION['S_userPronouns'] . "' class='username-input'>
                                    </div>
                                    <div class='osebni-inline'>
                                        <label>Datum rojstva</label><br>
                                        <input type='date' name='datumroj' value=" . $_SESSION['S_userDatumRoj'] . " class='username-input'>
                                    </div><br><br>
                                    <div class='osebni-block'>
                                        <label>Opis</label><br>
                                        <textarea name='opis' value='' class='username-input' rows='4' cols='70'>" . $_SESSION['S_userOpis'] . "</textarea>
                                    </div><br>
                                    <div class='osebni-inline'>
                                        <label>*Regija</label><br>
                                        <select name='regija' class='username-input'>
                                            <option value='" . $_SESSION['S_userRegija'] . "' selected>" . $_SESSION['S_userRegija'] . "</option>
                                            <option value='Slovenija'>Slovenija</option>
                                            <option value='Pomurska'>Pomurska</option>
                                            <option value='Podravska'>Podravska</option>
                                            <option value='Koroska'>Koroska</option>
                                            <option value='Savinjska'>Savinjska</option>
                                            <option value='Zasavska'>Zasavska</option>
                                            <option value='Jugo-Vzhodna Slo'>Jugo-Vzhodna Slo</option>
                                            <option value='Primorsko-Notranjska'>Primorsko-Notranjska</option>
                                            <option value='Goriska'>Goriska</option>
                                            <option value='Obalno-Kraška'>Obalno-Kraška</option>
                                            <option value='Gorenjska'>Gorenjska</option>
                                            <option value='Osrednje-Slovenska'>Osrednje-Slovenska</option>
                                        </select>
                                    </div>
                                    <div class='osebni-inline'>
                                        <label>Mesto</label><br>
                                        <input type='text' name='mesto' value='" . $_SESSION['S_userMesto'] . "' class='username-input'>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div id='spremba-gesla-container'>
                            <div id='geslo-container'>
                                <form action='includes/spremba-gesla.inc.php' method='post'>
                                    <h3>Spremeba Gesla</h3> <button type='submit' class='update-osebni-button' name='sprememba-gesla-submit'>Shrani</button><hr id='spremembe-hr'>
                                    <div class='trenutno-geslo-block'>
                                        <label>*Trenutno geslo</label><br>
                                        <input type='password' name='current-pwd' placeholder='trenutno geslo...' class='username-input'>
                                    </div><br>
                                    <div class='trenutno-geslo-inline'>
                                        <label>*Novo geslo</label><br>
                                        <input type='password' name='new-pwd' placeholder='novo geslo...' class='username-input'>
                                    </div>
                                    <div class='trenutno-geslo-inline'>
                                        <label>*Ponovi novo geslo</label><br>
                                        <input type='password' name='new-pwd-repeat' placeholder='novo geslo...' class='username-input'>
                                    </div><br>
                                </form>
                            </div>
                        </div>
                        
                        <div id='izbris-profila-container'>
                            <div id='izbris-container'>
                                <form action='includes/izbris-profila.inc.php' method='post'>
                                    <h3>Izbris Profila</h3> <button type='submit' class='update-osebni-button' name='izbris-profila-submit'>Shrani</button><hr id='spremembe-hr'>
                                    <div class='izbris-profila-block'>
                                        <label>Ste prepricani, da želite izbrisati profil?</label><br>
                                        <select name='izbris-radio-select' id='izbris-radio-select'>
                                            <option value='no' selected>Ne</option>
                                            <option value='yes'>Da</option>
                                        </select>
                                    </div>
                                    <div class='izbris-profila-block2'>
                                        <hr id='spremembe-hr2'>
                                        <h4>Poglejte si <a id='izris-ostal-info' href='#ostale-info' onclick='info_select()'>Ostale Informacije</a> pred izbrisom profila...</h4>
                                        <p>Preberite si informacije o zasebnosti uporabniških racunov in še vec...</p>
                                    </div><br>
                                </form>
                            </div>
                        </div>
                        
                        <div id='ostale-info-container'>
                            <h3>Ostale Informacije</h3>
                            <br>
                            <div id='ostale-info-container'>
                            
                            </div>
                        </div>
                        
                        <br>
                    </div>
                </div>
            </div>  
            ";
    echo "<div class='navigation'>
    <div class='menuToggle'></div>
    <ul>
        <li class='list' style='--clr:#4b6cb7;'>
            <a href='#'>
                <span class='icon'><ion-icon name='home-outline'></ion-icon></span>
                <span class='text'>Home</span>
            </a>
        </li>
        <li class='list' style='--clr:#4b6cb7;'>
            <a href='#'>
                <span class='icon'><ion-icon name='create-outline'></ion-icon></span>
                <span class='text'>Social</span>
            </a>
        </li>
        <li class='list' style='--clr:#4b6cb7;'>
            <a href='#'>
                <span class='icon'><ion-icon name='map-outline'></ion-icon></span>
                <span class='text'>Regije</span>
            </a>
        </li>
        <li class='list' style='--clr:#4b6cb7;'>
            <a href='#'>
                <span class='icon'><ion-icon name='people-outline'></ion-icon></span>
                <span class='text'>Prijatelji</span>
            </a>
        </li>
        <li class='list' style='--clr:#4b6cb7;'>
            <a href='#'>
                <span class='icon'><ion-icon name='chatbox-outline'></ion-icon></span>
                <span class='text'>Pogovori</span>
            </a>
        </li>
        <li class='list active' style='--clr:#4b6cb7;'>
            <a href='#'>
                <span class='icon'><ion-icon name='person-outline'></ion-icon></span>
                <span class='text'>Profil</span>
            </a>
        </li>
        <li class='list' style='--clr:#4b6cb7;'>
            <a href='#'>
                <span class='icon'><ion-icon name='log-out-outline'></ion-icon></span>
                <span class='text'>Odjava</span>
            </a>
        </li>
    </ul>
</div>";
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