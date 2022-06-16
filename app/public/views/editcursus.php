<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON.DS.'header.php' ?>
    <body>
        <?php require_once COMMON.DS.'navbar.php' ?>
        <div class="container">
            <div class="content">
                <span class="d-flex justify-content-between">
                    <span style="width: 8%"></span>
                    <h1><?= $_POST['titrePage'] ?> d'un cursus</h1>
                    <a href="/<?=$_SESSION["user"]->role?>/cursus" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
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
                        <label>Intitulé du cursus</label>
                        <?php if ($_SESSION['codeOperation'] != 3) { ?>
                            <div class="row">
                                <div class="col pe-1">
                                    <select name="cursusExistant" class="form-select <?= $_POST['validationCursusExistant'] ?>">
                                        <?php
                                            if (!empty($_POST['cursusExistant']))
                                                echo "<option value=''>Choisir un cursus existant...</option>";
                                            else
                                                echo "<option value='' selected>Choisir un cursus existant...</option>";
                                            foreach ($_SESSION['cursusExistants'] as $cursusExistant)
                                                if (!empty($_POST['cursusExistant']) && $cursusExistant == $_POST['cursusExistant'])
                                                    echo "<option value='".$cursusExistant."' selected>".$cursusExistant."</option>";
                                                else
                                                    echo "<option value='".$cursusExistant."'>".$cursusExistant."</option>";
                                        ?>
                                    </select>
                                </div>
                                <div class="col ps-1">
                                    <input name="cursus" type="text" class="form-control <?= $_POST['validationCursus'] ?>" placeholder="Donnez l'intitulé principal du cursus..." value="<?= $_POST['cursus'] ?>">
                                </div>
                                <small class="form-text text-muted">Ajouter des nouveaux intitulés uniquement si ceux-là n'existent pas dans la liste déroulante !</small>
                            </div>
                        <?php } else { ?>
                            <input name="cursusExistant" type="text" class="form-control <?= $_POST['validationCursusExistant'] ?>" placeholder="Donnez l'intitulé principal du cursus..." value="<?= $_POST['cursusExistant'] ?>" readonly>
                        <?php } ?>
                    </div>
                    <div class="form-group mb-2">
                        <label>Option</label>
                        <input name="intitule" type="text" class="form-control <?= $_POST['validationIntitule'] ?>" placeholder="Donnez le nom de l'option..." value="<?= $_POST['intitule'] ?>" <?php if ($_SESSION['codeOperation'] == 3) echo "readonly"; ?>>
                        <small class="form-text text-muted">Pour chaque option il va falloir créer en quelque sorte un nouveau cursus !</small>
                    </div>
                    <?php if ($_SESSION['codeOperation'] != 3) { ?>
                        <div class="form-group mb-2">
                            <label>Étudiants inscrits</label>
                            <select id="selectPicker" class="selectpicker form-control <?= $_POST['validationListeEtudiants'] ?>" multiple data-live-search="true">
                                <?php
                                    foreach ($_SESSION['etudiants'] as $etudiant) {
                                        if (in_array($etudiant->id, json_decode(base64_decode($_POST['listeEtudiantsDeBase']), true)))
                                            echo "<option value=".$etudiant->id." disabled>".$etudiant->user->name." ".$etudiant->user->surname."</option>";
                                        else
                                            echo "<option value=".$etudiant->id.">".$etudiant->user->name." ".$etudiant->user->surname."</option>";
                                    }
                                ?>
                            </select>
                            <input id="selectPickerHelper" type="hidden" name="listeEtudiants" value="<?= $_POST['listeEtudiants'] ?>">
                            <input id="selectPickerHelperDeBase" type="hidden" name="listeEtudiantsDeBase" value="<?= $_POST['listeEtudiantsDeBase'] ?>">
                            <small class="form-text text-muted">Pour dissocier les étudiants vous devez le faire dans le panneau de gestion d'étudiants !</small>
                        </div>
                        <div class="form-group mb-3">
                            <label>Professeurs responsables</label>
                            <select id="extraSelectPicker" class="selectpicker form-control <?= $_POST['validationListeProfesseurs'] ?>" multiple data-live-search="true">
                                <?php
                                    foreach ($_SESSION['professeurs'] as $professeur) {
                                        if ($professeur == $_SESSION["user"]->professeur)
                                            echo "<option value=".$professeur->id." disabled selected>".$professeur->user->name." ".$professeur->user->surname."</option>";
                                        else
                                            echo "<option value=".$professeur->id.">".$professeur->user->name." ".$professeur->user->surname."</option>";
                                    }
                                ?>
                            </select>
                            <input id="extraSelectPickerHelper" type="hidden" name="listeProfesseurs" value="<?= $_POST['listeProfesseurs'] ?>">
                            <small class="form-text text-muted">Plusieurs professeurs peuvent être responsables du même cursus !</small>
                        </div>
                        <button name="titreBouton" value="<?= $_POST['titreBouton'] ?>" type="submit" class="btn <?= explode("/", $_POST['titreBouton'])[1] ?>"><?= explode("/", $_POST['titreBouton'])[0] ?></button>
                    <?php } else { ?>
                        <label>Étudiants inscrits :</label>
                        <ul class="mb-2">
                            <?php
                                $idsEtudiants = json_decode(base64_decode($_POST['listeEtudiants']), true);
                                if (count($idsEtudiants) > 0)
                                    foreach ($_SESSION['etudiants'] as $etudiant) {
                                        if (in_array($etudiant->id, $idsEtudiants))
                                            echo "<li>".$etudiant->user->name." ".$etudiant->user->surname."</li>";
                                } else
                                    echo "<li>Aucun !</li>";
                            ?>
                        </ul>
                        <label>Professeurs responsables :</label>
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
                            if ($('#selectPickerHelper').val() != "") {
                                let elementsaselectionner = JSON.parse(atob($('#selectPickerHelper').val()));
                                if ($('#selectPickerHelperDeBase').val() != "")
                                    JSON.parse(atob($('#selectPickerHelperDeBase').val())).forEach((element) => {
                                        if (!elementsaselectionner.includes(element))
                                            elementsaselectionner.push(element);
                                    });
                                $('#selectPicker').selectpicker('val', elementsaselectionner);
                            }
                            if ($('#extraSelectPickerHelper').val() != "")
                                $('#extraSelectPicker').selectpicker('val', JSON.parse(atob($('#extraSelectPickerHelper').val())));
                            // Callback à exécuter quand on soumet le formulaire
                            $(document).on('submit', 'form', function() {
                                $('#selectPickerHelper').val(btoa(JSON.stringify($('#selectPicker').val())));
                            });
                            $(document).on('submit', 'form', function() {
                                $('#extraSelectPickerHelper').val(btoa(JSON.stringify($('#extraSelectPicker').val())));
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