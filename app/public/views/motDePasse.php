<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON . DS . 'header.php' ?>

<body>
    <?php require_once COMMON . DS . 'navbar.php' ?>
   
    <div class="container">
        <div class="content">
            <span class="d-flex justify-content-between">
                <span style="width: 8%"></span>
                <h1>Changer de mot de passe</h1>
                <a href="/compte" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
            </span>
            <?if(isset($_SESSION["error"]) && $_SESSION["error"] !== ""){
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>".
                    $_SESSION['error'].
                 "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                  </div>"; 
                unset($_SESSION["error"]);
                
            }?>

            <form action="" method="POST">
                
                <!-- Old Password -->
                <div class="mb-3">
                    <label for="oldPassword" class="form-label">Ancien mot de passe</label>
                    <input type="password" class="form-control" id="oldPassword" aria-describedby="oldPasswordHelp" name="oldPassword" required/>
                    <div id="oldPasswordHelp" class="form-text">Mot de passe actuel</div>
                </div>
                
                <!-- New  Password -->
                <div class="mb-3">
                    <label for="newPassword" class="form-label">Nouveau mot de passe</label>
                    <input type="password" class="form-control" id="newPassword" aria-describedby="newPasswordHelp" name="newPassword" required/>
                    <div id="newPasswordHelp" class="form-text">Entrez un nouveau de mot de passe</div>
                </div>
                
                <!-- Confirmation New Password -->
                <div class="mb-3">
                    <label for="newPasswordConfirm" class="form-label">Confirmation mot de passe</label>
                    <input type="password" class="form-control" id="newPasswordConfirm" aria-describedby="newPasswordConfirmHelp" name="newPasswordConfirm" required/>
                    <div id="newPasswordConfirmHelp" class="form-text">Confirmer le mot de passe</div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg" name="ChangePassword">Changer le mot de passe</button>
                </div>

            </form>
        </div>
    </div>
    <?unset($_SESSION["old"]);?>
    <?php require_once COMMON . DS . 'footer.php' ?>
</body>

</HTML>