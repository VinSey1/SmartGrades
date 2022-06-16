<?php
require_once M_CLASSES . DS . 'classe.php';
require_once M_CLASSES . DS . 'matiere.php';
require_once M_CLASSES . DS . 'etudiant.php';
require_once M_CLASSES . DS . 'administrateur.php';

class MettreAJourPerson {

    static function maj($person) {
        $user = $person->user;
        $roleInitial = $user->role;
        // common part validation
        $arrayInvalide = array();
        if (empty($_POST["name"]) || preg_match('/~[0-9]+~/', $_POST["name"])) {
            array_push($arrayInvalide, "name");
        }
        if (empty($_POST["surname"]) || preg_match('/~[0-9]+~/', $_POST["surname"])) {
            array_push($arrayInvalide, "surname");
        }
        if (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            array_push($arrayInvalide, "email");
        }
        if (empty($_POST["date_naissance"]) || !preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $_POST["date_naissance"])) {
            array_push($arrayInvalide, "date_naissance");
        }

        // étudiant part validation
        if ($_POST["role"] == "etudiant") {
            if (empty($_POST["numero_etudiant"]) || !preg_match('/^[0-9]{8}$/', $_POST["numero_etudiant"])) {
                array_push($arrayInvalide, "numero_etudiant");
            }
            if (empty($_POST["id_gitlab_etudiant"]) || !preg_match('/^@[a-zA-Z0-9]+$/', $_POST["id_gitlab_etudiant"])) {
                array_push($arrayInvalide, "id_gitlab_etudiant");
            }
        }
        // professeur part validation
        if ($_POST["role"] == "professeur") {
            if (empty($_POST["numero_professeur"]) || !preg_match('/^[0-9]{8}$/', $_POST["numero_professeur"])) {
                array_push($arrayInvalide, "numero_professeur");
            }
            if (empty($_POST["id_gitlab_professeur"]) || !preg_match('/^@[a-zA-Z0-9]+$/', $_POST["id_gitlab_professeur"])) {
                array_push($arrayInvalide, "id_gitlab_professeur");
            }
        }
        // pas de partie spécifique à l'admin

