<?php
    require_once CLASSES.DS.'Controller.php';
    class TestModelController extends Controller {
        function showContent($infos) {

            if (empty($_SESSION)){
                session_start();
            }
            require_once ORM.DS.'CSVProcessor.php';
            require_once M_CLASSES.DS.'user.php';
            require_once M_CLASSES.DS.'professeur.php';
            require_once M_CLASSES.DS.'matiere.php';
            require_once M_CLASSES.DS.'administrateur.php';
            require_once M_CLASSES.DS.'classe.php';
            require_once M_CLASSES.DS.'etudiant.php';
            require_once M_CLASSES.DS.'examen.php';
            require_once M_CLASSES.DS.'question.php';
            require_once ORM.DS.'Mailer.php';
            require_once M_CLASSES.DS.'annee_scolaire.php';
            
            if(isset($_POST["Load"])) {
                $_SESSION["error"] = "";
                if(isset($_FILES["uploadedFile"]) && $_FILES["uploadedFile"]["error"] === UPLOAD_ERR_OK ){
                    CSVProcessor::processCSV("uploadedFile", "STUDENT");
                }
            }else if (isset($_POST["LoadProf"])) {
                $_SESSION["error"] = "";
                if(isset($_FILES["uploadedFile"]) && $_FILES["uploadedFile"]["error"] === UPLOAD_ERR_OK ){
                    CSVProcessor::processCSV("uploadedFile", "PROFESSOR");
                }
            }
            require VIEWS.DS.'testModel.php';

            ob_flush();
        }
    }
?>