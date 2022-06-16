<?php
    require_once CLASSES.DS.'Controller.php';
    class EditcursusController extends Controller {
        function showContent($infos) {
            if (empty($_SESSION)) session_start();
            if (!empty($_SESSION["user"]) && ($_SESSION["user"]->role == "professeur" || $_SESSION["user"]->role == "administrateur")) {
                // Soumission du formulaire
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    function insererNouveauCursus() {
                        // Création d'un nouveau cursus dans la BDD
                        $classe = new Classe();
                        require_once M_CLASSES.DS.'annee_scolaire.php';
                        $anneeScolaireExistante = AnneeScolaire::first(['intitule', '=', $_POST['promotion']]);
                        if ($anneeScolaireExistante === null) {
                            // Création d'une année scolaire dans la base si celle-ci n'existe pas
                            $anneeScolaireExistante = new AnneeScolaire();
                            $anneeScolaireExistante->intitule = $_POST['promotion'];
                            $operationBDDClasse = $anneeScolaireExistante->insert();
                        } else {
                            $operationBDDClasse = true;
                        }
                        $classe->id_annee_scolaire = $anneeScolaireExistante->id;
                        $classe->promotion = empty($_POST['cursusExistant'])?$_POST['cursus']:$_POST['cursusExistant'];
                        $classe->intitule = $_POST['intitule'];
                        if ($operationBDDClasse)
                            $operationBDDClasse = $classe->insert();
                        // Ajout des étudiants à ce nouveau cursus
                        require_once M_CLASSES.DS.'etudiant.php';
                        foreach (json_decode(base64_decode($_POST['listeEtudiants'])) as $idEtudiant) {
                            $etudiantAModifier = Etudiant::first(intval($idEtudiant));
                            $etudiantAModifier->id_classe = $classe->id;
                            if ($operationBDDClasse)
                                $operationBDDClasse = $etudiantAModifier->update();
                        }
                        // Ajout des professeurs responsables à ce nouveau cursus
                        foreach (json_decode(base64_decode($_POST['listeProfesseurs'])) as $idProfesseur)
                            if ($operationBDDClasse)
                                $operationBDDClasse = $classe->addProfesseur(Professeur::first(intval($idProfesseur)));
                        if ($_SESSION["user"]->role == "professeur" && !in_array($_SESSION["user"]->professeur->id, json_decode(base64_decode($_POST['listeProfesseurs']))) && $operationBDDClasse)
                            $operationBDDClasse = $classe->addProfesseur($_SESSION["user"]->professeur);
                        return $operationBDDClasse;
                    }
                    // À appeler quand le formulaire est validé
                    function cloturerFormulaire() {
                        require_once M_CLASSES.DS.'classe.php';
                        if (isset($_SESSION['idCursusExistant'])) {
                            if ($_SESSION['codeOperation'] == 1) {
                                // Modification d'un cursus existant dans la BDD
                                $classe = Classe::first($_SESSION['idCursusExistant']);
                                require_once M_CLASSES.DS.'annee_scolaire.php';
                                $anneeScolaireExistante = AnneeScolaire::first(['intitule', '=', $_POST['promotion']]);
                                if ($anneeScolaireExistante === null) {
                                    // Création d'une année scolaire dans la base si celle-ci n'existe pas
                                    $anneeScolaireExistante = new AnneeScolaire();
                                    $anneeScolaireExistante->intitule = $_POST['promotion'];
                                    $operationBDDClasse = $anneeScolaireExistante->insert();
                                } else {
                                    $operationBDDClasse = true;
                                }
                                $classe->id_annee_scolaire = $anneeScolaireExistante->id;
                                $classe->promotion = empty($_POST['cursusExistant'])?$_POST['cursus']:$_POST['cursusExistant'];
                                $classe->intitule = $_POST['intitule'];
                                // On teste si la liste des étudiants a changé ou pas
                                $listeEtudiants = array();
                                foreach ($classe->etudiants as $etudiant)
                                    $listeEtudiants[] = strval($etudiant->id);
                                if ($listeEtudiants != json_decode(base64_decode($_POST['listeEtudiants']))) {
                                    // On attribut tous les étudiants choisis à cette classe
                                    require_once M_CLASSES.DS.'etudiant.php';
                                    foreach (json_decode(base64_decode($_POST['listeEtudiants'])) as $idEtudiant) {
                                        $etudiantAModifier = Etudiant::first(intval($idEtudiant));
                                        $etudiantAModifier->id_classe = $classe->id;
                                        if ($operationBDDClasse)
                                            $operationBDDClasse = $etudiantAModifier->update();
                                    }
                                }
                                // On teste si la liste de profs a changé ou pas
                                $listeProfesseurs = array();
                                foreach ($classe->professeurs as $professeur)
                                    $listeProfesseurs[] = strval($professeur->id);
                                if ($listeProfesseurs == json_decode(base64_decode($_POST['listeProfesseurs']))) {
                                    // Les profs n'ont pas changé alors on fait le update "standard" (permission fail - si on avait changé que les étudiants)
                                    if ($operationBDDClasse)
                                        $classe->update();
                                } else {
                                    // On supprime tous les anciens professeurs et on ajoute les nouveaux à la place
                                    foreach ($classe->professeurs as $professeur)
                                        if ($operationBDDClasse)
                                            $operationBDDClasse = $classe->removeProfesseur($professeur);
                                    foreach (json_decode(base64_decode($_POST['listeProfesseurs'])) as $idProfesseur)
                                        if ($operationBDDClasse)
                                            $operationBDDClasse = $classe->addProfesseur(Professeur::first(intval($idProfesseur)));
                                    if ($_SESSION["user"]->role == "professeur" && !in_array($_SESSION["user"]->professeur->id, json_decode(base64_decode($_POST['listeProfesseurs']))) && $operationBDDClasse)
                                        $operationBDDClasse = $classe->addProfesseur($_SESSION["user"]->professeur);
                                    // On permet le fail (celui-ci arriverait si on avait changé uniquement les profs et rien d'autre)
                                    if ($operationBDDClasse)
                                        $classe->update();
                                }
                            } else if ($_SESSION['codeOperation'] == 2) {
                                // Suppression du cursus de la BDD
                                $classe = Classe::first($_SESSION['idCursusExistant']);
                                if (count($classe->etudiants) > 0)
                                    $operationBDDClasse = false;
                                else
                                    $operationBDDClasse = true;
                                foreach ($classe->professeurs as $professeur)
                                    if ($operationBDDClasse)
                                        $operationBDDClasse = $classe->removeProfesseur($professeur);
                                if ($operationBDDClasse)
                                    $operationBDDClasse = $classe->delete();
                            } else if ($_SESSION['codeOperation'] == 4) {
                                // Création d'un nouveau cursus dans la BDD
                                $operationBDDClasse = insererNouveauCursus();
                            }
                        } else
                            $operationBDDClasse = insererNouveauCursus();
                        if ($operationBDDClasse) {
                            // Je vide les variables qui ne sont plus nécessaires
                            unset($_SESSION['cursusExistants']);
                            unset($_SESSION['etudiants']);
                            unset($_SESSION['professeurs']);
                            unset($_SESSION['idCursusExistant']);
                            unset($_SESSION['codeOperation']);
                            header('Location: /'.$_SESSION['user']->role.'/cursus');
                        } else {
                            $_POST['erreur'] = "Il n'a pas été possible de modifier les données dans la base de données ! Pour supprimer une classe elle ne doit pas avoir d'étudiants d'associés !";
                            require_once VIEWS.DS.'editcursus.php';
                            ob_flush();
                        }
                    }
                    $validation = true;
                    // Validation champ promotion
                    if (!empty($_POST['promotion']) && preg_match('/^[0-9]{4}-[0-9]{4}$/', $_POST['promotion'])) {
                        $anneesChoisies = explode('-', $_POST['promotion']);
                        if (intval($anneesChoisies[1]) - intval($anneesChoisies[0]) != 1) {
                            $_POST['validationPromotion'] = 'is-invalid';
                            $validation = false;
                        }
                    } else {
                        $_POST['validationPromotion'] = 'is-invalid';
                        $validation = false;
                    }
                    // Validation champs cursusExistant et cursus
                    if (empty($_POST['cursusExistant']) && empty($_POST['cursus'])) {
                        $_POST['validationCursusExistant'] = 'is-invalid';
                        $_POST['validationCursus'] = 'is-invalid';
                        $validation = false;
                    }
                    // Validation champ intitule
                    if (empty($_POST['intitule'])) {
                        $_POST['validationIntitule'] = 'is-invalid';
                        $validation = false;
                    }
                    // Validation champ listeProfesseurs
                    if (empty(json_decode(base64_decode($_POST['listeProfesseurs'])))) {
                        $_POST['validationListeProfesseurs'] = 'is-invalid';
                        $validation = false;
                    }
                    if ($validation)
                        cloturerFormulaire();
                    else {
                        require_once VIEWS.DS.'editcursus.php';
                        ob_flush();
                    }
                }
                // Chargement des données existantes depuis la BDD
                require_once M_CLASSES.DS.'annee_scolaire.php';
                $classes = AnneeScolaire::first(['intitule', '=', $_SESSION['anneeScolaire']])->classes;
                $cursusExistants = array();
                if ($classes !== null)
                    foreach ($classes as $classe)
                        if (!in_array($classe->promotion, $cursusExistants, true))
                            array_push($cursusExistants, $classe->promotion);
                $_SESSION['cursusExistants'] = $cursusExistants;
                require_once M_CLASSES.DS.'etudiant.php';
                $etudiants = Etudiant::all();
                $_SESSION['etudiants'] = $etudiants;
                require_once M_CLASSES.DS.'professeur.php';
                $professeurs = Professeur::all();
                $_SESSION['professeurs'] = $professeurs;
                // Pré-remplissage de l'année scolaire
                $_POST['promotion'] = $_SESSION['anneeScolaire'];
                // Remplissage de valeur pour afficher dans le formulaire
                if (count($infos) > 0) {
                    // Si un identifiant à été passé
                    $_SESSION['idCursusExistant'] = $infos[0];
                    $_SESSION['codeOperation'] = $infos[1];
                    if ($infos[1] == 1) {
                        $_POST['titrePage'] = "Modification";
                        $_POST['titreBouton'] = "Modifier cursus/btn-warning";
                    } else if ($infos[1] == 2) {
                        $_POST['titrePage'] = "Suppression";
                        $_POST['titreBouton'] = "Supprimer cursus/btn-danger";
                    } else if ($infos[1] == 3) {
                        $_POST['titrePage'] = "Affichage";
                    } else if ($infos[1] == 4) {
                        $_POST['titrePage'] = "Duplication";
                        $_POST['titreBouton'] = "Dupliquer cursus/btn-info";
                    }
                    $classe = Classe::first($infos[0]);
                    $_POST['cursusExistant'] = $classe->promotion;
                    $_POST['intitule'] = $classe->intitule;
                    $listeEtudiants = array();
                    foreach ($classe->etudiants as $etudiant) {
                        $listeEtudiants[] = $etudiant->id;
                    }
                    $_POST['listeEtudiants'] = base64_encode(json_encode($listeEtudiants));
                    $_POST['listeEtudiantsDeBase'] = base64_encode(json_encode($listeEtudiants));
                    $listeProfesseurs = array();
                    foreach ($classe->professeurs as $professeur) {
                        $listeProfesseurs[] = $professeur->id;
                    }
                    $_POST['listeProfesseurs'] = base64_encode(json_encode($listeProfesseurs));
                } else {
                    $_POST['titrePage'] = "Ajout";
                    $_POST['titreBouton'] = "Ajouter cursus/btn-primary";
                    unset($_SESSION['idCursusExistant']);
                    unset($_SESSION['codeOperation']);
                }
                require_once VIEWS.DS.'editcursus.php';
            } else
                require_once VIEWS.DS.'erreur.php';
            ob_flush();
        }
    }
?>
