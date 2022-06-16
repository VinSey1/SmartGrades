<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON.DS.'header.php' ?>
    <body>
        <?php require_once COMMON.DS.'navbar.php' ?>
        <div class="container">
            <div class="content">
                <span class="d-flex justify-content-between">
                    <span style="width: 8%"></span>
                    <h1>Erreur</h1>
                    <a href="/" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
                </span>
                <div class="erreur-texte text-center">
                    <img src="<?= DS.FILES.DS ?>erreur-smiley.png" class="mx-auto d-block" alt="Smiley triste">
                    Maheureusement vous êtes allé plus loin qu'on ne le pensait... </br>
                    Veuillez revenir en arrière !
                </div>
            </div>
        </div>
        <?php require_once COMMON.DS.'footer.php' ?>
    </body>
</HTML>