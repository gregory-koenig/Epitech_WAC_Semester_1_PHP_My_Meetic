<?php

include_once 'inc/functions.php';

connect_session();
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = "Vous êtes maintenant déconnectés.";
header('Location: login.php');