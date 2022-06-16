<?php
    require_once CLASSES.DS.'model.php';
    class MatiereHasProfesseur extends Model {
        // Attributs
        static protected $nomTable = "matiere_has_professeur";
        static protected $clePrimaire = NULL; //Convention for PK of pivot table 
        // Constructeur
        function __construct($attributs = ["id_matiere", "id_professeur", "created_at", "updated_at"]) {
            parent::__construct($attributs);
        }
        function __get($nomAttribut) {
            return parent::__get($nomAttribut);
        }
        function delete() {
            $query = Query::table(static::$nomTable);
            $query->where("id_matiere", "=", $this->id_matiere)->where("id_professeur", "=", $this->id_professeur);
            return $query->delete() > 0;
        }
    }
?>