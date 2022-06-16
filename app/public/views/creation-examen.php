<!DOCTYPE html>
<HTML lang="fr">
<?php require COMMON.DS.'header.php' ?>
    <body>
        <?php require COMMON.DS.'navbar.php' ?>
        <div class="container">
            <div class="content">
            <span class="d-flex justify-content-between">
                    <span style="width: 8%"></span>
                    <h1>Creation d'un examen</h1>
                    <a href="/professeur/examens" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
                </span>
                <form method="POST" action="">
                    <?php $examen = $_SESSION['examen'] ?>
                    <h2>Informations générales</h2>
                    <div class="input-group p-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Intitulé</span>
                        </div>
                        <input type="text" name="intitule" class="form-control" placeholder="Intitulé de l'examen" value="<?= $examen->intitule ?>" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="input-group p-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Type</span>
                            </div>
                            <select class="form-select" id="type" name="type" required>
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
                            <input type="date" name="date" class="form-control" placeholder="Date" value="<?= $examen->date_examen ?>" required>
                        </div>
                    </div>
                    <h2>Matières concernées</h2>
                    <table data-toggle="table" data-pagination="true" data-locale="fr-FR" data-pagination-parts=['pageList']>
                        <thead>
                            <tr>
                                <th scope="col">Matière</th>
                                <th scope="col">Description</th>
                                <th data-halign="right" data-align="right" scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $matieres = $_SESSION["matieres"];
                            foreach ($matieres as $matiere) { ?>
                                <tr class="align-middle">
                                    <td><?= $matiere->name_matiere ?></td>
                                    <td><?= $matiere->description_matiere ?></td>
                                    <td>
                                        <input type='hidden' name='matiere' value='<?= $matiere->id ?>'>
                                        <button type="submit" name="delete_matiere" class="btn btn-danger m-1">
                                            <i class="icon-trash" style="color:black"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    </br>
                    <h6>Ajouter une matière :</h6>
                    <span class="d-flex p-1">
                        <select class="form-select" id="matiere" name="matiere">
                            <option selected disabled>Choisir une matière à ajouter</option>
                            <?php $matieres_ajoutables = $_SESSION['matieres_ajoutables']; 
                            foreach ($matieres_ajoutables as $matiere) { ?>
                                <option value="<?= $matiere->id ?>"><?= $matiere->name_matiere ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" name="add_matiere" class="btn btn-primary m-1" id="add-matiere" disabled>Ajouter</button>
                    </span>
                    </br>
                    <h2>Questions</h2>
                    <table data-toggle="table" data-pagination="true" data-locale="fr-FR" data-pagination-parts=['pageList']>
                        <thead>
                            <tr>
                                <th scope="col">Question</th>
                                <th scope="col">Commentaires</th>
                                <th scope="col">Points</th>
                                <th data-halign="right" data-align="right" scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $questions = $_SESSION["questions"];
                            foreach ($questions as $question) { ?>
                                <tr class="align-middle">
                                    <td><?= $question->contenu ?></td>
                                    <td><?= $question->commentaire ?></td>
                                    <td><?= $question->points ?></td>
                                    <td>
                                        <input type='hidden' name='index_question' value='<?= array_search($question, $questions); ?>'>
                                        <button type="submit" name="delete_question" class="btn btn-danger m-1">
                                            <i class="icon-trash" style="color:black"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    </br>
                    <h6>Ajouter une question :</h6>
                    <div class="d-flex">
                        <div class="input-group p-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Question</span>
                            </div>
                            <input type="text" name="question" class="form-control" placeholder="Intitulé de la question">
                        </div>
                        <div class="input-group p-2" style="width: 15%">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Note</span>
                            </div>
                            <input type="number" name="note" min=0 max=50 step=0.25 value=0 class="form-control">
                        </div>
                    </div>
                    <div class="px-2">
                        Commentaire :
                        <textarea class="form-control pb-1" aria-label="Commentaire sur la question" name="commentaire"></textarea>
                        <span class="d-flex justify-content-end">
                            <button type="submit" name="add_question" class="btn btn-primary mt-2">Ajouter la question</button>
                        </span>
                    </div>
                    </br>
                    <span class="d-flex p-1 justify-content-center">
                        <span class="m-1">
                            <button type="submit" name="add_examen" class="btn btn-success">Créer l'examen</button>
                        </span>
                    </span>
                </form>
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