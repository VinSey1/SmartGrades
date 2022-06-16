<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON . DS . 'header.php' ?>

<body>
    <?php require_once COMMON . DS . 'navbar.php' ?>
    <div class="container">
        <div class="content">
            <span class="d-flex justify-content-between">
                <span style="width: 8%"></span>
                <h1>Affichage d'un etudiant</h1>
                <a href="/administrateur/etudiants" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
            </span>
            <h3>Profil de <?= ucfirst($user->name) ?> <?= strtoupper($user->surname) ?> </h3>
            <hr />
            <div class="d-flex flex-column flex-md-row justify-content-around">
                <div class="d-flex flex-column">
                    <p>
                        <b>Nom de famille:</b> <?= $user->surname ?>
                    </p>
                    <p>
                        <b>Prénom:</b> <?= $user->name ?>
                    </p>
                    <p>
                        <b>Numéro étudiant:</b> <?= $etudiant->numero_etudiant ?>
                    </p>
                    <p>
                        <b>Identifiant GitLab:</b> <?= $etudiant->id_gitlab ?>
                    </p>
                    <?php if($etudiant->tier_temps)  { ?>
                        <div><span class="badge" style="background-color: green">Bénéficie du tier temps</span></div>
                    <?php } ?>
                </div>
                <div class="d-flex flex-column">
                    <p>
                        <b>Email:</b> <?= $user->email ?>
                    </p>
                    <p>
                        <b>Date de naissance:</b> <?= date("d/m/Y", strtotime($user->date_naissance)) ?>
                    </p>
                    <p>
                        <b>Statut:</b> <?= $etudiant->statut ?>
                    </p>
                </div>
            </div>
            <hr />
            <div class="d-flex flex-column">
                <p>
                    <b>Classe: </b>
                    <?php if ($saClasse) { ?>
                        <?= $saClasse->promotion ?> (<?= $saClasse->intitule ?>) <?= $saClasse->anneeScolaire->intitule ?>
                    <?php } else {
                        echo "aucune classe";
                    }  ?>
                </p>
                <p><b>Matieres: </b>
                    <?php if (count($sesMatieres) > 0) { ?> </br>
                        <table data-toggle="table" data-pagination="false" data-locale="fr-FR">
                            <thead>
                                <tr>
                                    <th scope="col">Nom de la matière</th>
                                    <th scope="col">Description de la matière</th>
                                    <th scope="col">Année scolaire</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sesMatieres as $m) { ?>
                                    <tr class="align-middle">
                                        <td><?= $m->name_matiere ?></td>
                                        <td><?= $m->description_matiere ?></td>
                                        <td><?= $m->anneeScolaire->intitule ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        aucune matiere
                    <?php }  ?>
                </p>
                <p>
                    <b>Cursus post BAC:</b> <?= $etudiant->cursus_postbac ?>
                </p>
            </div>
        </div>
    </div>
    <?php require_once COMMON . DS . 'footer.php' ?>
</body>

</HTML>