<?php
if (isset($_SESSION['is_admin'])) {
    if ($_SESSION['is_admin'] == 1) {
        $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        //dobim link zato da pogledam a smo na admin page da dam na navigaciji active na gumb
        //to delam ker na vsakem navijaciji includam to datoteko
        if (strpos($actual_link, 'admin')) {
            echo "<li class='list active' style='--clr:#4b6cb7;'>
            <a href='#'>
                <span class='icon'><ion-icon name='build-outline'></ion-icon></span>
                <span class='text'>Admin</span>
            </a>
        </li>";
        }
        else {
            echo "<li class='list' style='--clr:#4b6cb7;'>
            <a href='#'>
                <span class='icon'><ion-icon name='build-outline'></ion-icon></span>
                <span class='text'>Admin</span>
            </a>
        </li>";
        }

    }
}
?>