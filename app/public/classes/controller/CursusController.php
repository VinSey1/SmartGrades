<?php
    require_once CLASSES.DS.'Controller.php';
    class CursusController extends Controller {
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
                if (!empty($_SESSION['anneeScolaire'])) {
                    unset($_SESSION['cursusExistants']);
                    require_once M_CLASSES.DS.'annee_scolaire.php';
                    // Je charge uniquement des classes pour l'année scolaire choisie
                    $classes = AnneeScolaire::first(['intitule', '=', $_SESSION['anneeScolaire']])->classes;
                    $cursusExistants = $classes;
                    foreach ($classes as $cleclasse => $classe) {
                        // Ajout des informations sur le nombre d'étudiants inscrits
                        if (count($classe->etudiants) == 0)
                            $cursusExistants[$cleclasse]->nbreetudiants = 'Aucun étudiant n\'est encore assigné';
                        else
                            $cursusExistants[$cleclasse]->nbreetudiants = count($classe->etudiants);
                        // Ajout des professeurs responsables
                        if (count($classe->professeurs) == 0)
                            $cursusExistants[$cleclasse]->professeursresp = 'Pas encore de professeur assigné';
                        $cursusExistants[$cleclasse]->professeurresp = false;
                        foreach ($classe->professeurs as $cleprofesseur => $professeur) {
                            $cursusExistants[$cleclasse]->professeursresp .= $professeur->user->name.' '.$professeur->user->surname;
                            if ($cleprofesseur != count($classe->professeurs)-1)
                                $cursusExistants[$cleclasse]->professeursresp .= ', ';
                            // Vérification si le prof connecté est le responsable ou pas
                            if ($professeur == $_SESSION['user']->professeur)
                                $cursusExistants[$cleclasse]->professeurresp = true;
                        }
                    }
                    $_SESSION['cursusExistants'] = $cursusExistants;
                }
                // Pré-remplissage si une année a déjà été choisie auparavant
                if (!empty($_SESSION['anneeScolaire']))
                    $_POST['anneeScolaireExistante'] = $_SESSION['anneeScolaire'];
                require_once VIEWS.DS.'cursus.php';
            } else
                require_once VIEWS.DS.'erreur.php';
            ob_flush();
        }
    }
?>
