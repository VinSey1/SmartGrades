<?php
    require_once CLASSES.DS.'Controller.php';
    class EditmatiereController extends Controller {
        function showContent($infos) {
            if (empty($_SESSION)) session_start();
            if (!empty($_SESSION["user"]) && ($_SESSION["user"]->role == "professeur" || $_SESSION["user"]->role == "administrateur")) {
                // Soumission du formulaire
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    function insererNouvelleMatiere() {
                        // Création d'une nouvelle matière dans la BDD
                        $matiere = new Matiere();
                        require_once M_CLASSES.DS.'annee_scolaire.php';
                        $anneeScolaireExistante = AnneeScolaire::first(['intitule', '=', $_POST['promotion']]);
                        if ($anneeScolaireExistante === null) {
                            // Création d'une année scolaire dans la base si celle-ci n'existe pas
                            $anneeScolaireExistante = new AnneeScolaire();
                            $anneeScolaireExistante->intitule = $_POST['promotion'];
                            $operationBDDMatiere = $anneeScolaireExistante->insert();
                        } else {
                            $operationBDDMatiere = true;
                        }
                        $matiere->id_annee_scolaire = $anneeScolaireExistante->id;
                        $matiere->name_matiere = $_POST['nom'];
                        $matiere->description_matiere = $_POST['description'];
                        if ($operationBDDMatiere)
                            $operationBDDMatiere = $matiere->insert();
                        // Ajout des étudiants participants à cette nouvelle matière
                        foreach (json_decode(base64_decode($_POST['listeEtudiants'])) as $idEtudiant)
                            if ($operationBDDMatiere)
                                $operationBDDMatiere = $matiere->addEtudiant(Etudiant::first(intval($idEtudiant)));
                        // Ajout des professeurs enseignants à cette nouvelle matière
                        foreach (json_decode(base64_decode($_POST['listeProfesseurs'])) as $idProfesseur)
                            if ($operationBDDMatiere)
                                $operationBDDMatiere = $matiere->addProfesseur(Professeur::first(intval($idProfesseur)));
                        if ($_SESSION["user"]->role == "professeur" && !in_array($_SESSION["user"]->professeur->id, json_decode(base64_decode($_POST['listeProfesseurs']))) && $operationBDDMatiere)
                            $operationBDDMatiere = $matiere->addProfesseur($_SESSION["user"]->professeur);
                        return $operationBDDMatiere;
                    }
                    // À appeler quand le formulaire est validé
                    function cloturerFormulaire() {
                        require_once M_CLASSES.DS.'matiere.php';
                        if (isset($_SESSION['idMatiereExistante'])) {
                            if ($_SESSION['codeOperation'] == 1) {
                                // Modification d'une matière existante dans la BDD
                                $matiere = Matiere::first($_SESSION['idMatiereExistante']);
                                require_once M_CLASSES.DS.'annee_scolaire.php';
                                $anneeScolaireExistante = AnneeScolaire::first(['intitule', '=', $_POST['promotion']]);
                                if ($anneeScolaireExistante === null) {
                                    // Création d'une année scolaire dans la base si celle-ci n'existe pas
                                    $anneeScolaireExistante = new AnneeScolaire();
                                    $anneeScolaireExistante->intitule = $_POST['promotion'];
                                    $operationBDDMatiere = $anneeScolaireExistante->insert();
                                } else {
                                    $operationBDDMatiere = true;
                                }
                                $matiere->id_annee_scolaire = $anneeScolaireExistante->id;
                                $matiere->name_matiere = $_POST['nom'];
                                $matiere->description_matiere = $_POST['description'];
                                // On teste si la liste des étudiants a changé ou pas
                                $listeEtudiants = array();
                                foreach ($matiere->etudiants as $etudiant)
                                    $listeEtudiants[] = strval($etudiant->id);
                                if ($listeEtudiants != json_decode(base64_decode($_POST['listeEtudiants']))) {
                                    // On supprime tous les anciens étudiants et on ajoute les nouveaux à la place
                                    foreach ($matiere->etudiants as $etudiant)
                                        if ($operationBDDMatiere)
                                            $operationBDDMatiere = $matiere->removeEtudiant($etudiant);
                                    foreach (json_decode(base64_decode($_POST['listeEtudiants'])) as $idEtudiant)
                                        if ($operationBDDMatiere)
                                            $operationBDDMatiere = $matiere->addEtudiant(Etudiant::first(intval($idEtudiant)));
                                    // On permet le fail (celui-ci arriverait si on avait changé uniquement les étudiants et rien d'autre)
                                    if ($operationBDDMatiere)
                                        $matiere->update();
                                }
                                // On teste si la liste de profs a changé ou pas
                                $listeProfesseurs = array();
                                foreach ($matiere->professeurs as $professeur)
                                    $listeProfesseurs[] = strval($professeur->id);
                                if ($listeProfesseurs == json_decode(base64_decode($_POST['listeProfesseurs']))) {
                                    // Les profs n'ont pas changé alors on fait le update "standard" (permission fail - si on avait changé que les étudiants)
                                    if ($operationBDDMatiere)
                                        $matiere->update();
                                } else {
                                    // On supprime tous les anciens professeurs et on ajoute les nouveaux à la place
                                    foreach ($matiere->professeurs as $professeur)
                                        if ($operationBDDMatiere)
                                            $operationBDDMatiere = $matiere->removeProfesseur($professeur);
                                    foreach (json_decode(base64_decode($_POST['listeProfesseurs'])) as $idProfesseur)
                                        if ($operationBDDMatiere)
                                            $operationBDDMatiere = $matiere->addProfesseur(Professeur::first(intval($idProfesseur)));
                                    if ($_SESSION["user"]->role == "professeur" && !in_array($_SESSION["user"]->professeur->id, json_decode(base64_decode($_POST['listeProfesseurs']))) && $operationBDDMatiere)
                                        $operationBDDMatiere = $matiere->addProfesseur($_SESSION["user"]->professeur);
                                    // On permet le fail (celui-ci arriverait si on avait changé uniquement les profs et rien d'autre)
                                    if ($operationBDDMatiere)
                                        $matiere->update();
                                }
                            } else if ($_SESSION['codeOperation'] == 2) {
                                // Suppression du cursus de la BDD
                                $matiere = Matiere::first($_SESSION['idMatiereExistante']);
                                $operationBDDMatiere = true;
                                foreach ($matiere->etudiants as $etudiant)
                                    if ($operationBDDMatiere)
                                        $operationBDDMatiere = $matiere->removeEtudiant($etudiant);
                                foreach ($matiere->professeurs as $professeur)
                                    if ($operationBDDMatiere)
                                        $operationBDDMatiere = $matiere->removeProfesseur($professeur);
                                if ($operationBDDMatiere)
                                    $operationBDDMatiere = $matiere->delete();
                            } else if ($_SESSION['codeOperation'] == 4) {
                                // Création d'un nouveau cursus dans la BDD
                                $operationBDDMatiere = insererNouvelleMatiere();
                            }
                        } else
                            $operationBDDMatiere = insererNouvelleMatiere();
                        if ($operationBDDMatiere) {
                            // Je vide les variables qui ne sont plus nécessaires
                            unset($_SESSION['etudiants']);
                            unset($_SESSION['classes']);
                            unset($_SESSION['listeEtudiantsParClasse']);
                            unset($_SESSION['professeurs']);
                            unset($_SESSION['idMatiereExistante']);
                            unset($_SESSION['codeOperation']);
                            header('Location: /'.$_SESSION['user']->role.'/matieres');
                        } else {
                            $_POST['erreur'] = "Il n'a pas été possible de modifier les données dans la base de données !";
                            require_once VIEWS.DS.'editmatiere.php';
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
                    // Validation champ nom
                    if (empty($_POST['nom'])) {
                        $_POST['validationNom'] = 'is-invalid';
                        $validation = false;
                    }
                    if ($validation)
                        cloturerFormulaire();
                    else {
                        require_once VIEWS.DS.'editmatiere.php';
                        ob_flush();
                    }
                }
                // Chargement des données existantes depuis la BDD
                require_once M_CLASSES.DS.'etudiant.php';
                $etudiants = Etudiant::all();
                $_SESSION['etudiants'] = $etudiants;
                // Je charge uniquement des classes pour l'année scolaire choisie
                require_once M_CLASSES.DS.'annee_scolaire.php';
                $classes = AnneeScolaire::first(['intitule', '=', $_SESSION['anneeScolaire']])->classes;
                $_SESSION['classes'] = $classes;
                $listeEtudiantsParClasse = array();
                if ($classes !== null)
                    foreach ($classes as $classe) {
                        $idsEtudiants = array();
                        foreach ($classe->etudiants as $etudiant)
                            $idsEtudiants[] = $etudiant->id;
                        $listeEtudiantsParClasse[] = array(
                            'id' => $classe->id,
                            'idsEtudiants' => $idsEtudiants
                        );
                    }
                $_SESSION['listeEtudiantsParClasse'] = base64_encode(json_encode($listeEtudiantsParClasse));
                require_once M_CLASSES.DS.'professeur.php';
                $professeurs = Professeur::all();
                $_SESSION['professeurs'] = $professeurs;
                // Pré-remplissage de l'année scolaire
                $_POST['promotion'] = $_SESSION['anneeScolaire'];
                // Remplissage de valeur pour afficher dans le formulaire
                if (count($infos) > 0) {
                    // Si un identifiant à été passé
                    $_SESSION['idMatiereExistante'] = $infos[0];
                    $_SESSION['codeOperation'] = $infos[1];
                    if ($infos[1] == 1) {
                        $_POST['titrePage'] = "Modification";
                        $_POST['titreBouton'] = "Modifier matière/btn-warning";
                    } else if ($infos[1] == 2) {
                        $_POST['titrePage'] = "Suppression";
                        $_POST['titreBouton'] = "Supprimer matière/btn-danger";
                    } else if ($infos[1] == 3) {
                        $_POST['titrePage'] = "Affichage";
                    } else if ($infos[1] == 4) {
                        $_POST['titrePage'] = "Duplication";
                        $_POST['titreBouton'] = "Dupliquer cursus/btn-info";
                    }
                    require_once M_CLASSES.DS.'matiere.php';
                    $matiere = Matiere::first($infos[0]);
                    $_POST['nom'] = $matiere->name_matiere;
                    $_POST['description'] = $matiere->description_matiere;
                    $listeEtudiants = array();
                    foreach ($matiere->etudiants as $etudiant) {
                        $listeEtudiants[] = $etudiant->id;
                    }
                    $_POST['listeEtudiants'] = base64_encode(json_encode($listeEtudiants));
                    $listeProfesseurs = array();
                    foreach ($matiere->professeurs as $professeur) {
                        $listeProfesseurs[] = $professeur->id;
                    }
                    $_POST['listeProfesseurs'] = base64_encode(json_encode($listeProfesseurs));
                } else {
                    $_POST['titrePage'] = "Ajout";
                    $_POST['titreBouton'] = "Ajouter matière/btn-primary";
                    unset($_SESSION['idMatiereExistante']);
                    unset($_SESSION['codeOperation']);
                }
                require_once VIEWS.DS.'editmatiere.php';
            } else
                require_once VIEWS.DS.'erreur.php';
            ob_flush();
        }
    }
?>
