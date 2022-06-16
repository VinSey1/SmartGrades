<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON.DS.'header.php' ?>

<body>
    <?php require_once COMMON.DS.'navbar.php' ?>
    <div class="container">
        <div class="content">
            <span class="d-flex justify-content-between">
                <span style="width: 8%"></span>
                <h1>Vos notes</h1>
                <a href="/" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
            </span>
            <table data-toggle="table" data-pagination="true" data-locale="fr-FR">
                <thead>
                    <tr>
                        <th scope="col">Nom de l'examen</th>
                        <th scope="col">Date</th>
                        <th scope="col">Type</th>
                        <th scope="col">Note</th>
                        <th scope="col">Moyenne</th>
                        <th data-halign="right" data-align="right" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $examens = $_SESSION['examens'];
                    foreach ($examens as $examen) { 
                        $note = $_SESSION['user']->etudiant->note($examen);
                        if(is_float($note)) $note = $note . '/20';
                        if($examen->isPublie()) {
                    ?>
                        <tr class="align-middle">
                            <td><?= $examen->intitule ?></td>
                            <td><?= $examen->date_examen ?></td>
                            <td><?= $examen->type ?></td>
                            <td><span class="note"><?= $note ?></span></td>
                            <td><span class="moyenne"><?= $examen->moyenne() ?></span> / 20</td>
                            <td class="d-flex justify-content-end">
                                <a href="/etudiant/examen/<?= $examen->id ?>" class="btn btn-success m-1"><i class="icon-eye-open" style="color:black"></i></a>
                            </td>
                        </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
            <h5 id="affichage-moyenne" class="mt-1">
                <div>Moyenne : <span id="moyenne">0</span> / 20</div>
            </h5>
            <h5 id="affichage-moyenne-etudiants" class="mt-1">
                <div>Moyenne de la promotion : <span id="moyenne-etudiants">0</span> / 20</div>
            </h5>
        </div>
    </div>
    <script type="text/javascript">
        calculMoyenne();
        calculMoyenneEtudiants();

        function calculMoyenne() {
            let nbNotes = 0;
            if(document.getElementsByClassName('note').length > 0) {
                let notesHTML = document.getElementsByClassName('note');
                let moyenne = 0;
                for(const note of notesHTML) {
                    if(parseFloat(note.innerHTML)) {
                        moyenne += parseFloat(note.innerHTML);
                        nbNotes++;
                    }
                }
                moyenne = moyenne / nbNotes;
                if(nbNotes == 0) moyenne = "?";
                document.getElementById('moyenne').innerHTML = moyenne;
            }
            if(nbNotes == 0) document.getElementById('affichage-moyenne').innerHTML = "";
        }

        function calculMoyenneEtudiants() {
            let nbNotes = 0;
            if(document.getElementsByClassName('moyenne').length > 0) {
                let notesHTML = document.getElementsByClassName('moyenne');
                let moyenne = 0;
                for(const note of notesHTML) {
                    if(parseFloat(note.innerHTML)) {
                        moyenne += parseFloat(note.innerHTML);
                        nbNotes++;
                    }
                }
                moyenne = moyenne / nbNotes;
                if(nbNotes == 0) moyenne = "?";
                document.getElementById('moyenne-etudiants').innerHTML = moyenne;
            }
            if(nbNotes == 0) document.getElementById('affichage-moyenne-etudiants').innerHTML = "";
        }
    </script>
    <?php require_once COMMON . DS . 'footer.php' ?>
</body>

</HTML>