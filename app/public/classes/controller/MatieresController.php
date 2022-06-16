<?php
    require_once CLASSES.DS.'Controller.php';
    class MatieresController extends Controller {
        function showContent($infos) {
            if (empty($_SESSION)) session_start();
            if (!empty($_SESSION["user"]) && ($_SESSION["user"]->role == "professeur" || $_SESSION["user"]->role == "administrateur")) {
                // Soumission du formulaire
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Validation de l'année scolaire choisie
                    if (preg_match('/^[0-9]{4}-[0-9]{4}$/', $_POST['anneeScolaireExistante'])) {
                        $anneesChoisies = explode('-', $_POST['anneeScolaireExistante']);
                        if (intval($anneesChoisies[1]) - intval($anneesChoisies[0]) == 1)
                            $_SESSION['anneeScolaire'] = $_POST['anneeScolaireExistante'];
                    }
                }
                // Chargement des données existantes depuis la BDD
                unset($_SESSION['anneesExistantes']);
                require_once M_CLASSES.DS.'annee_scolaire.php';
                $annees = AnneeScolaire::all(["intitule"]);
                $anneesExistantes = array();
                foreach ($annees as $annee)
                    if (!in_array($annee->intitule, $anneesExistantes, true))
                        array_push($anneesExistantes, $annee->intitule);
                if (!empty($_SESSION['anneeScolaire']) && !in_array($_SESSION['anneeScolaire'], $anneesExistantes, true))
                    array_push($anneesExistantes, $_SESSION['anneeScolaire']);
                $_SESSION['anneesExistantes'] = $anneesExistantes;
                unset($_SESSION['matieresExistantes']);
                require_once M_CLASSES.DS.'matiere.php';
                // Je charge uniquement des matières pour le professeur connecté
                if ($_SESSION["user"]->role == "professeur")
                    $matieres = $_SESSION["user"]->professeur->matieres;
                else
                    $matieres = Matiere::all();
                // Je garde uniquement les matières pour l'année scolaire choisie
                require_once M_CLASSES.DS.'annee_scolaire.php';
                $idanneescolairechoisie = AnneeScolaire::first(['intitule', '=', $_SESSION['anneeScolaire']])->id;
                foreach ($matieres as $clematiere => $matiere)
                    if ($matiere->id_annee_scolaire !== $idanneescolairechoisie)
                        unset($matieres[$clematiere]);
                // Je remplis les informations supplémentaires
                $matieresExistantes = $matieres;
                foreach ($matieres as $clematiere => $matiere) {
                    if (count($matiere->etudiants) == 0)
                        $matieresExistantes[$clematiere]->nbreetudiants = 'Aucun étudiant n\'est encore assigné';
                    else
                        $matieresExistantes[$clematiere]->nbreetudiants = count($matiere->etudiants);
                    if (count($matiere->examens) == 0)
                        $matieresExistantes[$clematiere]->nbreexamens = 'Il n\'y a pas encore eu d\'examen !';
                    else
                        $matieresExistantes[$clematiere]->nbreexamens = count($matiere->examens);
                    // Ajout des professeurs responsables
                    if (count($matiere->professeurs) == 0)
                        $matieresExistantes[$clematiere]->professeursenseignants = 'Pas encore de professeur assigné';
                    foreach ($matiere->professeurs as $cleprofesseur => $professeur) {
                        $matieresExistantes[$clematiere]->professeursenseignants .= $professeur->user->name.' '.$professeur->user->surname;
                        if ($cleprofesseur != count($matiere->professeurs)-1)
                            $matieresExistantes[$clematiere]->professeursenseignants .= ', ';
                    }
                }
                $_SESSION['matieresExistantes'] = $matieresExistantes;
                // Pré-remplissage si une année a déjà été choisie auparavant
                if (!empty($_SESSION['anneeScolaire']))
                    $_POST['anneeScolaireExistante'] = $_SESSION['anneeScolaire'];
                require_once VIEWS.DS.'matieres.php';
            } else
                require_once VIEWS.DS.'erreur.php';
            ob_flush();
        }
    }
