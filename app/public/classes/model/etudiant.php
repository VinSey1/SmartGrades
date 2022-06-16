<?php
require_once CLASSES . DS . 'model.php';
require_once M_CLASSES . DS . 'etudiant_has_examen.php';
require_once M_CLASSES . DS . 'etudiant_has_matiere.php';
class Etudiant extends Model {
    // Attributs
    static protected $nomTable = "etudiant";
    static protected $clePrimaire = "id";

    // Constructeur
    function __construct($attributs = [
        "numero_etudiant", "id_gitlab", "tier_temps", "cursus_postbac", "statut",
        "id_user", "id_classe", "created_at", "updated_at"
    ]) {
        parent::__construct($attributs);
    }
    
    function user() {
        return $this->belongs_to("user", "id_user");
    }

    function classe() {
        return $this->belongs_to("classe", "id_classe");
    }

    function matieres() {
        return $this->belongs_to_many("matiere", "etudiant_has_matiere", "id_etudiant", "id_matiere");
    }

    function examens() {
        return $this->belongs_to_many("examen", "etudiant_has_examen", "id_etudiant", "id_examen");
    }
 
    /**
     * note function
     * 
     * Returns a note from an Examen Object
     *  if there is no note it returns null
     *  if it's equal to minus -1 so the exam has not been graded yet or hasn't happened yet
     * @param [Examen] $examen
     * @return int
     */
    function note($examen){
        require_once("etudiant_has_examen.php");

        if(is_null($examen))
            return null;
        
        $lienEtudiantExamen = EtudiantHasExamen::first([
            ["id_etudiant", "=", $this->id], ["id_examen", "=", $examen->id]
        ], ["note"]);

        if(is_null($lienEtudiantExamen)){
            return "Non renseignée";
        }

        if($lienEtudiantExamen->note >= 0) {
            return $lienEtudiantExamen->note;
        } else if($lienEtudiantExamen->note == -1) {
            return "Non renseignée";
        }
        return "Absent";
    }

    function addNote($examen, $note) {
        require_once("etudiant_has_examen.php");

        if(is_null($examen) || is_null($note))
            return null;
        
        $lienEtudiantExamen = EtudiantHasExamen::first([
            ["id_etudiant", "=", $this->id],
            ["id_examen", "=", $examen->id]
        ]);

        $lienEtudiantExamen->note = doubleval($note);

        $lienEtudiantExamen->update();
    }

    function deleteNote($examen) {
        require_once("etudiant_has_examen.php");

        if(is_null($examen))
            return null;
        
        $lienEtudiantExamen = EtudiantHasExamen::first([
            ["id_etudiant", "=", $this->id], ["id_examen", "=", $examen->id]
        ]);
        
        $lienEtudiantExamen->note = -1;
        $lienEtudiantExamen->update();
    }

    function hasTierTemps(){
        return $this->tier_temps == 1;
    }

    function addExamen($examen) {
        require_once("etudiant_has_examen.php");

        if(is_null($examen)) {
            return null;
        }

        $lienEtudiantExamen = new EtudiantHasExamen();
        $lienEtudiantExamen->id_etudiant = $this->id;
        $lienEtudiantExamen->id_examen = $examen->id;
        $insertionLien = $lienEtudiantExamen->insert();
    }

    function deleteExamen($examen) {
        require_once("etudiant_has_examen.php");

        if(is_null($examen)) {
            return null;
        }

        $lienEtudiantExamen = EtudiantHasExamen::first([
            ["id_etudiant", "=", $this->id],
            ["id_examen", "=", $examen->id]
        ]);
        if($lienEtudiantExamen != null) $lienEtudiantExamen->delete();
    }

    function __get($nomAttribut) {
        if ($nomAttribut === "user")
            return $this->user();
        
        else if ($nomAttribut === "classe")
            return $this->classe();
        
        else if ($nomAttribut === "matieres")
            return $this->matieres();

        else if ($nomAttribut === "examens")
            return $this->examens();

        else
            return parent::__get($nomAttribut);
    }

    function delete() {
        $lignesASupprimer = EtudiantHasExamen::find(["id_etudiant", "=", $this->id]);
        foreach ($lignesASupprimer as $ligneASupprimer) {
            $ligneASupprimer->delete();
        }

        $lignesASupprimer = EtudiantHasMatiere::find(["id_etudiant", "=", $this->id]);
        foreach ($lignesASupprimer as $ligneASupprimer) {
            $ligneASupprimer->delete();
        }

        parent::delete();
    }

    function addMatiere($matiere) {
        $lienEtudiantMatiere = new EtudiantHasMatiere();
        $lienEtudiantMatiere-> id_etudiant = $this->id;
        $lienEtudiantMatiere-> id_matiere = $matiere->id;
        $insertionLien = $lienEtudiantMatiere->insert();
        return $insertionLien;
    }

    function removeMatiere($matiere) {
        $lienEtudiantMatiere = EtudiantHasMatiere::first([["id_etudiant", "=", $this->id], ["id_matiere", "=", $matiere->id]]);
        $suppressionLien = $lienEtudiantMatiere->delete();
        return $suppressionLien;
    }
}
