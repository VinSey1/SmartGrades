<?php
    require_once CLASSES.DS.'model.php';
    class ClasseHasProfesseur extends Model{
        // Attributs
        static protected $nomTable = "classe_has_professeur";
        static protected $clePrimaire = null;
  
        // Constructeur
        function __construct($attributs = ["id_classe","id_professeur","created_at","updated_at"]) {
            parent::__construct($attributs);
        }
  
        function __get($nomAttribut) {
            return parent::__get($nomAttribut);
        }

        function delete() {
            $query = Query::table(static::$nomTable);
            $query->where("id_classe", "=", $this->id_classe)->where("id_professeur", "=", $this->id_professeur);
            return $query->delete() > 0;
        }
    }
?>