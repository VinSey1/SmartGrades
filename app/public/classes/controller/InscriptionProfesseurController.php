<?php

require_once CLASSES . DS . 'Controller.php';
require_once M_CLASSES . DS . 'classe.php';
require_once M_CLASSES . DS . 'matiere.php';
class InscriptionProfesseurController extends Controller {
    function showContent($infos) {
        if (empty($_SESSION)) {
            session_start();
        }

        if (!empty($_SESSION["user"]) && $_SESSION["user"]->role == "administrateur") {

            if ($_POST["submitCreateProfesseur"] !== null) {

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
                if (empty($_POST["numero_professeur"]) || !preg_match('/^[0-9]{8}$/', $_POST["numero_professeur"])) {
                    array_push($arrayInvalide, "numero_professeur");
                }
                if (empty($_POST["id_gitlab"]) || !preg_match('/^@[a-zA-Z0-9]+$/', $_POST["id_gitlab"])) {
                    array_push($arrayInvalide, "id_gitlab");
                }
                if (empty($arrayInvalide)) {
                    if ($this->insertProfesseur()) {
                        $_SESSION['success'] = "Votre ajout est un succès !";
                        header('Location: /'.$_SESSION['user']->role.'/professeurs');
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

    private function insertProfesseur(): bool {

        $array_user = array_slice($_POST, 0, 4);
        $array_prof = array_slice($_POST, 4, count($_POST) - 1); //don't keep button...

        $insertedId = API::insertProfessorAndUser($array_prof, $array_user, false);

        $person = Professeur::first($insertedId);

        $resultat3 = true;
        foreach (json_decode(base64_decode($_POST['listeClassesSelectedP'])) as $idClasse){
            if ($resultat3){
                $resultat3 = $person->addClasse(Classe::first(intval($idClasse)));
            }
        }
        $resultat4 = true;
        foreach (json_decode(base64_decode($_POST['listeMatieresSelectedP'])) as $idMatiere)
            if ($resultat4)
                $resultat4 = $person->addMatiere(Matiere::first(intval($idMatiere)));

        return ($insertedId && $resultat3 && $resultat4);
    }

    private function returnOnForm(): void {
        $classes = Classe::all();
        $matieres = Matiere::all();
        require VIEWS . DS . 'InscriptionProfesseur.php';
    }
}
