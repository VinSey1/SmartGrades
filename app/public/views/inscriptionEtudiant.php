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
                <h1>Creation d'un etudiant</h1>
                <a href="/administrateur/etudiants" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
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
                    <div id="emailHelp" class="form-text">Email UHA(ou universitaire) de l'étudiant</div>
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
                    <label for="inputNumEtudiant" class="form-label">Numéro Etudiant</label>
                    <input type="text" class="form-control <?php if (in_array('numero_etudiant', $arrayInvalide)) echo 'is-invalid' ?>" id="inputNumEtudiant" name="numero_etudiant" value="<? if ($hasOldData) echo $_SESSION["old"]["numero_etudiant"]; ?>">
                    <div class="
                         <?php if (in_array('numero_etudiant', $arrayInvalide)) {
                                echo 'invalid';
                            } else {
                                echo 'displayNone';
                            } ?>">
                        Veuillez entrer un numéro étudiant.
                    </div>
                </div>

                <div class="mb-3">
                    <p>Classe:</p>
                    <div>
                        <select id="selectPickerEC" class="selectpicker form-control" data-live-search="true">
                            <?php
                            foreach ($classes as $c)
                                echo "<option value=" . $c->id . ">" . $c->promotion . " (" . $c->intitule . ") " . $c->anneeScolaire->intitule . "</option>";
                            ?>
                        </select>
                        <input id="selectPickerHelperEC" type="hidden" name="laClasseSelectedE" value="<?php if($hasOldData){ echo $_SESSION["old"]["laClasseSelectedE"];} ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <p>Matières:</p>
                    <div>
                        <select id="selectPickerEM" class="selectpicker form-control" multiple data-live-search="true">
                            <?php
                            foreach ($matieres as $m)
                                echo "<option value=" . $m->id . ">" . $m->name_matiere . " (" . $m->description_matiere . ") " . $m->anneeScolaire->intitule . "</option>";
                            ?>
                        </select>
                        <input id="selectPickerHelperEM" type="hidden" name="listeMatieresSelectedE" value="<?php if($hasOldData){ echo $_SESSION["old"]["listeMatieresSelectedE"];} ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="inputIdGitlab" class="form-label">Identifiant GitLab</label>
                    <input type="text" class="form-control" id="inputIdGitlab" name="id_gitlab" aria-describedby="gitlabHelp" value="<? if ($hasOldData && $_SESSION["old"]["id_gitlab"] !== null) echo $_SESSION["old"]["id_gitlab"]; ?>">
                    <div id="gitlabHelp" class="form-text">Peut être renseigné après inscription</div>
                </div>

                <div class="mb-3">
                    <label for="tierTemps" class="form-label">Tier temps</label>
                    <select name="tier_temps" id="tierTemps" class="form-select">
                        <option value="oui" <? if ($hasOldData && $_SESSION["old"]["tierTemps"] === "oui") echo "selected" ?>>
                            Oui
                        </option>

                        <option value="non" <? if ($hasOldData && $_SESSION["old"]["tierTemps"] === "non") echo "selected" ?>>
                            Non
                        </option>
                    </select>

                </div>

                <div class="mb-3">
                    <label for="inputCursusPostBac" class="form-label">Cursus Post bac</label>
                    <textarea class="form-control" id="inputCursusPostBac" style="height: 100px" name="cursus_postbac"></textarea>
                </div>

                <div class="mb-3">
                    <label for="inputStatutEtudiant" class="form-label">Statut de l'étudiant</label>
                    <select name="statut" id="inputStatutEtudiant" class="form-select">

                        <option value="initial" <? if ($hasOldData && $_SESSION["old"]["statut"] === "initial") echo "selected" ?>>
                            Initial
                        </option>
                        <option value="alternance" <? if ($hasOldData && $_SESSION["old"]["statut"] === "alternant") echo "selected" ?>>
                            Alternance
                        </option>
                        <option value="non-assidu" <? if ($hasOldData && $_SESSION["old"]["statut"] === "non-assidu") echo "selected" ?>>
                            Non Assidu
                        </option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="submitCreateEtudiant">Créer</button>
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
                    if ($('#selectPickerHelperEC').val() != "")
                        $('#selectPickerEC').selectpicker('val', JSON.parse(atob($('#selectPickerHelperEC').val())));
                    // Callback à exécuter quand on soumet le formulaire
                    $(document).on('submit', 'form', function() {
                        $('#selectPickerHelperEC').val(btoa(JSON.stringify($('#selectPickerEC').val())));
                    });

                    // Mise en place des valeurs séléctionnés
                    if ($('#selectPickerHelperEM').val() != "")
                        $('#selectPickerEM').selectpicker('val', JSON.parse(atob($('#selectPickerHelperEM').val())));
                    // Callback à exécuter quand on soumet le formulaire
                    $(document).on('submit', 'form', function() {
                        $('#selectPickerHelperEM').val(btoa(JSON.stringify($('#selectPickerEM').val())));
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