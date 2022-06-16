<?php
    require_once 'defines.php';
    require_once M_CLASSES . DS . 'etudiant.php';

    class CSVProcessor{

        static private $validFileTypes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
        private const STUDENT = "STUDENT";
        private const USER = "USER";
        private const PROFESSOR = "PROFESSOR";

        static function processCSV($nameFile, $destination){
            
            if(CSVProcessor::isValidFile($nameFile)){
                
                $function = CSVProcessor::methodSelector($destination);

                try{
                    
                    $row = 0;
                    $successful_inserts = 0;
                    $array = array();
                    $ligne = 0;
                    $num = null;

                    if (($handle = fopen($_FILES[$nameFile]["tmp_name"], "r")) !== FALSE) {
                        while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                            if($row == 0){
                                $num = count($data);
                                foreach($data as $key){
                                    array_push($array, $key);
                                }
                            }else{

                                $arrayParam = array();
                                for($i = 0; $i < $num; $i++){
                                    $arrayParam[$array[$i]] = $data[$i];
                                }
                               
                                $insertID = CSVProcessor::$function($arrayParam);

                                if($insertID != 0){
                                    $successful_inserts++;
                                }else{
                                    
                                    $ligne = $row+1;
                                    $_SESSION["error"] .= "Erreur à la ligne " . $ligne . " du fichier csv !</br>";
                                    
                                    break;
                                }

                            }
                           
                            $row++;
                            
                        }
                        fclose($handle);

                        if($ligne == 0 && $destination === "STUDENT"){ //there's no error
                            $_SESSION["success"] = "Total of " . $successful_inserts . " students inserted </br>";
                        }else if($ligne == 0 && $destination === "PROFESSOR"){
                            $_SESSION["success"] = "Total of " . $successful_inserts . " professors inserted </br>";
                        }
                        
                    }
                }catch(Exception $e){

                }
                
                
            }else{
                //Throw an error
                $_SESSION["error"] = "Seulement des fichiers du type .csv est attendu délimité par des ';'";
            }
        }

        private static function isValidFile($nameFile){
            return isset($_FILES[$nameFile]) && 
                   $_FILES[$nameFile]["error"] === UPLOAD_ERR_OK && 
                   in_array($_FILES[$nameFile]['type'], CSVProcessor::$validFileTypes);
        }

        private static function methodSelector(string $destination){
            $function = null;
            
            switch ($destination) {
                case self::STUDENT:
                    $function = "insertStudent";
                    break;

                case self::PROFESSOR:
                    $function = "insertProfessor";
                    break;

                default:
                    # code...
                    break;
            }

            return $function;
        }

        private static function insertProfessor(array $array){
            $arrayUser = CSVProcessor::buildArray($array, self::USER);
            $arrayProf = CSVProcessor::buildArray($array, self::PROFESSOR);

            $tabDate = explode("/", $arrayUser["date_naissance"]);
            $date  = $tabDate[2].'-'.$tabDate[1].'-'.$tabDate[0];

            $arrayUser["date_naissance"] = $date;

            $profID = API::insertProfessorAndUser($arrayProf, $arrayUser, true);

            return $profID;
        }

        private static function insertStudent(array $array){
            $arrayUser = CSVProcessor::buildArray($array, self::USER);
            $arrayStudent = CSVProcessor::buildArray($array, self::STUDENT);

            $tabDate = explode("/", $arrayUser["date_naissance"]);
            $date  = $tabDate[2].'-'.$tabDate[1].'-'.$tabDate[0];

            $arrayUser["date_naissance"] = $date;
           
            $studentID = API::insertStudentAndUser($arrayStudent,$arrayUser,true);
    
            return $studentID;
        }

        private static function buildArray(array $array, string $type) : array{
            $arrayOutput = array();

            switch ($type) {

                case self::USER:
                    $arrayOutput = array_slice($array, 0, 4);
                    break;
                
                case self::STUDENT:
                    $arrayOutput = array_slice($array, 4, count($array));    
                    break;
                
                case self::PROFESSOR:
                    $arrayOutput = array_slice($array, 4, count($array));    
                    break;

                default:
                    # code...
                    break;
            }

            return $arrayOutput;
        }
    }

?>