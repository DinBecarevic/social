<?php

session_start();
session_unset();
session_destroy();

// cookies
$expiration = time()-3600; // cas gre v minus

setcookie('C_userUsername', '', $expiration, '/');
setcookie('C_userEmail', '', $expiration, '/');
setcookie('C_userPwd', '', $expiration, '/');

header("location: index.php");
exit();