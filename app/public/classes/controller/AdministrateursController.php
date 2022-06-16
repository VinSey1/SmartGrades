<?php
require_once CLASSES . DS . 'Controller.php';
require_once ORM . DS . 'Mailer.php';
require_once M_CLASSES . DS . 'administrateur.php';
class AdministrateursController extends Controller {
    function showContent($infos) {
        if (empty($_SESSION)) session_start();
        if (!empty($_SESSION["user"])) {
            if ($_SESSION["user"]->role == "administrateur") {
                if(isset($_POST["Load"])) {
                    $_SESSION["error"] = "";
                }
                $administrateurs = Administrateur::all();
                require_once VIEWS . DS . 'administrateurs.php';
            }
        } else {
            require_once VIEWS . DS . 'erreur.php';
        }
        ob_flush();
    }
}