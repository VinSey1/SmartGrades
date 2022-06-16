<?php
    require_once CLASSES.DS.'Controller.php';
    require_once M_CLASSES . DS . 'user.php';
    require_once ORM . DS . 'Mailer.php';
    require_once ORM . DS . 'API.php';

    class MotDePasseOublieController extends Controller {
        

        function showContent($infos) {
            if (empty($_SESSION)) session_start();
            
            if(isset($_POST["emailReceiver"])){
                if($this->sendPassword()){
                    $_SESSION["success"] = "Mot de passe envoyé ";
                    Header("Location: connexion"); 
                }else{
                require VIEWS.DS.'motDePasseOublie.php';
                }
            }else{
                require VIEWS.DS.'motDePasseOublie.php';
            }
                
            ob_flush();
        }

        private function sendPassword():bool{

            if(API::isValidEmail($_POST["emailReceiver"])){

                $user = User::first([["email", "=", $_POST["emailReceiver"]]]);

                if($user !== null){

                    $pwd = API::getRandomString();
                    $user->password = password_hash($pwd, PASSWORD_BCRYPT);
                    
                    if($user->update()){

                        $sent = Mailer::sendEmail($pwd, $user->email, null, $user->name, $user->surname, Mailer::$CODE_MAIL_REINITIALISATION_PWD);
                        if(!$sent){
                            $_SESSION["error"] = "Email n'a pas pu être envoyé veuillez réessayer plus tard";
                        }else{
                            $_SESSION["success"] = "Mot de passe réinitialisé";
                        }
                        
                        return $sent;
                    }else{
                        $_SESSION["error"] = "Quelque chose s'est mal passé, veuillez réessayer ultérieurement";
                    }
                    
                }else{
                    $_SESSION["error"] = "L'email est invalide";
                }
            }else{
                $_SESSION["error"] = "Veuillez rentrer un mail valide";
            }
            
            return false;
        }
    }
?>