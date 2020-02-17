<?php
include_once 'inc/functions.php';
connect_session();
forbidden_access();
?>

<?php include_once 'inc/header.php'; ?>

<h3>Bonjour <?= ucwords($_SESSION['auth']->first_name); ?></h3>
<h4>Mes informations</h4>

<table class="table table-striped table-hover">
    <tr>
        <th>Nom</th>
        <td><?= strtoupper($_SESSION['auth']->last_name); ?></td>
    </tr>
    <tr>
        <th>Prénom</th>
        <td><?= ucwords($_SESSION['auth']->first_name); ?></td>
    </tr>
    <tr>
        <th>Date de naissance</th>
        <td><?= date('d/m/Y', strtotime($_SESSION['auth']->birthdate)); ?></td>
    </tr>
    <tr>
        <th>Genre</th>
        <td><?php
            if ($_SESSION['auth']->gender == 'man') {
            echo "Homme";
            } elseif ($_SESSION['auth']->gender == 'woman') {
                echo "Femme";
            } elseif ($_SESSION['auth']->gender == 'other') {
                echo "Autre";
            }
            ?></td>
    </tr>
    <tr>
        <th>Ville</th>
        <td><?= strtoupper($_SESSION['auth']->city); ?></td>
    </tr>
    <tr>
        <th>E-mail</th>
        <td><?= $_SESSION['auth']->email; ?></td>
    </tr>
</table>

<?php include_once 'inc/footer.php'; ?>