<?php

include_once 'inc/functions.php';
forbidden_access();

if (!empty($_POST)) {
    $db = connect_db();
    $id = $_SESSION['auth']->id;
    $req = $db->prepare('SELECT id FROM users WHERE email = ?');
    connect_session();

    if (!empty($_POST['email'])) {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash']['danger'] = "Votre adresse e-mail n'est pas "
                . "valide : une adresse e-mail s'écrit "
                . "\"identifiant@exemple.com\".";
        } else {
            $req->execute([$_POST['email']]);
            $email = $req->fetch();
            if ($email) {
                $_SESSION['flash']['danger'] = "Cette adresse e-mail est déjà "
                    . "utilisée.";
            } else {
                $db->prepare('UPDATE users SET email = ? WHERE id = ?')
                    ->execute([$_POST['email'], $id]);
                $_SESSION['flash']['success'] = "L'adresse e-mail a bien été "
                    . "mise à jour.";
            }
        }
    } else {
        $_SESSION['flash']['danger'] = "Veuillez remplir tous les champs.";
    }

    if (!empty($_POST['password']) && !empty($_POST['new_password'])
        && !empty($_POST['new_password_confirm'])) {
        $req->execute([$_SESSION['auth']->email]);
        $user = $req->fetch();

        if (password_verify($_POST['password'], @$user->password)) {
            if (strlen($_POST['new_password']) < 6) {
                $_SESSION['flash']['danger'] = "Le nouveau mot de passe doit "
                    . "être composé de 6 caractères minimum.";
            } else {
                if ($_POST['new_password'] != $_POST['new_password_confirm']) {
                    $_SESSION['flash']['danger'] = "La confirmation du nouveau"
                        . " mot de passe ne correspond pas.";
                } else {
                    $password = password_hash($_POST['new_password'],
                        PASSWORD_BCRYPT);
                    $db->prepare('UPDATE users SET password = ? WHERE id = ?')
                        ->execute([$password, $id]);
                    $_SESSION['flash']['success'] = "Le mot de passe a bien "
                        . "été mis à jour.";
                }
            }
        } else {
            $_SESSION['flash']['danger'] = "L'ancien mot de passe est erroné.";
        }
    } else {
            $_SESSION['flash']['danger'] = "Veuillez remplir tous les champs.";
    }
}
?>

<?php include_once 'inc/header.php'; ?>

<button class="btn btn-info drop-down_btn" type="button">Modifier mon adresse e-mail</button>
<div class="drop-down">
    <form method="post" action="">
        <div class="form-group">
            <label class="col-lg-2 control-label" for="email">E-mail</label>
            <div class="col-lg-10">
                <input class="form-control" id="email" type="text" name="email" placeholder="Modifiez votre adresse e-mail" />
            </div>
        </div>
        <div class="col-lg-10 col-lg-offset-2">
            <button class="btn btn-primary" id="btn-edit" type="submit">Valider</button>
        </div>
    </form>
</div>

<button class="btn btn-info drop-down_btn" type="button">Modifier mon mot de passe</button>
<div class="drop-down">
    <form method="post" action="">
        <div class="form-group">
            <label class="col-lg-2 control-label" for="password">Ancien mot de passe</label>
            <div class="col-lg-10">
                <input class="form-control" id="password" type="password" name="password" placeholder="Entrez votre ancien mot de passe" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label" for="new_password">Nouveau mot de passe</label>
            <div class="col-lg-10">
                <input class="form-control" id="new_password" type="password" name="new_password" placeholder="Modfiez votre mot de passe" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label" for="new_password_confirm">Confirmez votre mot de passe</label>
            <div class="col-lg-10">
                <input class="form-control" id="new_password_confirm" type="password" name="new_password_confirm" placeholder="Confirmez votre nouveau mot de passe" />
            </div>
        </div>
        <div class="col-lg-10 col-lg-offset-2">
            <button class="btn btn-primary" type="submit">Valider</button>
        </div>
    </form>
</div>

<?php include_once 'inc/footer.php'; ?>

