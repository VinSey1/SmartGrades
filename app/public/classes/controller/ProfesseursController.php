<?php
require_once CLASSES . DS . 'Controller.php';
require_once ORM . DS . 'CSVProcessor.php';
require_once ORM . DS . 'Mailer.php';
class ProfesseursController extends Controller {
    function showContent($infos) {
        if (empty($_SESSION)) session_start();
        if (!empty($_SESSION["user"])) {
            if ($_SESSION["user"]->role == "administrateur") {
                if(isset($_POST["Load"])) {
                    $_SESSION["error"] = "";
                    if(isset($_FILES["uploadedFile"]) && $_FILES["uploadedFile"]["error"] === UPLOAD_ERR_OK ){
                        CSVProcessor::processCSV("uploadedFile", "PROFESSOR");
                    }
                }
                $professeurs = Professeur::all();
                require_once VIEWS . DS . 'professeurs.php';
            }
        } else {
            require_once VIEWS . DS . 'erreur.php';
        }
        ob_flush();
    }
}
