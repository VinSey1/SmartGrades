<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON . DS . 'header.php' ?>

<body>
    <?php require_once COMMON . DS . 'navbar.php' ?>
    <div class="container">
        <div class="content">
            <?php if ($user->role == "etudiant") { ?>
                <span class="d-flex justify-content-between">
                    <span style="width: 8%"></span>
                    <h1>modification d'un etudiant</h1>
                    <a href="/administrateur/etudiants" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
                </span>
            <?php
                $person = $etudiant;
            } else if ($user->role == "professeur") { ?>
                <span class="d-flex justify-content-between">
                    <span style="width: 8%"></span>
                    <h1>modification d'un professeur</h1>
                    <a href="/administrateur/professeurs" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
                </span>
            <?php
                $person = $professeur;
            } else if ($user->role == "administrateur") { ?>
                <span class="d-flex justify-content-between">
                    <span style="width: 8%"></span>
                    <h1>modification d'un administrateur</h1>
                    <a href="/administrateur/administrateurs" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
                </span>
            <?php
                $person = $administrateur;
            } ?>
            <h3>Profil de <?= ucfirst($user->name) ?> <?= strtoupper($user->surname) ?> </h3>
            <hr />
            <?php if (isset($arrayInvalide) && in_array('erreurUpdate', $arrayInvalide)) echo "<div class='alert alert-danger' role='alert'>Une erreur est survenue veuillez soumettre à nouveau le formulaire</div>"; ?>
            <form method="POST">
                <div class="d-flex flex-column flex-md-row justify-content-around">
                    <div class="d-flex flex-column">
                        <p>
                            <b>Nom de famille:</b>
                            <input class="form-control <?php if (in_array('surname', $arrayInvalide)) echo 'is-invalid' ?>" name="surname" value="<?= $_POST["surname"] ? $_POST["surname"] : $user->surname ?>">
                        <div class="
                         <?php if (in_array('surname', $arrayInvalide)) {
                                echo 'invalid';
                            } else {
                                echo 'displayNone';
                            } ?>">
                            Veuillez entrer un nom de famille.
                        </div>
                        </p>
                        <p>
                            <b>Prénom:</b>
                            <input class="form-control <?php if (in_array('name', $arrayInvalide)) echo 'is-invalid' ?>" name="name" value="<?= $_POST["name"] ? $_POST["name"] : $user->name; ?>">
                        <div class="
                         <?php if (in_array('name', $arrayInvalide)) {
                                echo 'invalid';
                            } else {
                                echo 'displayNone';
                            } ?>">
                            Veuillez entrer un prénom.
                        </div>
                        </p>
                    </div>
                    <div class="d-flex flex-column">
                        <p>
                            <b>Email:</b>
                            <input class="form-control <?php if (in_array('email', $arrayInvalide)) echo 'is-invalid' ?>" type="email" name="email" value="<?= $_POST["email"] ? $_POST["email"] : $user->email ?>">
                        <div class="
                         <?php if (in_array('email', $arrayInvalide)) {
                                echo 'invalid';
                            } else {
                                echo 'displayNone';
                            } ?>">
                            Veuillez entrer un email.
                        </div>
                        </p>
                        <p>
                            <b>Date de naissance:</b>
                            <input class="form-control <?php if (in_array('date_naissance', $arrayInvalide)) echo 'is-invalid' ?>" type="date" name="date_naissance" value="<?= $_POST["date_naissance"] ? $_POST["date_naissance"] : $user->date_naissance ?>">
                        <div class="
                         <?php if (in_array('date_naissance', $arrayInvalide)) {
                                echo 'invalid';
                            } else {
                                echo 'displayNone';
                            } ?>">
                            Veuillez entrer une date JJ/MM/AAAA.
                        </div>
                        </p>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <p>
                        <b>Role:</b>
                        <select id="role" name="role" class="form-select" <?php $_POST["role"] ? $leRole = $_POST["role"] : $leRole = $user->role ?>>
                            <option name="etudiant" <?php if ($leRole == "etudiant") echo "selected" ?>>etudiant</option>
                            <option name="professeur" <?php if ($leRole == "professeur") echo "selected" ?>>professeur</option>
                            <option name="administrateur" <?php if ($leRole == "administrateur") echo "selected" ?>>administrateur</option>
                        </select>
                    </p>
                </div>
                <div id="partieEtudiant" class="d-flex flex-column">
                    <p>
                        <b>Numéro étudiant:</b>
                        <input class="form-control <?php if (in_array('numero_etudiant', $arrayInvalide)) echo 'is-invalid' ?>" name="numero_etudiant" value="<?= $_POST["numero_etudiant"] ? $_POST["numero_etudiant"] : $person->numero_etudiant ?>">
                    <div class="
                         <?php if (in_array('numero_etudiant', $arrayInvalide)) {
                                echo 'invalid';
                            } else {
                                echo 'displayNone';
                            } ?>">
                        Veuillez entrer un numéro étudiant.
                    </div>
                    </p>
                    <p>
                    <p><b>Classe:</b></p>
                    <div>
                        <select id="selectPickerEC" class="selectpicker form-control" data-live-search="true">
                            <?php
                            foreach ($classes as $c)
                                echo "<option value=" . $c->id . ">" . $c->promotion . " (" . $c->intitule . ") " . $c->anneeScolaire->intitule . "</option>";
                            ?>
                        </select>
                        <input id="selectPickerHelperEC" type="hidden" name="laClasseSelectedE" value="<?= $_POST['laClasseSelectedE'] ?>">
                    </div>
                    </p>
                    <p>
                    <p><b>Matières:</b></p>
                    <div>
                        <select id="selectPickerEM" class="selectpicker form-control" multiple data-live-search="true">
                            <?php
                            foreach ($matieres as $m)
                                echo "<option value=" . $m->id . ">" . $m->name_matiere . " (" . $m->description_matiere . ") " . $m->anneeScolaire->intitule . "</option>";
                            ?>
                        </select>
                        <input id="selectPickerHelperEM" type="hidden" name="listeMatieresSelectedE" value="<?= $_POST['listeMatieresSelectedE'] ?>">
                    </div>
                    </p>

                    <p>
                        <b>Identifiant GitLab:</b>
                        <input class="form-control <?php if (in_array('id_gitlab_etudiant', $arrayInvalide)) echo 'is-invalid' ?>" name="id_gitlab_etudiant" value="<?= $_POST["id_gitlab_etudiant"] ? $_POST["id_gitlab_etudiant"] : $person->id_gitlab ?>">
                    <div class="
                         <?php if (in_array('id_gitlab_etudiant', $arrayInvalide)) {
                                echo 'invalid';
                            } else {
                                echo 'displayNone';
                            } ?>">
                        Veuillez entrer un id gitlab pour l'étudiant.
                    </div>
                    </p>
                    <p>
                        <b>Tier temps:</b>
                        <select id="tier_temps" name="tier_temps" class="form-select" <?php $_POST["tier_temps"] ? $leTierTemps = $_POST["tier_temps"] : $leTierTemps = $person->tier_temps ?>>
                            <option name="oui" <?php if ($leTierTemps == 1) echo "selected" ?>>oui</option>
                            <option name="non" <?php if ($leTierTemps == 0) echo "selected" ?>>non</option>
                        </select>
                    </p>
                    <p>
                        <b>Cursus post BAC:</b>
                        <input class="form-control <?php if (in_array('cursus_postbac', $arrayInvalide)) echo 'is-invalid' ?>" name="cursus_postbac" value="<?= $_POST["cursus_postbac"] ? $_POST["cursus_postbac"] : $person->cursus_postbac ?>">
                    <div class="
                         <?php if (in_array('cursus_postbac', $arrayInvalide)) {
                                echo 'invalid';
                            } else {
                                echo 'displayNone';
                            } ?>">
                        Veuillez entrer un cursus postbac.
                    </div>
                    </p>
                    <p>
                        <b>Statut:</b>
                        <select id="statut" name="statut" class="form-select" <?php $_POST["statut"] ? $leStatut = $_POST["statut"] : $leStatut = $person->statut ?>>
                            <option <?php if ($leStatut == "Alternance") echo "selected" ?>>Alternance</option>
                            <option <?php if ($leStatut == "Non-assidu") echo "selected" ?>>Non-assidu</option>
                            <option <?php if ($leStatut == "Initial") echo "selected" ?>>Initial</option>
                        </select>
                    </p>
                </div>
                <div id="partieProfesseur" class="d-flex flex-column">
                    <p>
                        <b>Numéro professeur:</b>
                        <input class="form-control <?php if (in_array('numero_professeur', $arrayInvalide)) echo 'is-invalid' ?>" name="numero_professeur" value="<?= $_POST["numero_professeur"] ? $_POST["numero_professeur"] : $person->numero_professeur ?>">
                    <div class="
                         <?php if (in_array('numero_professeur', $arrayInvalide)) {
                                echo 'invalid';
                            } else {
                                echo 'displayNone';
                            } ?>">
                        Veuillez entrer un numéro professeur.
                    </div>
                    </p>
                    <p>
                        <b>Identifiant GitLab:</b>
                        <input class="form-control <?php if (in_array('id_gitlab_professeur', $arrayInvalide)) echo 'is-invalid' ?>" name="id_gitlab_professeur" value="<?= $_POST["id_gitlab_professeur"] ? $_POST["id_gitlab_professeur"] : $person->id_gitlab ?>">
                    <div class="
                         <?php if (in_array('id_gitlab_professeur', $arrayInvalide)) {
                                echo 'invalid';
                            } else {
                                echo 'displayNone';
                            } ?>">
                        Veuillez entrer un id gitlab pour le professeur.
                    </div>

                    <p><b>Ses classes:</b></p>
                    <div>
                        <select id="selectPickerPC" class="selectpicker form-control" multiple data-live-search="true">
                            <?php
                            foreach ($classes as $c)
                                echo "<option value=" . $c->id . ">" . $c->promotion . " (" . $c->intitule . ") " . $c->anneeScolaire->intitule . "</option>";
                            ?>
                        </select>
                        <input id="selectPickerHelperPC" type="hidden" name="listeClassesSelectedP" value="<?= $_POST['listeClassesSelectedP'] ?>">
                    </div>

                    <p><b>Ses matières:</b></p>
                    <div>
                        <select id="selectPickerPM" class="selectpicker form-control" multiple data-live-search="true">
                            <?php
                            foreach ($matieres as $m)
                                echo "<option value=" . $m->id . ">" . $m->name_matiere . " (" . $m->description_matiere . ") " . $m->anneeScolaire->intitule . "</option>";
                            ?>
                        </select>
                        <input id="selectPickerHelperPM" type="hidden" name="listeMatieresSelectedP" value="<?= $_POST['listeMatieresSelectedP'] ?>">
                    </div>
                    </p>
                </div>
        </div>

        <div class="text-center">
            <button name="mettreAJour" class="btn btn-primary text-center" type="submit">Mettre à jour</button>
        </div>
        </form>
    </div>
    </div>
    <script>
        // Petit script qui va faire l'interface avec le champ bootstrap-select
        (function() {
            var timer = setInterval(function() {
                if (window.jQuery) {
                    //----------partie etudiant----------
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

                    //----------partie prof----------
                    // Mise en place des valeurs séléctionnés
                    if ($('#selectPickerHelperPC').val() != "")
                        $('#selectPickerPC').selectpicker('val', JSON.parse(atob($('#selectPickerHelperPC').val())));
                    // Callback à exécuter quand on soumet le formulaire
                    $(document).on('submit', 'form', function() {
                        $('#selectPickerHelperPC').val(btoa(JSON.stringify($('#selectPickerPC').val())));
                    });

                    // Mise en place des valeurs séléctionnés
                    if ($('#selectPickerHelperPM').val() != "")
                        $('#selectPickerPM').selectpicker('val', JSON.parse(atob($('#selectPickerHelperPM').val())));
                    // Callback à exécuter quand on soumet le formulaire
                    $(document).on('submit', 'form', function() {
                        $('#selectPickerHelperPM').val(btoa(JSON.stringify($('#selectPickerPM').val())));
                    });
                    clearInterval(timer);
                }
            }, 100);
        })();
    </script>
    <?php require_once COMMON . DS . 'footer.php' ?>
</body>

</HTML>

<script>
    const printVisible = (idElement) => {
        document.getElementById(idElement).classList.remove("displayNone");
        document.getElementById(idElement).classList.add("displayVisible");
    }

    const printNone = (idElement) => {
        document.getElementById(idElement).classList.remove("displayVisible");
        document.getElementById(idElement).classList.add("displayNone");
    }

    const changePartieRole = (e) => {
        let role = document.getElementById('role').value;
        if (role === "etudiant") {
            printVisible("partieEtudiant");
            printNone("partieProfesseur");
        }
        if (role === "professeur") {
            printNone("partieEtudiant");
            printVisible("partieProfesseur");

        }
        if (role === "administrateur") {
            printNone("partieEtudiant");
            printNone("partieProfesseur");
        }
    }

    window.onload = changePartieRole();
    document.getElementById('role').addEventListener('change', changePartieRole);
</script>

<style>
    .displayVisible {
        display: visible;
    }

    .displayNone {
        display: none !important;
    }

    .invalid {
        width: 100%;
        font-size: .875em;
        color: #dc3545;
    }
</style>