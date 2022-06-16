<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON.DS.'header.php' ?>
    <body>
        <?php require_once COMMON.DS.'navbar.php' ?>
        <div class="container">
            <div class="content">
                <span class="d-flex justify-content-between">
                    <span style="width: 8%"></span>
                    <h1>Les cursus enseignes</h1>
                    <a href="/" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
                </span>
                <form id="choixAnneeScolaireExistante" method="POST" class="mb-3">
                    <div class="form-group">
                        <label>Année scolaire</label>
                        <select name="anneeScolaireExistante" class="form-select <?= $_POST['validationAnneeScolaireExistante'] ?>">
                            <?php
                                if (!empty($_POST['anneeScolaireExistante']))
                                    echo "<option value=''>Choisir une année scolaire...</option>";
                                else
                                    echo "<option value='' selected>Choisir une année scolaire...</option>";
                                foreach ($_SESSION['anneesExistantes'] as $anneeExistante)
                                    if (!empty($_POST['anneeScolaireExistante']) && $anneeExistante == $_POST['anneeScolaireExistante'])
                                        echo "<option value='".$anneeExistante."' selected>".$anneeExistante."</option>";
                                    else
                                        echo "<option value='".$anneeExistante."'>".$anneeExistante."</option>";
                            ?>
                        </select>
                    </div>
                </form>
                <table data-toggle="table" data-pagination="true" data-locale="fr-FR">
                    <thead>
                        <tr>
                            <th scope="col">Intitulé</th>
                            <th scope="col">Option</th>
                            <th scope="col">Nombre d'étudiants</th>
                            <th scope="col">Professeurs responsables</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($_SESSION['cursusExistants']))
                            foreach ($_SESSION['cursusExistants'] as $cursusExistant) { ?>
                                <tr class="align-middle">
                                    <td><?= $cursusExistant->promotion ?></td>
                                    <td><?= $cursusExistant->intitule ?></td>
                                    <td><?= $cursusExistant->nbreetudiants ?></td>
                                    <td><?= $cursusExistant->professeursresp ?></td>
                                    <td class="d-flex justify-content-end">
                                        <?php if ($cursusExistant->professeurresp || $_SESSION["user"]->role == "administrateur") { ?>
                                            <form method="GET" action="editcursus/<?= $cursusExistant->id ?>/3/">
                                                <button class="btn btn-success m-1"><i class="icon-eye-open" style="color:black"></i></button>
                                            </form>
                                            <form method="GET" action="editcursus/<?= $cursusExistant->id ?>/1/">
                                                <button class="btn btn-warning m-1"><i class="icon-pencil" style="color:black"></i></button>
                                            </form>
                                            <form method="GET" action="editcursus/<?= $cursusExistant->id ?>/4/">
                                                <button class="btn btn-info m-1"><i class="icon-copy" style="color:black"></i></button>
                                            </form>
                                            <form method="GET" action="editcursus/<?= $cursusExistant->id ?>/2/">
                                                <button class="btn btn-danger m-1"><i class="icon-trash" style="color:black"></i></button>
                                            </form>
                                        <?php } else { ?>
                                            <p class="text-muted mb-0">droits insuffisants</p>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                    </tbody>
                </table>
                <form method="GET" action="editcursus/" class="mt-3">
                    <button class="btn btn-primary"><i class="text-white icon-plus"></i></button>
                </form>
            </div>
        </div>
        <script>
            $("#choixAnneeScolaireExistante").find('select').on('change', function() {
                $(this).parent().parent().submit();
            });
        </script>
        <?php require_once COMMON.DS.'footer.php' ?>
    </body>
</HTML>