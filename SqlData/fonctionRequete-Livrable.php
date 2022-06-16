<?php
function connection()
{
    try {
        // On se connecte à MySQL
        $mysqlClient = new PDO('mysql:host=mysql;dbname=smartgrades;charset=utf8mb4', 'smartgrades', 'smartgrades');
    } catch (Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : ' . $e->getMessage());
    }
    // Si tout va bien, on peut continuer
    return $mysqlClient;
}

function getAuthentification_mailPwd_query($mail, $hashedPassword)
{
    $mysqlClient = connection();
    $sqlQuery =
        'SELECT COUNT(1)
        FROM User
        WHERE email = :email AND password = :hpw';

    $authStatement = $mysqlClient->prepare($sqlQuery);
    $authStatement->execute([
        'email' => $mail,
        'hpw' => $hashedPassword
    ]);
    $auth = $authStatement->fetch();
    return $auth;
}

function getListMatieres_idProf_query($idProf)
{
    $mysqlClient = connection();
    $sqlQuery =
        'SELECT M.idMatiere, M.nameMatiere
        FROM Matiere AS M
        INNER JOIN Matiere_has_Professeur AS MhP ON M.idMatiere = MhP.Matiere_idMatiere
        WHERE MhP.Professeur_idProfesseur = :idProf';

    $matieresStatement = $mysqlClient->prepare($sqlQuery);
    $matieresStatement->execute([
        'idProf' => $idProf
    ]);
    $matieres = $matieresStatement->fetchAll();
    return $matieres;
}

function getListEtudiants_idProfIdMatiere_query($idProf, $idMatiere)
{
    $mysqlClient = connection();
    $sqlQuery =
        'SELECT E.User_email, M.idMatiere, U.name, U.surname, E.Classe_idClasse
        FROM Etudiant as E
        INNER JOIN USER as U ON E.User_email = U.email
        INNER JOIN Matiere_has_Etudiant as MhE ON E.idEtudiant= MhE.Etudiant_idEtudiant
        INNER JOIN Matiere as M ON MhE.Matiere_idMatiere = M.idMatiere
        INNER JOIN Matiere_has_Professeur as MhP ON M.idMatiere = MhP.Matiere_idMatiere
        WHERE M.idMatiere = :idMatiere AND MhP.Professeur_idProfesseur = :idProf';

    $etudiantsStatement = $mysqlClient->prepare($sqlQuery);
    $etudiantsStatement->execute([
        'idMatiere' => $idMatiere,
        'idProf' => $idProf
    ]);
    $etudiants = $etudiantsStatement->fetchAll();
    return $etudiants;
}
?>




<?php
$matieres = getListMatieres_idProf_query('3021001');
foreach ($matieres as $matiere) {
?>
    <p>-<?= $matiere['idMatiere']; ?> --
        <?= $matiere['nameMatiere']; ?> </p>
<?php
}
?>

<?php
$isAuth = getAuthentification_mailPwd_query('toto@gmail.com', '$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C');
?>
<p>=><?= $isAuth['COUNT(1)']; ?></p>

<?php
$etudiants = getListEtudiants_idProfIdMatiere_query('3021001', 'JAVA');
foreach ($etudiants as $etudiant) {
?>
    <p>-<?= $etudiant['User_email']; ?> --
        <?= $etudiant['idMatiere']; ?> --
        <?= $etudiant['name']; ?> --
        <?= $etudiant['surname']; ?> --
        <?= $etudiant['Classe_idClasse']; ?>
    </p>
<?php
}
?>