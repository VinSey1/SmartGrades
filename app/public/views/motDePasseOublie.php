<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON . DS . 'header.php' ?>

<body>
    <?php require_once COMMON . DS . 'navbar.php' ?>
   
    <div class="container">
        <div class="content">
            <span class="d-flex justify-content-between">
                <span style="width: 8%"></span>
                <h1>Recuperer le mot de passe</h1>
                <a href="/" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
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
                    <label for="emailReceiver" class="form-label">Adresse Email</label>
                    <input type="email" class="form-control" id="emailReceiver" aria-describedby="emailReceiverHelp" name="emailReceiver" required/>
                    <div id="emailReceiverHelp" class="form-text">L'adresse email recevant un nouveau mot de passe</div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg" name="sendMail">Envoyer le mail &nbsp;<i class="bi bi-envelope-check"></i></button>
                </div>

            </form>
        </div>
    </div>
    <?php require_once COMMON . DS . 'footer.php' ?>
</body>

</HTML>