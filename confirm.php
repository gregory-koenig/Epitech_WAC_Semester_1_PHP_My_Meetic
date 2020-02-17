<?php

include_once 'inc/functions.php';

$id = $_GET['id'];
$token = $_GET['token'];
$db = connect_db();
$req = $db->prepare('SELECT * FROM users WHERE id = ?');
$req->execute([$id]);
$user = $req->fetch();

if ($user && $user->token = $token) {
    $db->prepare('UPDATE users SET token = NULL WHERE id = ?')->execute([$id]);
    connect_session();
    $_SESSION['auth'] = $user;
    $_SESSION['flash']['success'] = "Le compte a été créé.";
    header("Location: account.php");
} else {
    forbidden_access();
}