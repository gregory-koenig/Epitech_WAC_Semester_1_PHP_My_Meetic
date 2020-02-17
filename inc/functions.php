<?php

function connect_db() {
    $db = new PDO('mysql:host=localhost;dbname=my_meetic', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $db;
}

function connect_session() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

function forbidden_access()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['auth'])) {
        $_SESSION['flash']['danger'] = "Accès interdit.";
        header('Location: index.php');
        exit();
    }
}

function str_random($length)
{
    $alphabet = "0123456789abcdefghijklmnopqrstuvwxyz"
        . "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $alphabet = str_repeat($alphabet, $length);
    $alphabet = str_shuffle($alphabet);
    $alphabet = substr($alphabet, 0, $length);
    return $alphabet;
}