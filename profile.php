<?php
include_once 'header.php';
?>
<?php
include_once 'includes/dbh.inc.php';


if (isset($_SESSION['S_userId'])) {
    echo "    <h2>Profil</h2><br><hr><br>
                id: " . $_SESSION['S_userId'] . "<br>
                Username: " . $_SESSION['S_userUsername'] . "<br>
                Ime : " . $_SESSION['S_userUsername'] . "<br>
                Priimek : " . $_SESSION['S_userUsername'] . "<br>
                Email : "   . $_SESSION['S_userEmail'] . "<br>
                Opis : "   . $_SESSION['S_userOpis'] . "<br>
                regija : " . $_SESSION['S_userRegija'] . "<br>
                mesto : " . $_SESSION['S_userMesto'] . "<br>
                pronouns : " . $_SESSION['S_userPronouns'] . "<br>
                datum rojstva :" . $_SESSION['S_userDatumRoj'] . "<br><br>
                <hr><br>
                <h3><a href='includes/logout.inc.php'>Odjava</a></h3>";
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