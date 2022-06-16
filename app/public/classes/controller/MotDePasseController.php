<?php
    require_once CLASSES.DS.'Controller.php';
    require_once M_CLASSES . DS . 'user.php'; 

    class MotDePasseController extends Controller {
        
        private int $CODE_NO_MATCH_PASSWORD = 1;
        private int $CODE_NO_MATCH_ANCIENT_PASSWORD = 2;
        private int $CODE_MISSING_FIELDS = 3;

        function showContent($infos) {
            if (empty($_SESSION)) session_start();
            
            if (!empty($_SESSION["user"])){//Change password for any user that is logged in
                
                if(isset($_POST["ChangePassword"])){
                    if($this->changePassword()){

                        $_SESSION["success"] = "Mot de passé modifié ! (Attention à ne pas l'oublier)";
                        Header("Location: ./deconnexion"); // TODO:Add redirection to ./compte.php page
                    }else{
                        require VIEWS.DS.'motDePasse.php';
                    }
                }else{
                    
                    require VIEWS.DS.'motDePasse.php';
                }
                
            }else{
                require_once VIEWS.DS.'erreur.php';
            }
            ob_flush();
        }

        private function changePassword():bool{
            if(!$this->validForm()){
                $_SESSION["error"] = "Veuillez remplir les champs en entier !";
                return false;
            }else{
                if($this->validateSubmittedValues()){
                    $_SESSION["user"]->password = password_hash($_POST["newPassword"], PASSWORD_BCRYPT);
                    return $_SESSION["user"]->update();
                    
                }
                return false;
            }
        }

        private function validForm(): bool{
            return (isset($_POST["oldPassword"]) && $_POST["oldPassword"] !== "") &&
                   (isset($_POST["newPassword"]) && $_POST["newPassword"] !== "") &&
                   (isset($_POST["newPasswordConfirm"]) && $_POST["newPasswordConfirm"] !== "");
        }

        private function validateSubmittedValues(): bool{
            
            $matchOldPassword = password_verify($_POST["oldPassword"], $_SESSION["user"]->password); 
            if($matchOldPassword){
                $matchConfirm = strcmp($_POST["newPassword"], $_POST["newPasswordConfirm"]);
                if($matchConfirm == 0){
                    return true;
                }else{
                    $_SESSION["error"] = "Le mot de passe saisi ne corresponds pas à la confirmation";
                    return false;
                }
            }else{
                $_SESSION["error"] = "L'ancien mot de passe ne corresponds pas au mot de passe actuel";
                return $matchOldPassword;
            }
        }
    }
?>