<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON.DS.'header.php' ?>
    <body>
        <?php require_once COMMON.DS.'navbar.php' ?>
        <div class="container">
            <div class="content">
                <span class="d-flex justify-content-between">
                    <span style="width: 8%"></span>
                    <h1>Gestion de votre compte</h1>
                    <a href="/" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
                </span>
                <?php if (!empty($_SESSION['erreur'])) echo "<div class='alert alert-danger' role='alert'>".$_SESSION['erreur']."</div>"; ?>
                <a class="btn btn-primary" href="./motDePasse" role="button"><i class="bi bi-lock-fill"></i> Changer mon mot de passe </a>
                <br><br>
                <form action="" method="POST">
                    <input name="requete" type="hidden" value="suppression">
                    <button type="submit" class="btn btn-danger">Supprimer mon compte</button>
                </form>
            </div>
        </div>
        <?php require_once COMMON.DS.'footer.php' ?>
    </body>

</HTML>