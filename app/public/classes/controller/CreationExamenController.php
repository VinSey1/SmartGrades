<?php
    require_once CLASSES.DS.'Controller.php';
    require_once M_CLASSES.DS.'examen.php';
    require_once M_CLASSES.DS.'question.php';
    require_once M_CLASSES.DS.'matiere.php';
    class CreationExamenController extends Controller {
        function showContent($infos) {
            if (empty($_SESSION)) session_start();
            if (!empty($_SESSION["user"]) && $_SESSION["user"]->role == "professeur") {
                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $_SESSION["examen"]->intitule = $_POST["intitule"];
                    $_SESSION["examen"]->date_examen = $_POST['date'];
                    $_SESSION["examen"]->type = $_POST['type'];
                    if(array_key_exists('add_matiere', $_POST)) {
                        $matiere = Matiere::first(intval($_POST['matiere']));
                        array_push($_SESSION["matieres"], $matiere);
                    } elseif(array_key_exists('delete_matiere', $_POST)) {
                        $matiere = Matiere::first(intval($_POST['matiere']));
                        if (($key = array_search($matiere, $_SESSION["matieres"])) !== false) {
                            unset($_SESSION["matieres"][$key]);
                        }
                    } elseif(array_key_exists('add_question', $_POST)) {
                        $question = new Question();
                        $question->contenu = $_POST['question'];
                        $question->commentaire = $_POST['commentaire'];
                        $question->points = $_POST['note'];
                        array_push($_SESSION["questions"], $question);
                    } elseif(array_key_exists('delete_question', $_POST)) {
                        unset($_SESSION["questions"][$_POST['index_question']]);
                    } elseif(array_key_exists('add_examen', $_POST)) {
                        $_SESSION['examen']->examen_publie = 0;
                        $_SESSION['examen']->insert();
                        $_SESSION['examen']->initialiseExamen($_SESSION['user']->professeur, $_SESSION['questions'], $_SESSION['matieres']);
                        header('Location: /examens');
                    }
                } else {
                    $_SESSION["examen"] = new Examen();
                    $_SESSION["questions"] = array();
                    $_SESSION["matieres"] = array();
                }
                
                $matieres_ajoutables = array();
                foreach ($_SESSION["user"]->professeur->matieres as $key => $matiere) {
                    if(!in_array($matiere, $_SESSION["matieres"])) {
                        array_push($matieres_ajoutables, $matiere);
                    }
                }
                $_SESSION["matieres_ajoutables"] = $matieres_ajoutables;
                require_once VIEWS.DS.'creation-examen.php';
            } else {
                require_once VIEWS.DS.'erreur.php';
            }
            ob_flush();
        }
    }
