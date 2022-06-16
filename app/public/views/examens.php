<!DOCTYPE html>
<HTML lang="fr">
<?php require COMMON.DS.'header.php' ?>
    <body>
        <?php require COMMON.DS.'navbar.php' ?>
        <div class="container">
            <div class="content">
                <span class="d-flex justify-content-between">
                    <span style="width: 8%"></span>
                    <h1>Liste de vos examens</h1>
                    <a href="/" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
                </span>
                <h2>Examens non publiés</h2>
                <table data-toggle="table" data-pagination="true" data-locale="fr-FR" data-pagination-parts=['pageList']>
                    <thead>
                        <tr>
                            <th scope="col">Intitulé</th>
                            <th scope="col">Type</th>
                            <th scope="col">Date</th>
                            <th scope="col">Moyenne temporaire</th>
                            <th data-halign="right" data-align="right" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $examens = $_SESSION['examens_non_publies'];
                        foreach ($examens as $examen) { ?>
                            <tr class="align-middle">
                                <td><?= $examen->intitule ?></td>
                                <td><?= $examen->type ?></td>
                                <td><?= $examen->date_examen ?></td>
                                <td><?= $examen->moyenne ?></td>
                                <td>
                                    <form action="/professeur/examen/<?= $examen->id ?>" method="POST">
                                        <a href="/professeur/examen/<?= $examen->id ?>" class="btn btn-success m-1"><i class="icon-pencil" style="color:black"></i></a>
                                        <button type="submit" name="publier" class="btn btn-primary m-1">
                                            <i class="icon-book" style="color:black"></i>
                                        </button>
                                        <button type="submit" name="supprimer" class="btn btn-danger m-1">
                                            <i class="icon-trash" style="color:black"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <span class="d-flex justify-content-end">
                    <a href="/professeur/creation-examen" class="btn btn-primary mt-2">Créer un nouvel examen</a>
                </span>
                <h2>Examens publiés</h2>
                <table data-toggle="table" data-pagination="true" data-locale="fr-FR" data-pagination-parts=['pageList']>
                    <thead>
                        <tr>
                            <th scope="col">Intitulé</th>
                            <th scope="col">Type</th>
                            <th scope="col">Date</th>
                            <th scope="col">Moyenne</th>
                            <th data-halign="right" data-align="right" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $examens = $_SESSION['examens_publies'];
                        foreach ($examens as $examen) { ?>
                            <tr class="align-middle">
                                <td><?= $examen->intitule ?></td>
                                <td><?= $examen->type ?></td>
                                <td><?= $examen->date_examen ?></td>
                                <td><?= $examen->moyenne ?></td>
                                <td>
                                    <a href="/professeur/examen/<?= $examen->id ?>" class="btn btn-success m-1"><i class="icon-eye-open" style="color:black"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php require COMMON.DS.'footer.php' ?>
    </body>
</HTML>