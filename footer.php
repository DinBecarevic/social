<footer>
    <div class="footer animate__animated animate__fadeIn">
        <?php
        if (isset($_SESSION['S_userUsername'])) {
            $username = $_SESSION['S_userUsername'];
            echo '<p><a href="#">Prijavljen: ';echo $username; echo '</a></p>
                  <p>|</p>';
        }
        else {
            echo '  <p><a href="index.php">Registracija</a></p>
                    <p><a href="index.php">Prijava</a></p>';
        }
        ?>
        <p><a href="#">Pomoc</a></p>
        <p><a href="#">O nas</a></p>
        <p><a href="#">Pravila uporabe</a></p>
        <p>Copyright © 2022 Social media</p>
    </div>
</footer>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="js/home.js"></script>
</body>
</html>