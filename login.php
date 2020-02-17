<?php

include_once 'inc/functions.php';

if (!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $db = connect_db();
    $req = $db->prepare('SELECT * FROM users WHERE email = ? AND active = ?');
    $req->execute([$_POST['email'], 1]);
    $user = $req->fetch();
    connect_session();

    if (password_verify($_POST['password'], @$user->password)) {
        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] = "Vous êtes maintenant connectés.";
        header('Location: account.php');
        exit();
    } else {
        $_SESSION['flash']['danger'] = "E-mail ou mot de passe incorrect.";
    }
}
?>

<?php include_once 'inc/header.php'; ?>

<div class="jumbotron">
    <form class="form-horizontal" action="" method="post">
        <fieldset>
            <legend>Se connecter</legend>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="email">E-mail</label>
                <div class="col-lg-10">
                    <input class="form-control" id="email" type="text" name="email" placeholder="Entrez votre adresse e-mail">
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label" for="password">Mot de passe</label>
                <div class="col-lg-10">
                    <input class="form-control" id="password" type="password" name="password" placeholder="Entrez votre mot de passe">
                </div>
            </div>

            <div class="col-lg-10 col-lg-offset-2">
                <button class="btn btn-primary" type="submit">Se connecter</button>
            </div>
        </fieldset>
    </form>
</div>

<?php include_once 'inc/footer.php'; ?>