<?php
    require_once CLASSES.DS.'model.php';
    class User extends Model {
        // Attributs
        static protected $nomTable = "user";
        static protected $clePrimaire = "id";

        // Constructeur
        function __construct($attributs = ["email",
        "password",
        "role",
        "name",
        "surname",
        "date_naissance",
        "created_at",
        "updated_at"]) {
            parent::__construct($attributs);
        }
        
        function etudiant() {
            return $this->has_many("etudiant", "id_user")[0];
        }

        function administrateur(){
            return $this->has_many("administrateur", "id_user")[0];
        }

        function professeur(){
            return $this->has_many("professeur", "id_user")[0];
        }


        function __get($nomAttribut) {
            if ($nomAttribut === "etudiant")
                return $this->etudiant();
            else if ($nomAttribut === "professeur")
                return $this->professeur();
            else if ($nomAttribut === "administrateur")
                return $this->administrateur();
            else
                return parent::__get($nomAttribut);
        }
    }
?>
