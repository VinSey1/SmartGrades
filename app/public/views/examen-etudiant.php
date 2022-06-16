<!DOCTYPE html>
<HTML lang="fr">
<?php require COMMON.DS.'header.php' ?>
    <body>
        <?php require COMMON.DS.'navbar.php' ?>
        <div class="container">
            <div class="content">
                <?php $examen = $_SESSION['examen']; ?>
                <span class="d-flex justify-content-between">
                    <span style="width: 8%"></span>
                    <h1>Details de <?= $examen->intitule ?></h1>
                    <a href="/etudiant/notes" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
                </span>
                <h2>Questions</h2>
                <table data-toggle="table" data-pagination="true" data-locale="fr-FR" data-pagination-parts=['pageList']>
                    <thead>
                        <tr>
                            <th scope="col">Question</th>
                            <th scope="col">Commentaires</th>
                            <th scope="col" data-width="100" data-align="right">Barème</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $questions = $examen->questions;
                        foreach ($questions as $question) { 
                            $note_max += $question->points; ?>
                            <tr class="align-middle">
                                <td><?= $question->contenu ?></td>
                                <td><?= $question->commentaire ?></td>
                                <td><?= $question->points ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <h5 class="mt-1">
                    <div>Note : <?= $_SESSION['user']->etudiant->note($examen) ?> / 20</div>
                    <div>Moyenne de l'examen : <?= $examen->moyenne ?> / 20</div>
                </h5>
            </div>
        </div>
        <?php require COMMON.DS.'footer.php' ?>
    </body>
</HTML>