<?php

require_once CLASSES . DS . 'Controller.php';
class InscriptionAdministrateurController extends Controller {
    function showContent($infos) {
        if (empty($_SESSION)) {
            session_start();
        }

        if (!empty($_SESSION["user"]) && $_SESSION["user"]->role == "administrateur") {

            if ($_POST["submitCreateAdministrateur"] !== null) {

                $arrayInvalide = array();
                if (empty($_POST["nom"]) || preg_match('/~[0-9]+~/', $_POST["nom"])) {
                    array_push($arrayInvalide, "nom");
                }
                if (empty($_POST["prenom"]) || preg_match('/~[0-9]+~/', $_POST["prenom"])) {
                    array_push($arrayInvalide, "prenom");
                }
                if (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                    array_push($arrayInvalide, "email");
                }
                if (empty($_POST["date_naissance"]) || !preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $_POST["date_naissance"])) {
                    array_push($arrayInvalide, "date_naissance");
                }
                if (empty($arrayInvalide)) {
                    if (API::insertAdministrateurAndUser($_POST)) {
                        $_SESSION['success'] = "Votre ajout est un succès !";
                        header('Location: /'.$_SESSION['user']->role.'/administrateurs');
                    } else {
                        $_SESSION["error"] = "Une erreur est survenue veuillez soumettre à nouveau l'inscription";
                        $_SESSION["old"] = $_POST;
                        $this->returnOnForm();
                    }
                } else {
                    $_SESSION["error"] = "Une erreur est survenue car l'un des champs est incorrect";
                    $_SESSION["old"] = $_POST;
                    $this->returnOnForm();
                }
            } else {
                $this->returnOnForm();
            }
        } else {
            require_once VIEWS . DS . 'erreur.php';
        }
        ob_flush();
    }

    private function returnOnForm(): void {
        require VIEWS . DS . 'InscriptionAdministrateur.php';
    }
}
