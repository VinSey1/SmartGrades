<?php
    require_once CLASSES.DS.'model.php';
    require_once M_CLASSES . DS . 'classe_has_professeur.php';
    class Classe extends Model {
        // Attributs
        static protected $nomTable = "classe";
        static protected $clePrimaire = "id";

        // Constructeur
        function __construct($attributs = ["intitule",
        "id_annee_scolaire",
        "promotion",
        "created_at",
        "updated_at"
        ]) {
            parent::__construct($attributs);
        }

        function professeurs() {
            return $this->belongs_to_many("professeur", "classe_has_professeur", "id_classe", "id_professeur");
        }

        function anneeScolaire() {
            return $this->belongs_to("annee_scolaire", "id_annee_scolaire");
        }

        function addProfesseur($professeur) {
            $lienClasseProfesseur = new ClasseHasProfesseur();
            $lienClasseProfesseur->id_classe = $this->id;
            $lienClasseProfesseur->id_professeur = $professeur->id;
            $insertionLien = $lienClasseProfesseur->insert();
            return $insertionLien;
        }

        function removeProfesseur($professeur) {
            $lienClasseProfesseur = ClasseHasProfesseur::first([["id_classe", "=", $this->id], ["id_professeur", "=", $professeur->id]]);
            $suppressionLien = $lienClasseProfesseur->delete();
            return $suppressionLien;
        }

        function etudiants(){
            return $this->has_many("etudiant", "id_classe");
        }

        function __get($nomAttribut) {
            if ($nomAttribut === "professeurs")
                return $this->professeurs();
            else if ($nomAttribut === "etudiants")
                return $this->etudiants();
            else if($nomAttribut === "anneeScolaire")
                return $this->anneeScolaire();
            else
                return parent::__get($nomAttribut);
        }
    }
?>
