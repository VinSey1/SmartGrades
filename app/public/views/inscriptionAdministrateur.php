<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON . DS . 'header.php' ?>

<body>
    <?php require_once COMMON . DS . 'navbar.php' ?>

    <? $hasOldData = isset($_SESSION["old"]) && !empty($_SESSION["old"]); ?>

    <div class="container">
        <div class="content">
            <span class="d-flex justify-content-between">
                <span style="width: 8%"></span>
                <h1>Creation d'un administrateur</h1>
                <a href="/administrateur/administrateurs" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
            </span>

            <? if (isset($_SESSION["error"]) && $_SESSION["error"] !== "") {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>" .
                    $_SESSION['error'] .
                    "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                  </div>";
                unset($_SESSION["error"]);
            } else if (isset($_SESSION["success"]) && $_SESSION["success"] !== "") {
                echo "<div class=\"alert alert-success alert-dismissible fade show\" role='alert'>" .
                    $_SESSION['success'] . "
                        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                      </div>";
                unset($_SESSION["success"]);
            } ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label for="nomInput" class="form-label">Nom</label>
                    <input type="text" class="form-control <?php if (in_array('nom', $arrayInvalide)) echo 'is-invalid' ?>" id="prenomInput" name="nom" value="<? if ($hasOldData) echo $_SESSION["old"]["nom"]; ?>">
                    <div class="
                         <?php if (in_array('nom', $arrayInvalide)) {
                                echo 'invalid';
                            } else {
                                echo 'displayNone';
                            } ?>">
                        Veuillez entrer un nom de famille.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="prenomInput" class="form-label">Prénom</label>
                    <input type="text" class="form-control <?php if (in_array('prenom', $arrayInvalide)) echo 'is-invalid' ?>" id=" prenomInput" name="prenom" value="<? if ($hasOldData) echo $_SESSION["old"]["prenom"]; ?>">
                    <div class="
                         <?php if (in_array('prenom', $arrayInvalide)) {
                                echo 'invalid';
                            } else {
                                echo 'displayNone';
                            } ?>">
                        Veuillez entrer un prénom.
                    </div>
                </div>


                <div class="mb-3">
                    <label for="studentEmail" class="form-label">Adresse email</label>
                    <input type="email" class="form-control <?php if (in_array('email', $arrayInvalide)) echo 'is-invalid' ?>" id=" studentEmail" aria-describedby="emailHelp" name="email" value="<? if ($hasOldData) echo $_SESSION["old"]["email"]; ?>">
                    <div class="
                         <?php if (in_array('email', $arrayInvalide)) {
                                echo 'invalid';
                            } else {
                                echo 'displayNone';
                            } ?>">
                        Veuillez entrer un email.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="inputDate" class="form-label">Date de naissance</label>
                    <input type="date" class="form-control <?php if (in_array('date_naissance', $arrayInvalide)) echo 'is-invalid' ?>" id="inputDate" name="date_naissance" value="<? if ($hasOldData) echo $_SESSION["old"]["date_naissance"]; ?>" max="<? echo date("Y-m-d"); ?>">
                    <div class="
                         <?php if (in_array('date_naissance', $arrayInvalide)) {
                                echo 'invalid';
                            } else {
                                echo 'displayNone';
                            } ?>">
                        Veuillez entrer une date JJ/MM/AAAA.
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="submitCreateAdministrateur">Créer</button>
                </div>

            </form>
        </div>
    </div>
    <? unset($_SESSION["old"]); ?>
    <?php require_once COMMON . DS . 'footer.php' ?>
</body>

</HTML>

<style>
    .displayNone {
        display: none !important;
    }

    .invalid {
        width: 100%;
        font-size: .875em;
        color: #dc3545;
    }
</style>