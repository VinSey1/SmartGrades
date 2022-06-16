<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON . DS . 'header.php' ?>

<body>
    <?php require_once COMMON . DS . 'navbar.php' ?>
    <div class="container">
        <div class="content">
            <span class="d-flex justify-content-center">
                    <h1>Accueil administrateur</h1>
            </span>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Gestion des cursus</h5>
                            <p class="card-text">Gérer les différents cursus que les étudiants peuvent suivre dans votre école 🦺</p>
                            <a href="/administrateur/cursus" class="btn btn-secondary">Gérer les cursus</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Gestion des matières</h5>
                            <p class="card-text">Vous pouvez ajouter, modifier, supprimer ou simplement visualiser les matières enseignées par vos professeurs 🏫</p>
                            <a href="/administrateur/matieres" class="btn btn-secondary">Gérer les matières</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Gestion des étudiants</h5>
                            <p class="card-text">Permet de visualiser, ajouter, modifier ou encore supprimer des étudiants 🧑🏼‍🏫</p>
                            <a href="/administrateur/etudiants" class="btn btn-secondary">Gérer les étudiants</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Gestion des professeurs</h5>
                            <p class="card-text">Grâce à cette partie vous pouvez gérer les professeurs au sein de votre établissement 🎒</p>
                            <a href="/administrateur/professeurs" class="btn btn-secondary">Gérer les professeurs</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Gestion des administrateurs</h5>
                            <p class="card-text">Dans cet interface vous pourrez gérer les comptes administrateurs de l'application 🔐</p>
                            <a href="/administrateur/administrateurs" class="btn btn-secondary">Gérer les administrateurs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once COMMON . DS . 'footer.php' ?>
</body>

</HTML>