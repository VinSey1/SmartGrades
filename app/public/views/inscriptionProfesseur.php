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
                <h1>Creation d'un professeur</h1>
                <a href="/administrateur/professeurs" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
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
                    <label for="studentEmail" class="form-label">Addresse email</label>
                    <input type="email" class="form-control <?php if (in_array('email', $arrayInvalide)) echo 'is-invalid' ?>" id=" studentEmail" aria-describedby="emailHelp" name="email" value="<? if ($hasOldData) echo $_SESSION["old"]["email"]; ?>">
                    <div id="emailHelp" class="form-text">Email UHA(ou universitaire) du professeur</div>
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

                <div class="mb-3">
                    <label for="inputNumProfesseur" class="form-label">Numéro Professeur</label>
                    <input type="text" class="form-control <?php if (in_array('numero_professeur', $arrayInvalide)) echo 'is-invalid' ?>" id="inputNumProfesseur" name="numero_professeur" value="<? if ($hasOldData) echo $_SESSION["old"]["numero_professeur"]; ?>">
                    <div class="
                         <?php if (in_array('numero_professeur', $arrayInvalide)) {
                                echo 'invalid';
                            } else {
                                echo 'displayNone';
                            } ?>">
                        Veuillez entrer un numéro professeur.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="inputIdGitlab" class="form-label">Identifiant GitLab</label>
                    <input type="text" class="form-control <?php if (in_array('id_gitlab', $arrayInvalide)) echo 'is-invalid' ?>" id="inputIdGitlab" name="id_gitlab" aria-describedby="gitlabHelp" value="<? if ($hasOldData && $_SESSION["old"]["id_gitlab"] !== null) echo $_SESSION["old"]["id_gitlab"]; ?>">
                    <div class="
                         <?php if (in_array('id_gitlab', $arrayInvalide)) {
                                echo 'invalid';
                            } else {
                                echo 'displayNone';
                            } ?>">
                        Veuillez entrer un id gitlab pour le professeur.
                    </div>
                </div>
                <div class="mb-3">
                    <p>Ses classes</p>
                    <div>
                        <select id="selectPickerC" class="selectpicker form-control" multiple data-live-search="true">
                            <?php
                                foreach ($classes as $c) 
                                    echo "<option value=".$c->id.">".$c->promotion." (".$c->intitule.") ".$c->anneeScolaire->intitule."</option>";
                            ?>
                        </select>
                        <input id="selectPickerHelperC" type="hidden" name="listeClassesSelectedP" value="<?= $_POST['listeClassesSelectedP'] ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <p>Ses matières</p>
                    <div>
                        <select id="selectPickerM" class="selectpicker form-control" multiple data-live-search="true">
                            <?php
                                foreach ($matieres as $m) 
                                    echo "<option value=".$m->id.">".$m->name_matiere." (".$m->description_matiere.") ".$m->anneeScolaire->intitule."</option>";
                            ?>
                        </select>
                        <input id="selectPickerHelperM" type="hidden" name="listeMatieresSelectedP" value="<?= $_POST['listeMatieresSelectedP'] ?>">
                    </div>
                </div>
                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="submitCreateProfesseur">Créer</button>
                </div>

            </form>
        </div>
    </div>
    <? unset($_SESSION["old"]); ?>
    <script>
        // Petit script qui va faire l'interface avec le champ bootstrap-select
        (function() {
            var timer = setInterval(function() {
                if (window.jQuery) {
                    // Mise en place des valeurs séléctionnés
                    if ($('#selectPickerHelperC').val() != "")
                        $('#selectPickerC').selectpicker('val', JSON.parse(atob($('#selectPickerHelperC').val())));
                    // Callback à exécuter quand on soumet le formulaire
                    $(document).on('submit', 'form', function() {
                        $('#selectPickerHelperC').val(btoa(JSON.stringify($('#selectPickerC').val())));
                    });

                    // Mise en place des valeurs séléctionnés
                    if ($('#selectPickerHelperM').val() != "")
                        $('#selectPickerM').selectpicker('val', JSON.parse(atob($('#selectPickerHelperM').val())));
                    // Callback à exécuter quand on soumet le formulaire
                    $(document).on('submit', 'form', function() {
                        $('#selectPickerHelperM').val(btoa(JSON.stringify($('#selectPickerM').val())));
                    });
                    clearInterval(timer);
                }
            }, 100);
        })();
    </script>
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