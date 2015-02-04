<?php

session_start();
require_once('server/funcs.php');
$user = $_SESSION['username'];
goOnline($user, 0);
session_destroy();

session_start();
$_SESSION['error'] = "You're out!";
header('Location: form.php');

?>