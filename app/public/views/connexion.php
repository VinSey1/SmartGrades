<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON.DS.'header.php' ?>
    <body>
        <?php require_once COMMON.DS.'navbar.php' ?>
        <div class="container">
            <div class="content">
                <span class="d-flex justify-content-between">
                    <span style="width: 8%"></span>
                    <h1>Connexion</h1>
                    <a href="/" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
                </span>
                <?php if (!empty($_SESSION['erreur'])) echo "<div class='alert alert-danger' role='alert'>".$_SESSION['erreur']."</div>"; unset($_SESSION["erreur"]);?>
                <?
                if(isset($_SESSION["success"]) && $_SESSION["success"] !== ""){
                    echo "<div class=\"alert alert-success alert-dismissible fade show\" role='alert'>".
                            $_SESSION['success']."
                            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                          </div>";
                    unset($_SESSION["success"]);
                }
                ?>
                <form action="" method="POST">
                    <div class="form-group mb-2">
                        <label for="exampleInputEmail1">Nom d'utilisateur</label>
                        <input name="username" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Donnez votre nom d'utilisateur...">
                        <small id="emailHelp" class="form-text text-muted">Vous avez la liberté de choisir n'importe quel !</small>
                    </div>
                    <div class="form-group mb-2">
                        <label for="exampleInputPassword1">Mot de passe</label>
                        <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Tapez le mot de passe...">
                    </div>
                    <div class="form-group form-check mb-3">
                        <input name="subscribe" type="checkbox" checked="checked" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Ne m'oublie pas :(</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </form>
                <br>
                <a class="btn btn-outline-danger" href="./motDePasseOublie" role="button"><i class="bi bi-key-fill"></i> Mot de passe oublié ?</a>
            </div>
        </div>
        <?php require_once COMMON.DS.'footer.php' ?>
    </body>
</HTML>