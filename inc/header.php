<?php
include_once 'inc/functions.php';
connect_session();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My meetic</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">My Meetic</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
            <ul class="nav navbar-nav">
                <?php if (isset($_SESSION['auth'])) : ?>
                    <li><a href="search.php">Recherche</a></li>
                    <li class="dropdown" id="dropdown-li">
                        <a class="dropdown-toggle" id="dropdown-a" href="#" data-toggle="dropdown" role="button" aria-expanded="false">Mon compte <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="account.php">Mes informations</a></li>
                            <li><a href="edit.php">Modifier mon compte</a></li>
                            <li class="divider"></li>
                            <li><a href="delete.php">Supprimer mon compte</a></li>
                            <li class="divider"></li>
                            <li><a href="logout.php">Se déconnecter</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li><a href="register.php">S'inscrire</a></li>
                    <li><a href="login.php">Se connecter</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="starter-template">
        <?php if (isset($_SESSION['flash'])) : ?>
            <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                <div class="alert alert-dismissible alert-<?= $type; ?>" id="alert">
                    <button class="close" type="button" data-dismiss="alert">&times;</button>
                    <?= $message; ?>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
        <div class="jumbotron">
