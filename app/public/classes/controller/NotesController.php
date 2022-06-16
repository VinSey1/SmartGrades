<?php
    require_once CLASSES.DS.'Controller.php';
    require_once M_CLASSES.DS.'examen.php';
    require_once M_CLASSES.DS.'matiere.php';
    require_once M_CLASSES.DS.'etudiant.php';
    class NotesController extends Controller {
        function showContent($infos) {
            if (empty($_SESSION)) session_start();
            if (!empty($_SESSION["user"]) && $_SESSION["user"]->role == "etudiant") {
                $_SESSION['examens'] = $_SESSION["user"]->etudiant->examens;
                require_once VIEWS.DS.'notes.php';
            } else {
                require_once VIEWS.DS.'erreur.php';
            }
            ob_flush();
        }
    }
