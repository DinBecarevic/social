<?php
include_once 'header.php';
?>
<?php
include_once 'includes/dbh.inc.php';


if (isset($_SESSION['S_userId'])) {
    echo "  <div class='outer-profile-container'>
                <div class='profile-left'>
                    <div id='profile-container-left'>
                        <div class='banner-image'>
                            <span id='banner-profile-bg' style='background-image: url(".$_SESSION['S_userProfileBanner'].")'></span>
                            <div id='image-upload_b'>
                                <label for='profile-upload-banner-button'>
                                    <img src='media/upload_icon.svg' alt='upload_icon.svg'>
                                </label>
                                <input type='file' id='profile-upload-banner-button'></input>
                            </div>
                        </div>
                        
                        <h2 id='h2-profile'>" . $_SESSION['S_userUsername'] . "</h2>
                        
                        <br>
                        <div class='profile-icon'>
                            <span id='dot-profile_id' class='dot-profile' style='background-image: url(".$_SESSION['S_userProfileImg'].")'>
                                <div id='image-upload'>
                                    <label for='profile-upload-icon-button'>
                                        <img src='media/upload_icon.svg' alt='upload_icon.svg'>
                                    </label>
                                    <input type='file' id='profile-upload-icon-button'></input>
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
                                    <h3>Osebni Podatki</h3> <button type='submit' id='update-osebni-button' name='osebni-submit'>Shrani</button><hr id='spremembe-hr'>
                                    <div class='osebni-block'>
                                        <label>*Uporabniško ime</label><br>
                                        <input type='text' name='username' value='" . $_SESSION['S_userUsername'] . "' id='username-input'>
                                    </div><br>
                                    <div class='osebni-block'>
                                        <label>*Email</label><br>
                                        <input type='email' name='email' value='" . $_SESSION['S_userEmail'] . "' id='username-input'>
                                    </div><br>
                                    <div class='osebni-inline'>
                                        <label>Ime</label><br>
                                        <input type='text' name='firstname' value='" . $_SESSION['S_userFirstName'] . "' id='username-input'>
                                    </div>
                                    <div class='osebni-inline'>
                                        <label>Priimek</label><br>
                                        <input type='text' name='lastname' value='" . $_SESSION['S_userLastName'] . "' id='username-input'>
                                    </div><br><br>
                                    <div class='osebni-inline'>
                                        <label>Zaimek</label><br>
                                        <input type='text' name='pronouns' value='" . $_SESSION['S_userPronouns'] . "' id='username-input'>
                                    </div>
                                    <div class='osebni-inline'>
                                        <label>Datum rojstva</label><br>
                                        <input type='date' name='datumroj' value=" . $_SESSION['S_userDatumRoj'] . " id='username-input'>
                                    </div><br><br>
                                    <div class='osebni-block'>
                                        <label>Opis</label><br>
                                        <textarea name='opis' value='' id='username-input' rows='4' cols='70'>" . $_SESSION['S_userOpis'] . "</textarea>
                                    </div><br>
                                    <div class='osebni-inline'>
                                        <label>*Regija</label><br>
                                        <select name='regija' id='username-input'>
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
                                        <input type='text' name='mesto' value='" . $_SESSION['S_userMesto'] . "' id='username-input'>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div id='spremba-gesla-container'>
                            <div id='geslo-container'>
                                <form action='includes/spremba-gesla.inc.php' method='post'>
                                    <h3>Spremeba Gesla</h3> <button type='submit' id='sprememba-gesla-button' name='sprememba-gesla-submit'>Shrani</button><hr id='spremembe-hr'>
                                    <div class='trenutno-geslo-block'>
                                        <label>*Trenutno geslo</label><br>
                                        <input type='password' name='current-pwd' placeholder='trenutno geslo...' id='username-input'>
                                    </div><br>
                                    <div class='trenutno-geslo-inline'>
                                        <label>*Novo geslo</label><br>
                                        <input type='password' name='new-pwd' placeholder='novo geslo...' id='username-input'>
                                    </div>
                                    <div class='trenutno-geslo-inline'>
                                        <label>*Ponovi novo geslo</label><br>
                                        <input type='password' name='new-pwd-repeat' placeholder='novo geslo...' id='username-input'>
                                    </div><br>
                                </form>
                            </div>
                        </div>
                        
                        <div id='izbris-profila-container'>
                            <h3>Izbris Profila</h3>
                            <br>
                            <div id='izbris-container'>
                            
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
