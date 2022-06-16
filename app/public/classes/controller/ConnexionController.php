<?php
    require_once CLASSES.DS.'Controller.php';
    class ConnexionController extends Controller {
        function showContent($infos) {
            if (empty($_SESSION)) session_start();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Je vide la variable à chaque soumission du formulaire
                $_SESSION['erreur'] = '';
                require_once C_CLASSES.DS.'Authentifieur.php';
                $resultatAuthentification = Authentifieur::authentifier($_POST['username'], $_POST['password']);
                if ($resultatAuthentification) {
                    $_SESSION['user'] = User::first(["email", "=", $_POST['username']], []);
                    header('Location: accueil');
                } else {
                    session_destroy();
                    $_SESSION['erreur'] = "L'authentification n'a pas pu aboutir !";
                }
            }
            require_once VIEWS.DS.'connexion.php';
            ob_flush();
        }
    }
?>
