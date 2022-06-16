<?php
    require_once CLASSES.DS.'model.php';
    class ExamenHasProfesseur extends Model{
        // Attributs
        static protected $nomTable = "examen_has_professeur";
        static protected $clePrimaire = null;
   
        // Constructeur
        function __construct($attributs = ["id_examen", "id_professeur", "created_at", "updated_at"]) {
            parent::__construct($attributs);
        }
   
        function __get($nomAttribut) {
            return parent::__get($nomAttribut);
        }

        function delete() {
            $query = Query::table(static::$nomTable);
            $query->where("id_examen", "=", $this->id_examen)->where("id_professeur", "=", $this->id_professeur);
            return $query->delete() > 0;
        }
    }
?>