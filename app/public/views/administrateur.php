<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON . DS . 'header.php' ?>

<body>
    <?php require_once COMMON . DS . 'navbar.php' ?>
    <div class="container">
        <div class="content">
            <span class="d-flex justify-content-between">
                <span style="width: 8%"></span>
                <h1>Affichage d'un administrateur</h1>
                <a href="/administrateur/administrateurs" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
            </span>
            <h3>Profil de <?= ucfirst($user->name) ?> <?= strtoupper($user->surname) ?> </h3>
            <hr />
            <div class="d-flex flex-column flex-md-row justify-content-around">
                <div class="d-flex flex-column">
                    <p>
                        <b>Nom de famille:</b> <?= $user->surname ?>
                    </p>
                    <p>
                        <b>Prénom:</b> <?= $user->name ?>
                    </p>
                </div>
                <div class="d-flex flex-column">
                    <p>
                        <b>Email:</b> <?= $user->email ?>
                    </p>
                    <p>
                        <b>Date de naissance:</b> <?= date("d/m/Y", strtotime($user->date_naissance)) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php require_once COMMON . DS . 'footer.php' ?>
</body>

</HTML>