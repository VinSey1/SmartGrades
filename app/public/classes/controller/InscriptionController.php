<?php
    require_once CLASSES.DS.'Controller.php';
    class InscriptionController extends Controller {
        function showContent($infos) {
            if (empty($_SESSION)) session_start();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Je vide la variable à chaque soumission du formulaire
                $_SESSION['erreur'] = '';
                if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['repassword']) || empty($_POST['type']) || empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['date']))
                    $_SESSION['erreur'] = "Bien renseigner tous les champs du formulaire !";
                else if ($_POST['password'] !== $_POST['repassword'])
                    $_SESSION['erreur'] = "Le mot de passe et sa confirmation sont différents ! Faites gaffe quand vous tapez !";
                else {
                    require_once C_CLASSES.DS.'Authentifieur.php';
                    $resultatInsertion = Authentifieur::insertNew($_POST);
                    if ($resultatInsertion) {
                        $_SESSION['username'] = $_POST['username'];
                        header('Location: accueil');
                    } else {
                        $_SESSION['erreur'] = "Il n'a pas été possible de vous ajouter en tant que nouvel utilisateur !";
                    }
                }
            }
            require_once VIEWS.DS.'inscription.php';
            ob_flush();
        }
    }
?>
