<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON.DS.'header.php' ?>
    <body>
        <?php require_once COMMON.DS.'navbar.php' ?>
        <div class="container">
            <div class="content">
                <span class="d-flex justify-content-between">
                    <span style="width: 8%"></span>
                    <h1><?= $_POST['titrePage'] ?> d'une matiere</h1>
                    <a href="/<?=$_SESSION["user"]->role?>/matieres" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
                </span>
                <?php if (!empty($_POST['erreur'])) echo "<div class='alert alert-danger' role='alert'>".$_POST['erreur']."</div>"; ?>
                <form method="POST">
                    <input type="hidden" name="titrePage" value="<?= $_POST['titrePage'] ?>">
                    <div class="form-group mb-2">
                        <label>Année scolaire</label>
                        <input name="promotion" type="text" class="form-control <?= $_POST['validationPromotion'] ?>" value="<?= $_POST['promotion'] ?>" <?php if ($_SESSION['codeOperation'] == 3) echo "readonly"; ?>>
                        <div class="invalid-feedback">Format incorrect !</div>
                        <small class="form-text text-muted">Assurez-vous de renseigner l'année sous format qui va bien (AAAA-AAAA) !</small>
                    </div>
                    <div class="form-group mb-2">
                        <label>Nom de la matière</label>
                        <input name="nom" type="text" class="form-control <?= $_POST['validationNom'] ?>" placeholder="Donnez le nom de la matière..." value="<?= $_POST['nom'] ?>" <?php if ($_SESSION['codeOperation'] == 3) echo "readonly"; ?>>
                        <small class="form-text text-muted">Cet intitulé sera visible par tout le monde ! Veuillez à choisir un nom suffisamment parlant (notre conseil : AAAA-AAAA + nom de la matière) !</a></small>
                    </div>
                    <div class="form-group mb-2">
                        <label>Description de la matière</label>
                        <textarea name="description" type="text" class="form-control" placeholder="Saisissez une brève description..." <?php if ($_SESSION['codeOperation'] == 3) echo "readonly"; ?>><?= $_POST['description'] ?></textarea>
                    </div>
                    <?php if ($_SESSION['codeOperation'] != 3) { ?>
                        <div class="form-group mb-2">
                            <label>Étudiants participants</label>
                            <div class="row">
                                <div class="col pe-1">
                                    <select id="extraSelectPicker" class="selectpicker form-control" data-live-search="true" title="Choisissez un cursus pour séléctionner ses étudiants...">
                                        <?php
                                            foreach ($_SESSION['classes'] as $classe)
                                                echo "<option value=".$classe->id.">".$classe->promotion." (".$classe->intitule.")"."</option>";
                                        ?>
                                    </select>
                                    <input id="extraSelectPickerHelper" type="hidden" value="<?= $_SESSION['listeEtudiantsParClasse'] ?>">
                                </div>
                                <div class="col ps-1">
                                    <select id="selectPicker" class="selectpicker form-control" multiple data-live-search="true">
                                        <?php
                                            foreach ($_SESSION['etudiants'] as $etudiant)
                                                echo "<option value=".$etudiant->id.">".$etudiant->user->name." ".$etudiant->user->surname."</option>";
                                        ?>
                                    </select>
                                    <input id="selectPickerHelper" type="hidden" name="listeEtudiants" value="<?= $_POST['listeEtudiants'] ?>">
                                </div>
                                <small class="form-text text-muted">Servez-vous de la fonctionnalité de recherche !</small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Professeurs enseignants</label>
                            <select id="extraExtraSelectPicker" class="selectpicker form-control" multiple data-live-search="true">
                                <?php
                                    foreach ($_SESSION['professeurs'] as $professeur) {
                                        if ($professeur == $_SESSION["user"]->professeur)
                                            echo "<option value=".$professeur->id." disabled selected>".$professeur->user->name." ".$professeur->user->surname."</option>";
                                        else
                                            echo "<option value=".$professeur->id.">".$professeur->user->name." ".$professeur->user->surname."</option>";
                                    }
                                ?>
                            </select>
                            <input id="extraExtraSelectPickerHelper" type="hidden" name="listeProfesseurs" value="<?= $_POST['listeProfesseurs'] ?>">
                            <small class="form-text text-muted">Plusieurs professeurs peuvent enseigner le même cursus !</small>
                        </div>
                        <button name="titreBouton" value="<?= $_POST['titreBouton'] ?>" type="submit" class="btn <?= explode("/", $_POST['titreBouton'])[1] ?>"><?= explode("/", $_POST['titreBouton'])[0] ?></button>
                    <?php } else { ?>
                        <label>Étudiants participants :</label>
                        <ul class="mb-2">
                            <?php
                                $idsEtudiantsClasse = json_decode(base64_decode($_POST['listeEtudiants']), true);
                                if (count($idsEtudiantsClasse) > 0)
                                    foreach ($_SESSION['etudiants'] as $etudiant) {
                                        if (in_array($etudiant->id, $idsEtudiantsClasse))
                                            echo "<li>".$etudiant->user->name." ".$etudiant->user->surname."</li>";
                                    }
                                else
                                    echo "<li>Aucun !</li>";
                            ?>
                        </ul>
                        <label>Professeurs enseignants :</label>
                        <ul class="mb-0">
                            <?php
                                $idsProfsResp = json_decode(base64_decode($_POST['listeProfesseurs']), true);
                                if (count($idsProfsResp) > 0)
                                    foreach ($_SESSION['professeurs'] as $professeur) {
                                        if (in_array($professeur->id, $idsProfsResp))
                                            echo "<li>".$professeur->user->name." ".$professeur->user->surname."</li>";
                                } else
                                    echo "<li>Aucun !</li>";
                            ?>
                        </ul>
                    <?php } ?>
                </form>
            </div>
        </div>
        <?php if ($_SESSION['codeOperation'] != 3) { ?>
            <script>
                // Petit script qui va faire l'interface avec le champ bootstrap-select
                (function() {
                    var timer = setInterval(function() {
                        if (window.jQuery) {
                            // Mise en place des valeurs séléctionnés
                            if ($('#selectPickerHelper').val() != "")
                                $('#selectPicker').selectpicker('val', JSON.parse(atob($('#selectPickerHelper').val())));
                            if ($('#extraExtraSelectPickerHelper').val() != "")
                                $('#extraExtraSelectPicker').selectpicker('val', JSON.parse(atob($('#extraExtraSelectPickerHelper').val())));
                            // Callback à exécuter quand on soumet le formulaire
                            $(document).on('submit', 'form', function() {
                                $('#selectPickerHelper').val(btoa(JSON.stringify($('#selectPicker').val())));
                            });
                            $(document).on('submit', 'form', function(e) {
                                $('#extraExtraSelectPickerHelper').val(btoa(JSON.stringify($('#extraExtraSelectPicker').val())));
                            });
                            // Mise en place de plusieurs étudiants à la fois quand une classe a été choisie
                            $('#extraSelectPicker').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                                let etudiantsParClasse = JSON.parse(atob($('#extraSelectPickerHelper').val()));
                                etudiantsParClasse.forEach((element) => {
                                    if (element.id == $('#extraSelectPicker').val()) {
                                        // Faudra rajouter ces ids à la séléction actuelle
                                        let nouvelleSelection = $('#selectPicker').val().concat(element.idsEtudiants);
                                        if (confirm("Confirmez-vous vouloir séléctionner tous les étudiants faisant partie de ce cursus ?")) {
                                            $('#selectPicker').selectpicker('val', nouvelleSelection);
                                        }
                                    }
                                });
                            });
                            clearInterval(timer);
                        }
                    }, 100);
                })();
            </script>
        <?php } ?>
        <?php require_once COMMON.DS.'footer.php' ?>
    </body>
</HTML>