        if (!empty($arrayInvalide)) {
            MettreAJourPerson::returnOnForm($arrayInvalide);
        } else {
            $user->name = $_POST["name"];
            $user->surname = $_POST["surname"];
            $user->email = $_POST["email"];
            $user->date_naissance = $_POST["date_naissance"];
            $resultat1 = $user->update();

            if ($_POST["role"] == "etudiant") {
                if ($roleInitial == 'etudiant') {
                    $person->numero_etudiant = $_POST["numero_etudiant"];
                    $person->id_classe = $_POST["classeId"];
                    $person->id_gitlab = $_POST["id_gitlab_etudiant"];
                    if ($_POST["tier_temps"] === "oui") {
                        $person->tier_temps = 1;
                    } else {
                        $person->tier_temps = 0;
                    }
                    $person->cursus_postbac = $_POST["cursus_postbac"];
                    $person->statut = $_POST["statut"];
                    $person->id_classe = Classe::first(intval(json_decode(base64_decode($_POST['laClasseSelectedE']))))->id;
                    $resultat2 = $person->update(); // mettre à jour l'étudiant déjà existant

                    if (!$resultat1 && !$resultat2) {
                        array_push($arrayInvalide, "erreurUpdate");
                        MettreAJourPerson::returnOnForm($arrayInvalide);
                        return;
                    }
                } else if ($roleInitial == 'professeur' || $roleInitial == 'administrateur') {
                    $person->delete();

                    $person = new Etudiant();
                    $person->id_user = $user->id;
                    $person->numero_etudiant = $_POST["numero_etudiant"];
                    $person->id_classe = $_POST["classeId"];
                    $person->id_gitlab = $_POST["id_gitlab_etudiant"];
                    if ($_POST["tier_temps"] === "oui") {
                        $person->tier_temps = 1;
                    } else {
                        $person->tier_temps = 0;
                    }
                    $person->cursus_postbac = $_POST["cursus_postbac"];
                    $person->statut = $_POST["statut"];
                    $person->id_classe = Classe::first(intval(json_decode(base64_decode($_POST['laClasseSelectedE']))))->id;
                    $resultat2 = $person->insert(); // insérer l'étudiant fraichement créé

                    if (!$resultat1 && !$resultat2) {
                        array_push($arrayInvalide, "erreurUpdate");
                        MettreAJourPerson::returnOnForm($arrayInvalide);
                        return;
                    }

                    $user->role = "etudiant";
                    $resultat2 = $user->update(); // indiquer le changement pour la base user
                    if (!$resultat1 && !$resultat2) {
                        array_push($arrayInvalide, "erreurUpdate");
                        MettreAJourPerson::returnOnForm($arrayInvalide);
                        return;
                    }
                }
                $resultat3 = true;
                foreach ($person->matieres as $m)
                    if ($resultat3)
                        $resultat3 = $person->removeMatiere($m);
                foreach (json_decode(base64_decode($_POST['listeMatieresSelectedE'])) as $idMatiere)
                    if ($resultat3)
                        $resultat3 = $person->addMatiere(Matiere::first(intval($idMatiere)));

                if (!$resultat1 && !$resultat2 && !$resultat3) {
                    array_push($arrayInvalide, "erreurUpdate");
                    MettreAJourPerson::returnOnForm($arrayInvalide);
                    return;
                }
            }

            if ($_POST["role"] == "professeur") {
                if ($roleInitial == 'professeur') {
                    $person->numero_professeur = $_POST["numero_professeur"];
                    $person->id_gitlab = $_POST["id_gitlab_professeur"];
                    $resultat2 = $person->update(); // mettre à jour le professeur déjà existant
                } else if ($roleInitial == 'etudiant' || $roleInitial == 'administrateur') {
                    $person->delete();

                    $person = new Professeur();
                    $person->numero_professeur = $_POST["numero_professeur"];
                    $person->id_gitlab = $_POST["id_gitlab_professeur"];
                    $person->id_user = $user->id;
                    $resultat2 = $person->insert(); // insérer le professeur fraichement créé
                    if (!$resultat1 && !$resultat2) {
                        array_push($arrayInvalide, "erreurUpdate");
                        MettreAJourPerson::returnOnForm($arrayInvalide);
                        return;
                    }
                    $user->role = "professeur";
                    $resultat2 = $user->update(); // indiquer le changement pour la base user
                    if (!$resultat1 && !$resultat2) {
                        array_push($arrayInvalide, "erreurUpdate");
                        MettreAJourPerson::returnOnForm($arrayInvalide);
                        return;
                    }
                }
                // On supprime toutes les anciennes matières et classes du professeur et on ajoute les nouvelles à la place
                $resultat3 = true;
                foreach ($person->classes as $c){
                    if ($resultat3){
                        $resultat3 = $person->removeClasse($c);
                    }
                }
                foreach (json_decode(base64_decode($_POST['listeClassesSelectedP'])) as $idClasse){
                    if ($resultat3){
                        $resultat3 = $person->addClasse(Classe::first(intval($idClasse)));
                    }
                }
                $resultat4 = true;
                foreach ($person->matieres as $m)
                    if ($resultat4)
                        $resultat4 = $person->removeMatiere($m);
                foreach (json_decode(base64_decode($_POST['listeMatieresSelectedP'])) as $idMatiere)
                    if ($resultat4)
                        $resultat4 = $person->addMatiere(Matiere::first(intval($idMatiere)));

                if (!$resultat1 && !$resultat2 && !$resultat3 && !$resultat4) {
                    array_push($arrayInvalide, "erreurUpdate");
                    MettreAJourPerson::returnOnForm($arrayInvalide);
                    return;
                }
            }

            if ($_POST["role"] == "administrateur") {
                if ($roleInitial == 'administrateur') {
                    // aucun attribut spécifique à admin
                } else if ($roleInitial == 'etudiant' || $roleInitial == 'professeur') {
                    $person->delete();

                    $admin = new Administrateur();
                    $admin->id_user = $user->id;
                    $resultat = $admin->insert(); // insérer l'administrateur fraichement créé
                    if (!$resultat1 && !$resultat) {
                        array_push($arrayInvalide, "erreurUpdate");
                        MettreAJourPerson::returnOnForm($arrayInvalide);
                        return;
                    }

                    $user->role = "administrateur";
                    $resultat = $user->update(); // indiquer le changement pour la base user
                    if (!$resultat1 && !$resultat) {
                        array_push($arrayInvalide, "erreurUpdate");
                        MettreAJourPerson::returnOnForm($arrayInvalide);
                        return;
                    }
                }
            }
            $_SESSION['success'] = "Votre modification est un succès !";
            if ($_POST["role"] == 'etudiant') {
                header('Location: /' . $_SESSION['user']->role . '/etudiants');
            } else if ($_POST["role"] == 'professeur') {
                header('Location: /' . $_SESSION['user']->role . '/professeurs');
            } else if ($_POST["role"] == 'administrateur') {
                header('Location: /' . $_SESSION['user']->role . '/administrateurs');
            }
        }
    }

    private function returnOnForm($arrayInvalide): void {
        $arrayInvalide = $arrayInvalide;
        $classes = Classe::all();
        $matieres = Matiere::all();
        if($_POST["role"] == 'etudiant'){
            $saClasse = $_POST['laClasseSelectedE'];
            $sesMatieres = $_POST['listeMatieresSelectedE'];
        } else if($_POST["role"] == 'professeur'){
            $sesClasses = $_POST['listeClassesSelectedP'];
            $sesMatieres = $_POST['listeMatieresSelectedP'];
        }
        require_once VIEWS . DS . 'edit-person-administrateur.php';
    }
}
