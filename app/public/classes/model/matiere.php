<?php
    require_once CLASSES.DS.'model.php';
    class Matiere extends Model {
        // Attributs
        static protected $nomTable = "matiere";
        static protected $clePrimaire = "id";

        // Constructeur
        function __construct($attributs =  ["name_matiere",
        "description_matiere",
        "id_annee_scolaire",
        "created_at",
        "updated_at"
        ]) {
            parent::__construct($attributs);
        }
        
        function professeurs() {
            return $this->belongs_to_many("professeur", "matiere_has_professeur", "id_matiere", "id_professeur");
        }

        function anneeScolaire() {
            return $this->belongs_to("annee_scolaire", "id_annee_scolaire");
        }

        function addProfesseur($professeur) {
            require_once("matiere_has_professeur.php");
            $lienMatiereProfesseur = new MatiereHasProfesseur();
            $lienMatiereProfesseur->id_matiere = $this->id;
            $lienMatiereProfesseur->id_professeur = $professeur->id;
            $insertionLien = $lienMatiereProfesseur->insert();
            return $insertionLien;
        }

        function removeProfesseur($professeur) {
            require_once("matiere_has_professeur.php");
            $lienMatiereProfesseur = MatiereHasProfesseur::first([["id_matiere", "=", $this->id], ["id_professeur", "=", $professeur->id]]);
            $suppressionLien = $lienMatiereProfesseur->delete();
            return $suppressionLien;
        }

        function etudiants(){
            return $this->belongs_to_many("etudiant", "etudiant_has_matiere", "id_matiere", "id_etudiant");
        }

        function addEtudiant($etudiant) {
            require_once("etudiant_has_matiere.php");
            $lienEtudiantMatiere = new EtudiantHasMatiere();
            $lienEtudiantMatiere->id_etudiant = $etudiant->id;
            $lienEtudiantMatiere->id_matiere = $this->id;
            $insertionLien = $lienEtudiantMatiere->insert();
            return $insertionLien;
        }

        function removeEtudiant($etudiant) {
            require_once("etudiant_has_matiere.php");
            $lienEtudiantMatiere = EtudiantHasMatiere::first([["id_etudiant", "=", $etudiant->id], ["id_matiere", "=", $this->id]]);
            $suppressionLien = $lienEtudiantMatiere->delete();
            return $suppressionLien;
        }

        function examens(){
            return $this->belongs_to_many("examen", "examen_has_matiere", "id_matiere", "id_examen");
        }

        function __get($nomAttribut) {
            if ($nomAttribut === "professeurs")
                return $this->professeurs();
            
            else if($nomAttribut === "etudiants")
                return $this->etudiants();

            else if($nomAttribut === "examens")
                return $this->examens();
            else if($nomAttribut === "anneeScolaire")
                return $this->anneeScolaire();
            else
                return parent::__get($nomAttribut);
        }
    }
?>
