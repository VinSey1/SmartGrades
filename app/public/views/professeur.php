<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON . DS . 'header.php' ?>

<body>
    <?php require_once COMMON . DS . 'navbar.php' ?>
    <div class="container">
        <div class="content">
            <span class="d-flex justify-content-between">
                <span style="width: 8%"></span>
                <h1>Affichage d'un professeur</h1>
                <a href="/administrateur/professeurs" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
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
                        <b>Numéro professeur:</b> <?= $professeur->numero_professeur ?>
                    </p>
                </div>
                <div class="d-flex flex-column">
                    <p>
                        <b>Email:</b> <?= $user->email ?>
                    </p>
                    <p>
                        <b>Date de naissance:</b> <?= date("d/m/Y", strtotime($user->date_naissance)) ?>
                    </p>
                    <p>
                        <b>Identifiant GitLab:</b> <?= $professeur->id_gitlab ?>
                    </p>
                </div>
            </div>
            <hr />
            <div class="d-flex flex-column">
                <p><b>Ses Classes: </b>
                    <?php if (count($sesClasses) > 0) { ?> </br>
                        <table data-toggle="table" data-pagination="false" data-locale="fr-FR">
                            <thead>
                                <tr>
                                    <th scope="col">Promotion</th>
                                    <th scope="col">Intitulé</th>
                                    <th scope="col">Année scolaire</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sesClasses as $c) { ?>
                                    <tr class="align-middle">
                                        <td><?= $c->promotion ?></td>
                                        <td><?= $c->intitule ?></td>
                                        <td><?= $c->anneeScolaire->intitule ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        aucune classe
                    <?php }  ?>
                </p>
                <p><b>Ses Matieres: </b>
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
            </div>
        </div>
    </div>
    <?php require_once COMMON . DS . 'footer.php' ?>
</body>

</HTML>