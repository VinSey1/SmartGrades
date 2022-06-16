<?php
    require_once CLASSES.DS.'model.php';
    class EtudiantHasExamen extends Model{
        // Attributs
        static protected $nomTable = "etudiant_has_examen";
        static protected $clePrimaire = null;
   
        // Constructeur
        function __construct($attributs = ["id_etudiant", "id_examen", "note", "created_at", "updated_at"]) {
            parent::__construct($attributs);
        }
   
        function __get($nomAttribut) {
            return parent::__get($nomAttribut);
        }

        function delete() {
            $query = Query::table(static::$nomTable);
            $query->where("id_etudiant", "=", $this->id_etudiant)->where("id_examen", "=", $this->id_examen);
            return $query->delete() > 0;
        }
        
        function update() {
            $query = Query::table(static::$nomTable);
            $query->where("id_etudiant", "=", $this->id_etudiant)->where("id_examen", "=", $this->id_examen);
            $valeursAModifier = [];
            foreach ($this->attributs as $cleAttribut => $attribut)
                $valeursAModifier[$cleAttribut] = $attribut;
            return $query->update($valeursAModifier) > 0;
        }
    }
?>