<?php
    require_once CLASSES.DS.'Controller.php';
    require_once M_CLASSES . DS . 'administrateur.php';
    require_once M_CLASSES . DS . 'professeur.php';
    require_once M_CLASSES . DS . 'matiere.php';
    class AccueilController extends Controller {
        function showContent($infos) {
            if (empty($_SESSION)) session_start();
            if (!empty($_SESSION["user"]) && $_SESSION["user"]->role == "etudiant")
                require_once VIEWS.DS.'accueil-etudiant.php';
            else if (!empty($_SESSION["user"]) && $_SESSION["user"]->role == "professeur")
                require_once VIEWS.DS.'accueil-professeur.php';
            else if (!empty($_SESSION["user"]) && $_SESSION["user"]->role == "administrateur"){
                $_SESSION["etudiants"] = Etudiant::all();
                $_SESSION["professeurs"] = Professeur::all();
                $_SESSION["administrateurs"] = Administrateur::all();
                $_SESSION["matieres"] = Matiere::all();    
                require_once VIEWS.DS.'accueil-administrateur.php';
            } else
                require_once VIEWS.DS.'accueil.php';
            ob_flush();
        }
    }
