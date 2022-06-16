<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON . DS . 'header.php' ?>

<body>
    <?php require_once COMMON . DS . 'navbar.php' ?>
    <div class="container">
        <div class="content">
            <span class="d-flex justify-content-between">
                <span style="width: 8%"></span>
                <h1>Gestion des vos matieres</h1>
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
                        <th scope="col">Nom de la matière</th>
                        <th scope="col">Nombre d'étudiants</th>
                        <th scope="col">Nombre d'examens</th>
                        <th scope="col">Professeurs enseignants</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($_SESSION['matieresExistantes'] as $matiereExistante) { ?>
                        <tr class="align-middle">
                            <td><?= $matiereExistante->name_matiere ?></td>
                            <td><?= $matiereExistante->nbreetudiants ?></td>
                            <td><?= $matiereExistante->nbreexamens ?></td>
                            <td><?= $matiereExistante->professeursenseignants ?></td>
                            <td class="d-flex justify-content-end">
                                <form method="GET" action="editmatiere/<?= $matiereExistante->id ?>/3/">
                                    <button class="btn btn-success m-1"><i class="icon-eye-open" style="color:black"></i></button>
                                </form>
                                <form method="GET" action="editmatiere/<?= $matiereExistante->id ?>/1/">
                                    <button class="btn btn-warning m-1"><i class="icon-pencil" style="color:black"></i></button>
                                </form>
                                <form method="GET" action="editmatiere/<?= $matiereExistante->id ?>/4/">
                                    <button class="btn btn-info m-1"><i class="icon-copy" style="color:black"></i></button>
                                </form>
                                <form method="GET" action="editmatiere/<?= $matiereExistante->id ?>/2/">
                                    <button class="btn btn-danger m-1"><i class="icon-trash" style="color:black"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <form method="GET" action="editmatiere/" class="mt-3">
                <button class="btn btn-primary"><i class="text-white icon-plus"></i></button>
            </form>
        </div>
    </div>
    <script>
        $("#choixAnneeScolaireExistante").find('select').on('change', function() {
            $(this).parent().parent().submit();
        });
    </script>
    <?php require_once COMMON . DS . 'footer.php' ?>
</body>

</HTML>