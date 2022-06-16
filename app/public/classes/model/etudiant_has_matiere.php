<?php 
    require_once CLASSES.DS.'model.php';
    class EtudiantHasMatiere extends Model{
        // Attributs
        static protected $nomTable = "etudiant_has_matiere";
        static protected $clePrimaire = null;
  
        // Constructeur
        function __construct($attributs = ["id_etudiant","id_matiere","created_at","updated_at"]) {
            parent::__construct($attributs);
        }
  
        function __get($nomAttribut) {
            return parent::__get($nomAttribut);
        }

        function delete() {
            $query = Query::table(static::$nomTable);
            $query->where("id_etudiant", "=", $this->id_etudiant)->where("id_matiere", "=", $this->id_matiere);
            return $query->delete() > 0;
        }
    }

?>