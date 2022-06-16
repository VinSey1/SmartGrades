<?php 
    require_once CLASSES.DS.'model.php';
    class QuestionHasExamen extends Model{
        // Attributs
        static protected $nomTable = "question_has_examen";
        static protected $clePrimaire = null;
  
        // Constructeur
        function __construct($attributs = ["id_question","id_examen","created_at","updated_at"]) {
            parent::__construct($attributs);
        }
  
        function __get($nomAttribut) {
            return parent::__get($nomAttribut);
        }

        function delete() {
            $query = Query::table(static::$nomTable);
            $query->where("id_question", "=", $this->id_question)->where("id_examen", "=", $this->id_examen);
            return $query->delete() > 0;
        }
    }

?>