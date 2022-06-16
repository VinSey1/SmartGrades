<?php
require_once CLASSES . DS . 'Controller.php';
require_once M_CLASSES . DS . 'classe.php';
require_once CLASSES . DS . 'MettreAJourPerson.php';
class EtudiantController extends Controller {
    function showContent($infos) {
        if (empty($_SESSION)) session_start();
        if (!empty($_SESSION["user"])) {
            if (count($infos) == 1) {
                if ($_SESSION["user"]->role == "administrateur") {
                    $etudiant =  Etudiant::first($infos[0]);
                    $user = $etudiant->user;
                    $classes = Classe::all();
                    $saClasse = $etudiant->classe;
                    $matieres = Matiere::all();
                    $sesMatieres = $etudiant->matieres;

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (array_key_exists('details', $_POST)) {
                            require_once VIEWS . DS . 'etudiant.php';
                        } else if (array_key_exists('modif', $_POST)) {
                            // pour les classes
                            $laClasseSelectedE = $saClasse->id;
                            $_POST['laClasseSelectedE'] = base64_encode(json_encode($laClasseSelectedE));
                            // pour les matières
                            $listeMatieresSelectedE = array();
                            foreach ($sesMatieres as $m) {
                                $listeMatieresSelectedE[] = $m->id;
                            }
                            $_POST['listeMatieresSelectedE'] = base64_encode(json_encode($listeMatieresSelectedE));
                            require VIEWS . DS . 'edit-person-administrateur.php';
                        } else if (array_key_exists('suppr', $_POST)) {
                            $etudiant->delete();
                            $user->delete();
                            $_SESSION['success'] = "Votre suppression est un succès !";
                            header('Location: /' . $_SESSION['user']->role . '/etudiants');
                        } else if (array_key_exists('mettreAJour', $_POST)) {
                            MettreAJourPerson::maj($etudiant);
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
