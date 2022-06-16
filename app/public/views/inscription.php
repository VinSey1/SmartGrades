<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON.DS.'header.php' ?>
    <body>
        <?php require_once COMMON.DS.'navbar.php' ?>
        <div class="container">
            <div class="content">
                <span class="d-flex justify-content-between">
                    <span style="width: 8%"></span>
                    <h1>Inscription</h1>
                    <a href="/" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
                </span>
                <?php if (!empty($_SESSION['erreur'])) echo "<div class='alert alert-danger' role='alert'>".$_SESSION['erreur']."</div>"; ?>
                <form action="" method="POST">
                    <div class="form-group mb-2">
                        <label for="exampleInputEmail1">Adresse mail</label>
                        <input name="username" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Donnez votre adresse mail...">
                        <small id="emailHelp" class="form-text text-muted">Votre nom d'utilisateur sera le même !</small>
                    </div>
                    <div class="form-group mb-2">
                        <label for="exampleInputPassword1">Mot de passe</label>
                        <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Tapez le mot de passe...">
                        <input name="repassword" type="password" class="form-control mt-2" id="exampleInputPassword1" placeholder="Retapez le mot de passe...">
                    </div>
                    <div class="form-group mb-2">
                        <label for="exampleInputType1">Type de l'utilisateur</label>
                        <select name="type" class="form-select" id="exampleInputType1">
                            <option selected>Choisissez une option...</option>
                            <option value="professeur">Professeur</option>
                            <option value="etudiant">Étudiant</option>
                            <option value="administrateur">Administrateur</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="exampleInputNom1">Nom</label>
                        <input name="nom" type="text" class="form-control" id="exampleInputNom1" aria-describedby="nomHelp" placeholder="Donnez votre nom de famille...">
                        <small id="nomHelp" class="form-text text-muted">Il faut donner le vrai !</small>
                    </div>
                    <div class="form-group mb-2">
                        <label for="exampleInputPrenom1">Prénom</label>
                        <input name="prenom" type="text" class="form-control" id="exampleInputPrenom1" placeholder="Donnez votre prénom...">
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleInputDate1">Date de naissance</label>
                        <input name="date" type="date" class="form-control" id="exampleInputDate1">
                    </div>
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                </form>
            </div>
        </div>
        <?php require_once COMMON.DS.'footer.php' ?>
    </body>
</HTML>