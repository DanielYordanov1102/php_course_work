<?php
session_start();
session_unset();
session_destroy();

setcookie('last_login', '', time() - 3600, '/');

header('Location: ../index.php?page=home');
exit;
?>
