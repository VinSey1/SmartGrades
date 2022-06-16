<?php
require_once 'defines.php';
require_once M_CLASSES . DS . 'administrateur.php';
require_once M_CLASSES . DS . 'professeur.php';
require_once M_CLASSES . DS . 'matiere.php';
require_once M_CLASSES . DS . 'etudiant.php';
require_once M_CLASSES . DS . 'classe.php';
require_once M_CLASSES . DS . 'user.php';
require_once ORM . DS . 'Mailer.php';
require_once ORM . DS . 'ConnectionFactory.php';
class API {

    private static $validParamTierTemps = ["oui","non"];
    private static $validParamsStatut = ["initial", "alternance", "non-assidu"];
    private static $string;

    static function connection() {
        try {
            // On se connecte à MySQL
            $mysqlClient = new PDO('mysql:host=mysql;dbname=smartgrades;charset=utf8mb4', 'smartgrades', 'smartgrades');
        } catch (Exception $e) {
            // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : ' . $e->getMessage());
        }
        // Si tout va bien, on peut continuer
        return $mysqlClient;
    }

    static function getAuthentification_mailPwd_query($input_email, $input_pwd) {
        $usr = User::first([["email", "=", $input_email]], []);
        if (!is_null($usr)) {
            return password_verify($input_pwd, $usr->password);
        }
        return false;
    }

    static function getListMatieres_idProf_query($idProf) {
        $matieres = Professeur::first(["numero_professeur", "=", $idProf], [])->matieres;
        return $matieres;
    }

    static function getListMatieres_prof_query($prof) {
        return $prof->matieres;
    }

    static function getListEtudiants_idProfIdMatiere_query($idProf, $idMatiere) {
        $professeur = Professeur::first(["numero_professeur", "=", $idProf], []);
        $matiere = Matiere::first(["id", "=", $idMatiere], []);

        $targetIndex = -1;
        foreach ($professeur->matieres as $indexLocal => $matiereProf) {
            if ($matiereProf->id == $matiere->id) {
                $targetIndex = $indexLocal;
                break;
            }
        }

        $targetMatiere = $professeur->matieres[$targetIndex];

        $students = $professeur->getListStudentMatiere($targetMatiere);
        return $students;
    }

    static function getEtudiant_numeroEtudiant_query($numero_etudiant) {
        $etudiant = Etudiant::first(["numero_etudiant", "=", $numero_etudiant], []);
        return $etudiant;
    }

    static function insertStudentAndUser(array $paramsStudent, array $paramsUser, bool $isCsv) : int{
        $message = self::checkParamsStudent($paramsStudent);
        
        if ($message !== ""){
            $_SESSION["error"] = $message;
            return 0;
        }
        
        try{
            $idUser = self::insertUser($paramsUser, "etudiant");
            if($idUser == 0){
                $_SESSION["error"] = "Erreur niveau User vérifier si les valeurs sont les conformes(Role) ou uniques(Email)</br>";
                return 0;
            }

            $idStudent = self::insertStudent($paramsStudent, $idUser);

            if($idStudent == 0){
                $_SESSION["error"] = "Erreur niveau etudiant vérifier si les valeurs sont conformes(tier_temps, statut), 
                                    uniques(numero_etudiant,id_gitlab) ou si la classe existe bien(classe, référence à intitulé de la classe)</br>";                   
                return 0;
            }

            
            return $idStudent;

        }catch(PDOException $e){
            
            if(strpos($e->getMessage(), 'Duplicate entry')){
                if($idUser === NULL){

                    $_SESSION["error"] = "Erreur niveau User vérifier si les valeurs sont les conformes(Role) ou uniques(Email)</br>";

                }else if($idStudent === NULL){

                    $userToDelete = User::find([["id", "=", $idUser]])[0];
                    $userToDelete->delete();

                    $_SESSION["error"] = "Erreur niveau etudiant vérifier si les valeurs sont conformes(tier_temps, statut), 
                                    uniques(numero_etudiant,id_gitlab) ou si la classe existe bien(classe, référence à intitulé de la classe)</br>";
                }
            }
        }
       
       return 0;
    }

