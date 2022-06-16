<?php
require_once CLASSES . DS . 'Controller.php';
require_once M_CLASSES . DS . 'classe.php';
require_once M_CLASSES . DS . 'matiere.php';
require_once CLASSES . DS . 'MettreAJourPerson.php';
class ProfesseurController extends Controller {
    function showContent($infos) {
        if (empty($_SESSION)) session_start();
        if (!empty($_SESSION["user"])) {
            if (count($infos) == 1) {
                if ($_SESSION["user"]->role == "administrateur") {
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $professeur =  Professeur::first($infos[0]);
                        $user = $professeur->user;
                        $classes = Classe::all();
                        $sesClasses = $professeur->classes;
                        $matieres = Matiere::all();
                        $sesMatieres = $professeur->matieres;

                        if (array_key_exists('details', $_POST)) {
                            require_once VIEWS . DS . 'professeur.php';
                        } else if (array_key_exists('modif', $_POST)) {
                            // pour les classes
                            $listeClassesSelectedP = array();
                            foreach ($sesClasses as $c) {
                                $listeClassesSelectedP[] = $c->id;
                            }
                            $_POST['listeClassesSelectedP'] = base64_encode(json_encode($listeClassesSelectedP));
                            // pour les matières
                            $listeMatieresSelectedP = array();
                            foreach ($sesMatieres as $m) {
                                $listeMatieresSelectedP[] = $m->id;
                            }
                            $_POST['listeMatieresSelectedP'] = base64_encode(json_encode($listeMatieresSelectedP));
                            require VIEWS . DS . 'edit-person-administrateur.php';
                        } else if (array_key_exists('suppr', $_POST)) {
                            $professeur->delete();
                            $user->delete();
                            $_SESSION['success'] = "Votre suppression est un succès !";
                            header('Location: /' . $_SESSION['user']->role . '/professeurs');
                        } else if (array_key_exists('mettreAJour', $_POST)) {
                            MettreAJourPerson::maj($professeur);
                        }
                    }
                } else {
                    require_once VIEWS . DS . 'etudiant.php';
                }
            }
        } else {
            require_once VIEWS . DS . 'erreur.php';
        }
        ob_flush();
    }
}
