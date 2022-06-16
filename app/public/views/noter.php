<!DOCTYPE html>
<HTML lang="fr">
<?php require COMMON.DS.'header.php' ?>
    <body>
        <?php require COMMON.DS.'navbar.php' ?>
        <div class="container">
            <div class="content">
                <?php $examen = $_SESSION['examen'];
                $etudiant = $_SESSION['etudiant']; ?>
                <span class="d-flex justify-content-between">
                    <span style="width: 8%"></span>
                    <h1>Notation <?= $examen->intitule ?></h1>
                    <a href="/examen/<?= $examen->id ?>" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
                </span>
                <h2>Informations sur l'étudiant</h2>
                <h5>
                    <div><b>Nom :</b> <?=$etudiant->user->surname ?></div>
                    <div><b>Prénom :</b> <?=$etudiant->user->name ?></div>
                    <div><b>Classe :</b> <?=$etudiant->classe->promotion ?></div>
                    <?php if($etudiant->tier_temps)  { ?>
                        <div class="mt-1"><span class="badge" style="background-color: green">Bénéficie du tier temps</span></div>
                    <?php } ?>
                </h5>
                <h2>Questions</h2>
                <table data-toggle="table" data-pagination="true" data-locale="fr-FR" data-pagination-parts=['pageList']>
                    <thead>
                        <tr>
                            <th scope="col">Question</th>
                            <th scope="col">Commentaires</th>
                            <th scope="col" data-width="70">Notation</th>
                            <th scope="col" data-width="50">Note</th>
                            <th scope="col" data-width="50">Max</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $questions = $examen->questions;
                        foreach ($questions as $question) { 
                            $note_max += $question->points; ?>
                            <tr class="align-middle">
                                <td><?= $question->contenu ?></td>
                                <td><?= $question->commentaire ?></td>
                                <td>
                                    <input class="slider" type="range" min="0" max="<?= $question->points?>" value="0" step="0.25" oninput="document.getElementById('output-<?= $question->id ?>').value = this.value; calculNote()">
                                </td>
                                <td>
                                    <output class="points" id="output-<?= $question->id ?>" style="ml-5" onchange="calculNote">0.00</output>
                                </td>
                                <td>
                                / <?= $question->points ?>    
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <h5 class="mt-1">
                    <div>Note : <span id="note">0</span> / 20</div>
                    <div>Moyenne de l'examen : <?= $examen->moyenne ?> / 20</div>
                </h5>
                <span class="d-flex p-1 justify-content-center">
                    <form action="" method="POST" class="m-1">
                        <button type="submit" name="absent" class="btn btn-warning">Déclarer absent</button>
                    </form>
                    <form action="" method="POST" class="m-1">
                        <input type="hidden" name="note" id="form-note">
                        <button type="submit" name="noter" class="btn btn-success">Noter</button>
                    </form>
                </span>
            </div>
        </div>
        <script type="text/javascript">
            function calculNote() {
                let pointsHTML = document.getElementsByClassName('points');
                let points = 0;
                for(const point of pointsHTML) {
                    points += parseFloat(point.innerHTML);
                }
                points = (points / <?= $note_max ?> * 20).toPrecision(3);
                document.getElementById('note').innerHTML = points;
                document.getElementById('form-note').value = points;
            }
        </script>
        <?php require COMMON.DS.'footer.php' ?>
    </body>
</HTML>