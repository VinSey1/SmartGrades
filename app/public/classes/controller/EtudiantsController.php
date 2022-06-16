<?php
require_once CLASSES . DS . 'Controller.php';
require_once ORM . DS . 'CSVProcessor.php';
require_once ORM . DS . 'Mailer.php';
class EtudiantsController extends Controller {
    function showContent($infos) {
        if (empty($_SESSION)) session_start();
        if (!empty($_SESSION["user"])) {
            
            if (count($infos) == 1) {
                if ($_SESSION["user"]->role == "professeur") {
                    // if(isset($_POST["Load"])) {
                    //     $_SESSION["error"] = "";
                    //     if(isset($_FILES["uploadedFile"]) && $_FILES["uploadedFile"]["error"] === UPLOAD_ERR_OK ){
                    //         CSVProcessor::processCSV("uploadedFile", "STUDENT");
                    //     }
                    // }
                    $etudiants = API::getListEtudiants_idProfIdMatiere_query($_SESSION["user"]->professeur->numero_professeur, $infos[0]);
                 
                    require_once VIEWS . DS . 'etudiants.php';
                }
            } else if ($_SESSION["user"]->role == "administrateur") {
                if(isset($_POST["Load"])) {
                    $_SESSION["error"] = "";
                    if(isset($_FILES["uploadedFile"]) && $_FILES["uploadedFile"]["error"] === UPLOAD_ERR_OK ){
                        CSVProcessor::processCSV("uploadedFile", "STUDENT");
                    }
                }
                $etudiants = Etudiant::all();
                require_once VIEWS . DS . 'etudiants.php';
            }
        } else {
            require_once VIEWS . DS . 'erreur.php';
        }
        ob_flush();
    }
}
