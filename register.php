<?php

include_once 'inc/functions.php';

if (!empty($_POST)) {
    $db = connect_db();
    $errors = [];
    $regex = '#^[a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s-]+$#';
    $todays_date = new DateTime();
    $majority = $todays_date->sub(new DateInterval('P18Y'));
    $birthdate = new DateTime($_POST['birthdate']);

    if (empty($_POST['last_name'])) {
        $errors['last_name'] = "vous n'avez pas entré votre nom de famille";
    } elseif (!preg_match($regex, $_POST['last_name'])) {
        $errors['last_name'] = "votre nom n'est pas valide : sont autorisés "
            . "les lettres (minuscules et majuscules, avec ou sans accents), "
            . "les espaces et les tirets";
    }

    if (empty($_POST['first_name'])) {
        $errors['first_name'] = "vous n'avez pas entré votre prénom";
    } elseif (!preg_match($regex, $_POST['first_name'])) {
        $errors['first_name'] = "votre prénom n'est pas valide : sont "
            . "autorisés les lettres (minuscules et majuscules, avec ou sans "
            . "accents), les espaces et les tirets";
    }

    if (empty($_POST['birthdate'])) {
        $errors['birthdate'] = "vous n'avez pas entré votre date de naissance";
    } elseif ($birthdate >= $majority) {
        $errors['birthdate'] = "vous devez avoir plus de 18 ans";
    }

    if (empty($_POST['city'])) {
        $errors['city'] = "vous n'avez pas entré votre ville de résidence";
    } elseif (!preg_match($regex, $_POST['city'])) {
        $errors['city'] = "votre ville n'est pas valide : sont autorisés les "
            . "lettres (minuscules et majuscules, avec ou sans accents), les "
            . "espaces et les tirets";
    }

    if (empty($_POST['email'])) {
        $errors['email'] = "vous n'avez pas entré votre adresse e-mail";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "votre adresse e-mail n'est pas valide : une "
            . "adresse e-mail s'écrit \"identifiant@exemple.com\"";
    } else {
        $req = $db->prepare('SELECT id FROM users WHERE email = ?');
        $req->execute([$_POST['email']]);
        $email = $req->fetch();
        if ($email) {
            $errors['email'] = "cette adresse e-mail est déjà utilisée";
        }
    }

    if (empty($_POST['password'])) {
        $errors['password'] = "vous n'avez pas entré votre mot de passe";
    } else {
        if (strlen($_POST['password']) < 6) {
            $errors['password'] = "le mot de passe doit être composé de 6 "
                . "caractères minimum";
        } else {
            if (empty($_POST['password_confirm'])) {
                $errors['password_confirm'] = "vous n'avez pas confirmé votre mot de " . "passe";
            } elseif ($_POST['password'] != $_POST['password_confirm']) {
                $errors['password_confirm'] = "la confirmation du mot de passe ne " . "correspond pas";
            }
        }
    }

    if (empty($errors)) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $token = str_random(60);
        $sql = 'INSERT INTO users
                SET last_name = ?, first_name = ?, gender = ?, birthdate = ?,
                    city = ?, email = ?, password = ?, token = ?, active = ?';
        $req = $db->prepare($sql);
        $req->execute([$_POST['last_name'], $_POST['first_name'],
            $_POST['gender'], $_POST['birthdate'], $_POST['city'],
            $_POST['email'], $password, $token, 1]);
        $id = $db->lastInsertId();
        header("Location: confirm.php?id=$id&token=$token");
        exit();
    }
}
?>

<?php include_once 'inc/header.php'; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-dismissible alert-danger" id="alert">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <p>Vous n'avez pas correctement rempli le formulaire :</p>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="jumbotron">
    <form class="form-horizontal" action="" method="post">
        <fieldset>
            <legend>S'inscrire</legend>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="last_name">Nom</label>
                <div class="col-lg-10">
                    <input class="form-control" id="last_name" type="text" name="last_name" placeholder="Entrez votre nom" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label" for="first_name">Prénom</label>
                <div class="col-lg-10">
                    <input class="form-control" id="first_name" type="text" name="first_name" placeholder="Entrez votre prénom" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label" for="birthdate">Date de naissance</label>
                <div class="col-lg-10">
                    <input class="form-control" id="birthdate" type="date" name="birthdate" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Genre</label>
                <div class="col-lg-10">
                    <div class="radio">
                        <label><input name="gender" id="optionsRadios1" value="man" checked="" type="radio" />Homme</label>
                    </div>
                    <div class="radio">
                        <label><input name="gender" id="optionsRadios2" value="woman" type="radio" />Femme</label>
                    </div>
                    <div class="radio">
                        <label><input name="gender" id="optionsRadios2" value="other" type="radio" />Autre</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label" for="city">Ville</label>
                <div class="col-lg-10">
                    <input class="form-control" id="city" type="text" name="city" placeholder="Entrez votre ville" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label" for="email">E-mail</label>
                <div class="col-lg-10">
                    <input class="form-control" id="email" type="text" name="email" placeholder="Entrez votre adresse e-mail" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label" for="password">Mot de passe</label>
                <div class="col-lg-10">
                    <input class="form-control" id="password" type="password" name="password" placeholder="Entrez votre mot de passe" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label" for="password_confirm">Confirmez votre mot de passe</label>
                <div class="col-lg-10">
                    <input class="form-control" id="password_confirm" type="password" name="password_confirm" placeholder="Confirmez votre mot de passe" />
                </div>
            </div>

            <div class="col-lg-10 col-lg-offset-2">
                <button class="btn btn-default" type="reset">Effacer</button>
                <button class="btn btn-primary" type="submit">M'inscrire</button>
            </div>
        </fieldset>
    </form>
</div>

<?php include_once 'inc/footer.php'; ?>