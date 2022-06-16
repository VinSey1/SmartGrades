<?php
    require_once CLASSES.DS.'Controller.php';
    require_once M_CLASSES.DS.'examen.php';
    require_once M_CLASSES.DS.'matiere.php';
    class ExamenController extends Controller {
        function showContent($infos) {
            if (empty($_SESSION)) session_start();
            if (count($infos) > 0 && !empty($_SESSION["user"])) {
                if($_SESSION["user"]->role == "professeur") {
                    $examen = Examen::first($infos[0]);
                    if($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if(array_key_exists('add_matiere', $_POST)) {
                            $matiere = Matiere::first(intval($_POST['matiere']));
                            $examen->addMatiere($matiere);
                        } elseif(array_key_exists('delete_matiere', $_POST)) {
                            $matiere = Matiere::first(intval($_POST['matiere']));
                            $examen->deleteMatiere($matiere);
                        } elseif(array_key_exists('update', $_POST)) {
                            $examen->type = $_POST['type'];
                            $examen->date_examen = $_POST['date'];
                            $examen->update();
                        } elseif(array_key_exists('publier', $_POST)) {
                            $examen->examen_publie = 1;
                            $examen->update();
                            header('Location: /examens');
                        } elseif(array_key_exists('supprimer', $_POST)) {
                            $examen->delete();
                            header('Location: /examens');
                        }
                    }
                    $_SESSION["examen"] = Examen::first($infos[0]);
                    $matieres_ajoutables = array();
                    foreach ($_SESSION["user"]->professeur->matieres as $key => $matiere) {
                        if(!in_array($matiere, $_SESSION["examen"]->matieres)) {
                            array_push($matieres_ajoutables, $matiere);
                        }
                    }
                    $_SESSION["matieres_ajoutables"] = $matieres_ajoutables;
                    require_once VIEWS.DS.'examen-professeur.php';
                } else if($_SESSION["user"]->role == "etudiant") {
                    $_SESSION["examen"] = Examen::first($infos[0]);
                    require_once VIEWS.DS.'examen-etudiant.php';
                }
            } else {
                require_once VIEWS.DS.'erreur.php';
            }
            ob_flush();
        }
    }
