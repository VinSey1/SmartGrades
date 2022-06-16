<?php
    require_once CLASSES.DS.'Controller.php';
    require_once M_CLASSES.DS.'examen.php';
    require_once M_CLASSES.DS.'matiere.php';
    require_once M_CLASSES.DS.'etudiant.php';
    class NoterController extends Controller {
        function showContent($infos) {
            if (empty($_SESSION)) session_start();
            if (count($infos) > 1 && !empty($_SESSION["user"]) && $_SESSION["user"]->role == "professeur") {
                $_SESSION['examen'] = Examen::first($infos[0]);
                $_SESSION['etudiant'] = Etudiant::first($infos[1]);
                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if(array_key_exists('noter', $_POST)) {
                        $_SESSION['etudiant']->addNote($_SESSION['examen'], $_POST['note']);
                        $id = $_SESSION['examen']->id;
                        header("Location: /examen/$id");
                    }
                    if(array_key_exists('absent', $_POST)) {
                        $_SESSION['etudiant']->addNote($_SESSION['examen'], "-2");
                        $id = $_SESSION['examen']->id;
                        header("Location: /examen/$id");
                    }
                }
                require_once VIEWS.DS.'noter.php';
            } else {
                require_once VIEWS.DS.'erreur.php';
            }
            ob_flush();
        }
    }
