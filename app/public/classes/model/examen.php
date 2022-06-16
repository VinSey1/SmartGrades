<?php
    require_once CLASSES.DS.'model.php';
    class Examen extends Model{
        // Attributs
        static protected $nomTable = "examen";
        static protected $clePrimaire = "id";
 
        // Constructeur
        function __construct($attributs = ["intitule", "date_examen", "type", "created_at", "updated_at", "examen_publie"]) {
            parent::__construct($attributs);
        }

        function etudiants(){
            return $this->belongs_to_many("etudiant", "etudiant_has_examen", "id_examen", "id_etudiant");
        }

        function matieres(){
            return $this->belongs_to_many("matiere", "examen_has_matiere", "id_examen", "id_matiere");
        }

        function professeurs(){
            return $this->belongs_to_many("professeur", "examen_has_professeur", "id_examen", "id_professeur");
        }

        function questions(){
            return $this->belongs_to_many("question", "question_has_examen", "id_examen", "id_question");
        }

        function addMatiere($matiere) {
            require_once("matiere.php");
            require_once("examen_has_matiere.php");

            if(is_null($matiere)) {
                return null;
            }

            foreach($matiere->etudiants as $etudiant) {
                $etudiant->addExamen($this);
            }

            $lienExamenMatiere = new ExamenHasMatiere();
            $lienExamenMatiere->id_examen = $this->id;
            $lienExamenMatiere->id_matiere = $matiere->id;
            $lienExamenMatiere->insert();
        }

        function deleteMatiere($matiere) {
            require_once("matiere.php");
            require_once("examen_has_matiere.php");

            if(is_null($matiere)) {
                return null;
            }

            foreach($matiere->etudiants as $etudiant) {
                $etudiant->deleteExamen($this);
            }

            $lienExamenMatiere = ExamenHasMatiere::first([
                ["id_examen", "=", $this->id],
                ["id_matiere", "=", $matiere->id]
            ]);
            
            if($lienExamenMatiere != null) $lienExamenMatiere->delete();
        }

        function addProfesseur($professeur) {
            require_once("professeur.php");
            require_once("examen_has_professeur.php");

            if(is_null($professeur)) {
                return null;
            }

            $lienExamenProfesseur = new ExamenHasProfesseur();
            $lienExamenProfesseur->id_examen = $this->id;
            $lienExamenProfesseur->id_professeur = $professeur->id;
            $lienExamenProfesseur->insert();
        }

        function deleteProfesseur($professeur) {
            require_once("professeur.php");
            require_once("examen_has_professeur.php");

            if(is_null($professeur)) {
                return null;
            }

            $lienExamenProfesseur = ExamenHasProfesseur::first([
                ["id_examen", "=", $this->id],
                ["id_professeur", "=", $professeur->id]
            ]);
            
            if($lienExamenProfesseur != null) $lienExamenProfesseur->delete();

            parent::delete();
        }

        function addQuestion($question) {
            require_once("question.php");
            require_once("question_has_examen.php");

            if(is_null($question)) {
                return null;
            }

            $lienExamenQuestion = new QuestionHasExamen();
            $lienExamenQuestion->id_examen = $this->id;
            $lienExamenQuestion->id_question = $question->id;
            $lienExamenQuestion->insert();
        }

        function deleteQuestion($question) {
            require_once("question.php");
            require_once("question_has_examen.php");

            if(is_null($question)) {
                return null;
            }

            $lienExamenQuestion = QuestionHasExamen::first([
                ["id_examen", "=", $this->id],
                ["id_question", "=", $question->id]
            ]);
            
            if($lienExamenQuestion != null) $lienExamenQuestion->delete();
            $question->delete();
        }

        function initialiseExamen($professeur, $questions, $matieres) {
            require_once("question.php");

            foreach($matieres as $matiere) {
                $this->addMatiere($matiere);
            }

            foreach($questions as $question) {
                $question->insert();
                $this->addQuestion($question);
            }

            $this->addProfesseur($professeur);
        }

        function delete() {
            foreach($this->matieres as $matiere) {
                $this->deleteMatiere($matiere);
            }

            foreach($this->questions as $question) {
                $this->deleteQuestion($question);
            }

            $this->deleteProfesseur($this->professeurs[0]);

        }

        function moyenne() {
            $total = 0;
            $nbEtudiants = 0;
            foreach($this->etudiants as $etudiant) {
                if(is_numeric($etudiant->note($this))) {
                    $total += $etudiant->note($this);
                    $nbEtudiants++;
                }
            }
            if($total == 0) return "?";
            return $total / $nbEtudiants;
        }
 
        function isPublie(){
            return $this->examen_publie == 1;
        }

        function __get($nomAttribut) {
            if($nomAttribut === "etudiants")
                return $this->etudiants();
            
            else if($nomAttribut === "matieres")
                return $this->matieres();

            else if($nomAttribut === "professeurs")
                return $this->professeurs();
            
            else if($nomAttribut === "questions")
                return $this->questions();    

            else if($nomAttribut === "moyenne")
                return $this->moyenne();  

            else
                return parent::__get($nomAttribut);
        }
    }
?>
