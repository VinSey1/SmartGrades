<!DOCTYPE html>
<HTML lang="fr">
<?php require_once COMMON . DS . 'header.php' ?>

<body>
    <?php require_once COMMON . DS . 'navbar.php' ?>
    <div class="container">
        <div class="content">
            <span class="d-flex justify-content-between">
                <span style="width: 8%"></span>
                <h1>Gestion de vos professeurs</h1>
                <a href="/" style="height: 80%; width: 8%" class="btn btn-danger align-self-center">Retour</a>
            </span>
            <?php
            if(isset($_SESSION["error"]) && $_SESSION["error"] !== ""){
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>".
                        $_SESSION['error'].
                     "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                      </div>"; 
                    unset($_SESSION["error"]);
                    
            }
            else if (isset($_SESSION["success"]) && $_SESSION["success"] !== "") {
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>" .
                    $_SESSION['success'] . "
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
                unset($_SESSION["success"]);
            }
            ?>
            <div class="d-flex justify-content-around">
                <a class="btn btn-primary" href="./inscriptionProfesseur" role="button"> Ajouter un professeur</a>

                <form method="POST" action="" name="loadFileForm" enctype="multipart/form-data" class="d-flex">
                    <input class="form-control" type="file" id="file-upload" name="uploadedFile" accept=".csv"/>
                    &nbsp;&nbsp;
                    <input class="btn btn-primary" type="submit" name="Load" value="Load"/>
                </form>
            </div>
            </br>
            <table data-toggle="table" data-pagination="true" data-locale="fr-FR">
                <thead>
                    <tr>
                        <th scope="col">Pr??nom</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Email</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professeurs as $professeur) { ?>
                        <tr class="align-middle">
                            <td><?= $professeur->user->name ?></td>
                            <td><?= $professeur->user->surname ?></td>
                            <td><?= $professeur->user->email ?></td>
                            <td class="d-flex justify-content-end">
                                <form method="POST" action="/professeur/<?= $professeur->id ?>">
                                    <button name="details" class="btn btn-success m-1"><i class="icon-eye-open" style="color:black"></i></button>
                                    <button name="modif" class="btn btn-primary m-1"><i class="icon-pencil" style="color:black"></i></button>
                                    <button name="suppr" class="btn btn-danger m-1"><i class="icon-trash" style="color:black"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php require_once COMMON . DS . 'footer.php' ?>
</body>

</HTML>