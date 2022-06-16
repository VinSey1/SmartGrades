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
                    <h1><?= $examen->intitule ?></h1>
                    <a href="/professeur/examens" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
                </span>
                <h2>Informations générales</h2>
                <form class="d-flex justify-content-between" action="" method="POST">
                    <div class="input-group p-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Type</span>
                        </div>
                        <select class="form-select" id="type" name="type" <?= $examen->isPublie() ? 'disabled' : '' ?> >
                            <?php $types = array("CCF", "CCI", "TP"); 
                            foreach ($types as $type) { ?>
                                <option <?php if($examen->type == $type) echo "selected" ?> value="<?= $type ?>"><?= $type ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="input-group p-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Date de l'examen</span>
                        </div>
                        <input type="date" name="date" class="form-control" placeholder="Date" value="<?= $examen->date_examen ?>" <?= $examen->isPublie() ? 'disabled' : '' ?>>
                    </div>
                    <?php if(!$examen->isPublie()) { ?> 
                        <button type="submit" name="update" class="btn btn-primary m-2" style="width:30%">Mettre à jour</button>
                    <?php } ?>
                </form>
                <h2>Questions</h2>
                <table data-toggle="table" data-pagination="true" data-locale="fr-FR" data-pagination-parts=['pageList']>
                    <thead>
                        <tr>
                            <th scope="col">Question</th>
                            <th scope="col">Commentaires</th>
                            <th scope="col">Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $questions = $examen->questions;
                        foreach ($questions as $question) { ?>
                            <tr class="align-middle">
                                <td><?= $question->contenu ?></td>
                                <td><?= $question->commentaire ?></td>
                                <td><?= $question->points ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </br>
                <h2>Matières concernées</h2>
                <table data-toggle="table" data-pagination="true" data-locale="fr-FR" data-pagination-parts=['pageList']>
                    <thead>
                        <tr>
                            <th scope="col">Matière</th>
                            <th scope="col">Description</th>
                            <?php if(!$examen->isPublie()) { ?>
                                <th data-halign="right" data-align="right" scope="col">Actions</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $matieres = $examen->matieres;
                        foreach ($matieres as $matiere) { ?>
                            <tr class="align-middle">
                                <td><?= $matiere->name_matiere ?></td>
                                <td><?= $matiere->description_matiere ?></td>
                                <?php if(!$examen->isPublie()) { ?>
                                    <td>
                                        <form action="" method="POST">
                                            <input type='hidden' name='matiere' value='<?= $matiere->id ?>'>
                                            <button type="submit" name="delete_matiere" class="btn btn-danger m-1">
                                                <i class="icon-trash" style="color:black"></i>
                                            </button>
                                        </form>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </br>
                <?php if(!$examen->isPublie()) { ?>
                    <h6>Ajouter une matière :</h6>
                    <form class="d-flex p-1" action="" method="POST">
                        <select class="form-select" id="matiere" name="matiere">
                            <option selected disabled>Choisir une matière à ajouter</option>
                            <?php $matieres_ajoutables = $_SESSION['matieres_ajoutables']; 
                            foreach ($matieres_ajoutables as $matiere) { ?>
                                <option value="<?= $matiere->id ?>"><?= $matiere->name_matiere ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" name="add_matiere" class="btn btn-primary m-1" id="add-matiere" disabled>Ajouter</button>
                    </form>
                <?php } ?>
                </br>
                <h2>Étudiants</h2>
                <table data-toggle="table" data-pagination="true" data-locale="fr-FR" data-pagination-parts=['pageList']>
                    <thead>
                        <tr>
                            <th scope="col">Promotion</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Email</th>
                            <th scope="col">Note</th>
                            <?php if(!$examen->isPublie()) { ?>
                                <th data-halign="right" data-align="right" scope="col">Actions</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $etudiants = $examen->etudiants;
                        foreach ($etudiants as $etudiant) { ?>
                            <tr class="align-middle">
                                <td><?=$etudiant->classe->promotion ?></td>
                                <td><?= $etudiant->user->name ?></td>
                                <td><?= $etudiant->user->surname ?></td>
                                <td><?= $etudiant->user->email ?></td>
                                <td><?= $etudiant->note($examen) ?></td>
                                <?php if(!$examen->isPublie()) { ?>
                                    <td>
                                        <a href="/professeur/noter/<?= $examen->id ?>/<?= $etudiant->id ?>" class="btn btn-primary m-1"><i class="icon-legal" style="color:black"></i></a>
                                        <a href="/etudiant/<?= $etudiant->id ?>" class="btn btn-success m-1"><i class="icon-eye-open" style="color:black"></i></a>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </br>
                <h5>
                    <div>Moyenne de l'examen : <?= $examen->moyenne ?>/20</div>
                </h5>
                <?php if(!$examen->isPublie()) { ?>
                    <span class="d-flex p-1 justify-content-center">
                        <form action="" method="POST" class="m-1">
                            <button type="submit" name="supprimer" class="btn btn-danger">Supprimer</button>
                        </form>
                        <form action="" method="POST" class="m-1">
                            <button type="submit" name="publier" class="btn btn-success">Publier</button>
                        </form>
                    </span>
                <?php } else { ?>
                    </br>
                <?php } ?>
            </div>
        </div>
        <script type="text/javascript">
            $('#matiere').one('change', function() {
                $('#add-matiere').prop('disabled', false);
            });
        </script>
        <?php require COMMON.DS.'footer.php' ?>
    </body>
</HTML>