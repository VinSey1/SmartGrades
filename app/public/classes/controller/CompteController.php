<?php
    require_once CLASSES.DS.'Controller.php';
    class CompteController extends Controller {
        function showContent($infos) {
            if (empty($_SESSION)) session_start();
            // Redirection sur la page de connexion si l'utilisateur n'est pas connecté (faudrait mettre sous forme d'un middleware aussi pour les autres pages)
            if (empty($_SESSION['user']))
                header('Location: connexion');
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Je vide la variable à chaque soumission du formulaire
                $_SESSION['erreur'] = '';
                if ($_POST['requete'] == 'modification') {
                    if (empty($_POST['password']) || empty($_POST['repassword']))
                        $_SESSION['erreur'] = "Bien renseigner tous les champs du formulaire !";
                    else if ($_POST['password'] !== $_POST['repassword'])
                        $_SESSION['erreur'] = "Le mot de passe et sa confirmation sont différents ! Faites gaffe quand vous tapez !";
                    else {
                        require_once('Authentifieur.php');
                        $resultatMiseAJour = Authentifieur::updatePassword($_SESSION['username'], $_POST['password']);
                        if ($resultatMiseAJour)
                            header('Location: accueil');
                        else
                            $_SESSION['erreur'] = "Il n'a pas été possible de mettre à jour votre mot de passe !";
                    }
                } else if ($_POST['requete'] == 'suppression') {
                    // Je vide la variable à chaque soumission du formulaire
                    $_SESSION['erreur'] = '';
                    require_once C_CLASSES.DS.'Authentifieur.php';
                    $resultatSuppression = Authentifieur::delete($_SESSION['username']);
                    if ($resultatSuppression) {
                        session_destroy();
                        header('Location: accueil');
                    } else
                        $_SESSION['erreur'] = 'Impossible de supprimer votre compte !';
                }
            }
            require_once VIEWS.DS.'compte.php';
            ob_flush();
        }
    }
?>
