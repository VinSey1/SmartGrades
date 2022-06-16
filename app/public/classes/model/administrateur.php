<?php
    require_once CLASSES.DS.'model.php';
    class Administrateur extends Model {
        // Attributs
        static protected $nomTable = "administrateur";
        static protected $clePrimaire = "id";

        // Constructeur
        function __construct($attributs = ["id_user",
        "created_at",
        "updated_at"]) {
            parent::__construct($attributs);
        }
        
        
        function user() {
            return $this->belongs_to("user", "id_user");
        }


        function __get($nomAttribut) {
            if ($nomAttribut === "user")
                return $this->user();
            else
                return parent::__get($nomAttribut);
        }
    }
?>
