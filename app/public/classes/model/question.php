<?php
    require_once CLASSES.DS.'model.php';

    class Question extends Model {
        static protected $nomTable = "question";
        static protected $clePrimaire = "id";
 
        // Constructeur
        function __construct($attributs = ["contenu",
        "commentaire",
        "points",
        "created_at",
        "updated_at"]) {
            parent::__construct($attributs);
        }

        function examens(){
            return $this->belongs_to_many("examen", "question_has_examen", "id_question", "id_examen");
        }

        
        function __get($nomAttribut) {
            if($nomAttribut === "examens"){
                return $this->examens();
            }else{
                return parent::__get($nomAttribut);
            }
            
        }
 
    }
?>