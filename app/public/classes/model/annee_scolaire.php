<?php 
    require_once CLASSES.DS.'model.php';
    class AnneeScolaire extends Model{
        // Attributs
        static protected $nomTable = "annee_scolaire";
        static protected $clePrimaire = "id";

        // Constructeur
        function __construct($attributs = ["intitule","created_at","updated_at"]) {
            parent::__construct($attributs);
        }

        function matieres(){
            return $this->has_many("matiere", "id_annee_scolaire");
        }

        function classes(){
            return $this->has_many("classe", "id_annee_scolaire");
        }

        function __get($nomAttribut) {
            if($nomAttribut === "matieres"){
                return $this->matieres();
            }else if($nomAttribut === "classes"){
                return $this->classes();
            }else{
                return parent::__get($nomAttribut);
            }
        }
    }

?>