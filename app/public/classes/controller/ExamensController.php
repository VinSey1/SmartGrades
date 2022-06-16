<?php
    require_once CLASSES.DS.'Controller.php';
    class ExamensController extends Controller {
        function showContent($infos) {
            if (empty($_SESSION)) session_start();
            if (!empty($_SESSION["user"]) && $_SESSION["user"]->role == "professeur") {
                $examens = $_SESSION["user"]->professeur->examens;
                $examens_publies = array();
                $examens_non_publies = array();
                foreach ($examens as $key => $examen) {
                    $date = new DateTime($examen->date_examen);
                    $examen->date_examen = $date->format('d/m/Y');
                    if($examen->examen_publie) {
                        array_push($examens_publies, $examen);
                    } else {
                        array_push($examens_non_publies, $examen);
                    }
                }
                $_SESSION['examens_publies'] = $examens_publies;
                $_SESSION['examens_non_publies'] = $examens_non_publies;
                require_once VIEWS.DS.'examens.php';
            } else {
                require_once VIEWS.DS.'erreur.php';
            }
            ob_flush();
        }
    }
