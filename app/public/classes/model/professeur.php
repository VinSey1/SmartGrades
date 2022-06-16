<?php
    require_once CLASSES.DS.'model.php';
    require_once M_CLASSES . DS . 'examen_has_professeur.php';
    require_once M_CLASSES . DS . 'classe_has_professeur.php';
    require_once M_CLASSES . DS . 'matiere_has_professeur.php';
    class Professeur extends Model {
        // Attributs
        static protected $nomTable = "professeur";
        static protected $clePrimaire = "id";

        // Constructeur
        function __construct($attributs = [
            "numero_professeur",
            "id_gitlab",
            "id_user",
            "created_at",
            "updated_at"
        ]) {
            parent::__construct($attributs);
        }

        function user() {
            return $this->belongs_to("user", "id_user");
        }

        function matieres() {
            return $this->belongs_to_many("matiere", "matiere_has_professeur", "id_professeur", "id_matiere");
        }

        function classes() {
            return $this->belongs_to_many("classe", "classe_has_professeur", "id_professeur", "id_classe");
        }

        function examens() {
            return $this->belongs_to_many("examen", "examen_has_professeur", "id_professeur", "id_examen");
        }

        function __get($nomAttribut) {
            if ($nomAttribut === "user")
                return $this->user();

            else if ($nomAttribut === "matieres")
                return $this->matieres();

            else if ($nomAttribut === "classes")
                return $this->classes();

            else if ($nomAttribut === "examens")
                return $this->examens();

            else
                return parent::__get($nomAttribut);
        }

        function getListStudentMatiere($matiere) {
            require_once("matiere.php");
            return $matiere->etudiants();
        }

        function delete() {
            $lignesASupprimer = ExamenHasProfesseur::find(["id_professeur", "=", $this->id]);
            foreach ($lignesASupprimer as $ligneASupprimer) {
                $ligneASupprimer->delete();
            }

            $lignesASupprimer = ClasseHasProfesseur::find(["id_professeur", "=", $this->id]);
            foreach ($lignesASupprimer as $ligneASupprimer) {
                $ligneASupprimer->delete();
            }

            $lignesASupprimer = MatiereHasProfesseur::find(["id_professeur", "=", $this->id]);
            foreach ($lignesASupprimer as $ligneASupprimer) {
                $ligneASupprimer->delete();
            }
    
            parent::delete();
        }

        function addClasse($classe) {
            $lienClasseProfesseur = new ClasseHasProfesseur();
            $lienClasseProfesseur-> id_professeur = $this->id;
            $lienClasseProfesseur-> id_classe = $classe->id;
            $insertionLien = $lienClasseProfesseur->insert();
            return $insertionLien;
        }

        function removeClasse($classe) {
            $lienClasseProfesseur = ClasseHasProfesseur::first([["id_professeur", "=", $this->id], ["id_classe", "=", $classe->id]]);
            $suppressionLien = $lienClasseProfesseur->delete();
            return $suppressionLien;
        }

        function addMatiere($matiere) {
            $lienMatiereProfesseur = new MatiereHasProfesseur();
            $lienMatiereProfesseur-> id_professeur = $this->id;
            $lienMatiereProfesseur-> id_matiere = $matiere->id;
            $insertionLien = $lienMatiereProfesseur->insert();
            return $insertionLien;
        }

        function removeMatiere($matiere) {
            $lienMatiereProfesseur = MatiereHasProfesseur::first([["id_professeur", "=", $this->id], ["id_matiere", "=", $matiere->id]]);
            $suppressionLien = $lienMatiereProfesseur->delete();
            return $suppressionLien;
        }
    }
