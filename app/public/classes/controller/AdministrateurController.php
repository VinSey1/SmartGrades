<?php
require_once CLASSES . DS . 'Controller.php';
require_once M_CLASSES . DS . 'classe.php';
require_once M_CLASSES . DS . 'matiere.php';
require_once CLASSES . DS . 'MettreAJourPerson.php';
class AdministrateurController extends Controller {
    function showContent($infos) {
        if (empty($_SESSION)) session_start();
        if (!empty($_SESSION["user"])) {
            if (count($infos) == 1) {
                if ($_SESSION["user"]->role == "administrateur") {
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $administrateur =  Administrateur::first($infos[0]);
                        $user = $administrateur->user;
                        $classes = Classe::all();
                        $matieres = Matiere::all();

                        if (array_key_exists('details', $_POST)) {
                            require_once VIEWS . DS . 'administrateur.php';
                        } else if (array_key_exists('modif', $_POST)) {
                            require VIEWS . DS . 'edit-person-administrateur.php';
                        } else if (array_key_exists('suppr', $_POST)) {
                            $amountAdmin = count(Administrateur::all());
                            if($amountAdmin > 1){
                                $administrateur->delete();
                                $user->delete();
                                $_SESSION['success'] = "Votre suppression est un succès !";
                                header('Location: /' . $_SESSION['user']->role . '/administrateurs');
                            }else{
                                $_SESSION['error'] = "Votre application ne peut pas ne pas avoir d'administrateurs !";
                                header('Location: /' . $_SESSION['user']->role . '/administrateurs');
                            }
                        } else if (array_key_exists('mettreAJour', $_POST)) {
                            MettreAJourPerson::maj($administrateur);
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