    public static function insertProfessorAndUser(array $paramsProfessor, array $paramsUser, bool $isCsv) : int{
        $message = self::checkParamsProf($paramsProfessor);
        
        if ($message !== ""){
            $_SESSION["error"] = $message;
            return 0;
        }
        try{
            $idUser = self::insertUser($paramsUser, "professeur");
            if($idUser == 0){
                $_SESSION["error"] = "Erreur niveau User vérifier si les valeurs sont les conformes(Role) ou uniques(Email)</br>";
                return 0;
            }
            $idProfessor = self::insertProfessor($paramsProfessor, $idUser);
            if($idProfessor == 0){
                $_SESSION["error"] = "Erreur niveau professeur vérifier si les valeurs sont conformes(numero_professeur, id_gitlab), uniques(numero_professeur,id_gitlab)</br>";                   
                return 0;
            }

            return $idProfessor;

        }catch(PDOException $e){
            if(strpos($e->getMessage(), 'Duplicate entry')){
                if($idUser === NULL){

                    $_SESSION["error"] = "Erreur niveau User vérifier si les valeurs sont les conformes(Role) ou uniques(Email)</br>";
                  
                }else if($idProfessor === NULL){

                    $userToDelete = User::find([["id", "=", $idUser]])[0];
                    $userToDelete->delete();

                    $_SESSION["error"] = "Erreur niveau professeur vérifier si les valeurs sont conformes(numero_professeur, id_gitlab), 
                    uniques(numero_professeur,id_gitlab)</br>";
                }
            }
        }
        return 0;
    }

    private static function insertUser(array $array, string $role){
        $user = new User();
        $user->email = $array['email'];
        $user->password = password_hash(self::getRandomString(), PASSWORD_BCRYPT);
        $user->role = $role;
        $user->name = $array[array_keys($array)[0]]; //$array["nom"]
        $user->surname = $array['prenom'];
        $user->date_naissance = $array['date_naissance']; 
       
        $insertionUser = $user->insert();
        
        return $insertionUser;
    }

    private static function insertStudent(array $array, int $idUser){
        $student = new Etudiant();
        
        $student->numero_etudiant = $array["numero_etudiant"];
        $student->id_gitlab = $array["id_gitlab"] === "" ? null : $array["id_gitlab"];
        $student->tier_temps = strtolower($array["tiers_temps"]) === "non" ? 0 : 1;
        $student->cursus_postbac = $array["cursus_postbac"];
        $student->statut = ucfirst(strtolower($array["statut"]));
        $student->id_user = $idUser;
        $student->id_classe = $array['id_classe'];

        $idStudent = $student->insert();

        if($idStudent > 0){
            $user = User::find(["id","=",$student->id_user])[0];
            Mailer::sendEmail(self::$string, $user->email, null, $user->name, $user->surname, Mailer::$CODE_MAIL_PASSWORD);
        }

        return $idStudent;
    }

    private static function insertProfessor(array $array, int $idUser){
        $professor = new Professeur();

        $professor->id_user = $idUser;
        $professor->id_gitlab = $array["id_gitlab"] === "" ? null : $array["id_gitlab"];
        $professor->numero_professeur = $array["numero_professeur"];

        $idProfessor = $professor->insert();
        if($idProfessor > 0){
            $user = User::find(["id","=",$professor->id_user])[0];
            Mailer::sendEmail(self::$string, $user->email, null, $user->name, $user->surname, Mailer::$CODE_MAIL_PASSWORD);
        }
         
        return $idProfessor;
    }
    
    static function insertAdministrateurAndUser($array): bool {
        $idUser = self::insertUser($array, "administrateur");

        $admin = new Administrateur();
        $admin->id_user = $idUser;
        $resultat2 = $admin->insert();

        if($resultat2){
            $user = User::find(["id","=",$admin->id_user])[0];
            Mailer::sendEmail(self::$string, $user->email, null, $user->name, $user->surname, Mailer::$CODE_MAIL_PASSWORD);
        }

        return ($idUser && $resultat2);
    }

    private static function getClasseFromIntitule(string $intitule){
        $classe = Classe::first(["intitule", "=", $intitule], []);
        
        if($classe == null){
            return 0;
        }
        
        return $classe->id; 
    }

    private static function checkParamsStudent(array $params) : string{
        $message = "";

        if(!in_array(strtolower($params["tier_temps"]), self::$validParamTierTemps)){
            $message .= "tier_temps doit être soit à OUI ou à non </br>";
        }

        if(!in_array(strtolower($params["statut"]), self::$validParamsStatut)){
            $message .= "le statut doit être soit à Alternant, Non-assidu, Initial </br>";
        }

        return $message;
    }

    private static function checkParamsProf(array $params) : string{
        $message = "";

        if(isset($params["id_gitlab"])){
            if(preg_match("/^@[a-zA-Z]+$/", $params["id_gitlab"]) == 0){
                $message .= "id_gitlab doit être un identifiant valide </br>";
            }
        }
        return $message;

    }

    public static function getRandomString():String{
        $len  = rand(15,25);
        $bytes = openssl_random_pseudo_bytes($len);
        
        self::$string = bin2hex($bytes);
        return self::$string;
    }
    
    public static function isValidEmail($email):bool{
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    public static function getEnumOfStudentStatus(){
       //TODO: Implement the retrieving of status from DB
    }
}
