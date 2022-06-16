<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON.DS.'header.php' ?>
    <body>
        <?php require_once COMMON.DS.'navbar.php' ?>
        <div class="container">
            <div class="content">
                <span class="d-flex justify-content-center">
                        <h1>Accueil professeur</h1>
                </span>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Gérer les cursus</h5>
                                <p class="card-text">Choisissez les classes auxquelles vous enseigner. Si un cursus n'existe pas encore vous pourrez en ajouter un nouveau !</p>
                                <a href="/professeur/cursus" class="btn btn-secondary">Accéder à vos cursus</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Gérer les matières</h5>
                                <p class="card-text">Vous pouvez ajouter les matières que vous enseignez et après y assigner des étudiants 🏫</p>
                                <a href="/professeur/matieres" class="btn btn-secondary">Accéder à vos matières</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Gérer les examens</h5>
                                <p class="card-text">Vous pouvez créer, publier et noter vos propres examens 💯</p>
                                <a href="/professeur/examens" class="btn btn-secondary">Accéder à vos examens</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once COMMON.DS.'footer.php' ?>
    </body>

</HTML>