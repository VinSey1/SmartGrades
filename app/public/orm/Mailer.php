<?php

    require_once("defines.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require_once PHP_MAILER.DS.'Exception.php';
    require_once PHP_MAILER.DS.'PHPMailer.php';
    require_once PHP_MAILER.DS.'SMTP.php';
    class Mailer{
        private static $endMessage = '<br>Cordialement,<br>L\'équipe de SmartGrades.<br>
                                (Pour tout autre renseignements, veuillez vous rapprocher de votre 
                                enseignant ou nous envoyer un mail)<br><a href="mailto:smartgrades68@gmail.com">Nous contacter</a></br></html></body>';

        private static $body = '<html><body>Bonjour %s %s,<br>
                Votre mot de passe temporaire est : <b>%s</b>.<br>
                Veuillez le changer immédiatemment après votre première connexion à votre compte !<br>';

        private static $bodyReinitialisation = '<html><body>Bonjour %s %s,<br>
        La réinitialisation de votre mot de passe a été traité.</br>
        Voici votre nouveau de mot de passe : <b>%s</b>.<br>
        Veuillez le changer immédiatemment après connexion à votre compte !<br>';
        
        public static $CODE_MAIL_PASSWORD = 1;
        public static $CODE_MAIL_REINITIALISATION_PWD = 2;

        private static $subjectCreateAccount = "Bienvenue sur SmartGrades";
        private static $defaultSubject = "Message de SmartGrades";
        private static $subjectResetMDP = "Réinitialisation du mot de passe";

        /**
         * This method allows you to send email with the PHPMAILER library (@link https://github.com/PHPMailer/PHPMailer)
         * 
         * You need to specify the email address of the receiver and the content of the email.
         * The $name and $surname are mandatory is case you need to send a password after change of creation.
         * 
         * 
         *
         * @param String $content is the content of the mail to be sent 
         * @param String $receiver is mandatory this is the email of the receiver
         * @param String|null $subject is not mandatory a default subject will be put instead {@see Mailer::$defaultSubject}
         * @param String|null $name not mandatory 
         * @param String|null $surname not mandatory
         * @param integer $typeOfMail @see all the properties beginnning by $CODE_...
         * @return void
         */
        static function sendEmail(String $content, String $receiver, String $subject = null, String $name = null, String $surname = null, int $typeOfMail){
            
            $mail = new PHPMailer();
            $mail->isSMTP();

            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';

            $mail->Port = 587;

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->SMTPAuth = true;


            $mail->Username = 'smartgrades68@gmail.com';
            $mail->Password = '68smartgrades68';

          
            $mail->setFrom('smartgrades@services.com', 'SmartGrades');
          
            $mail->addAddress($receiver, $name ." ". $surname);

            
            if($subject !== null){
                $mail->Subject = $subject;
            }else{
                if($typeOfMail == self::$CODE_MAIL_PASSWORD){
                    $mail->Subject = self::$subjectCreateAccount;
                }else if($typeOfMail == self::$CODE_MAIL_REINITIALISATION_PWD){
                    $mail->Subject = self::$subjectResetMDP;
                }else{
                    $mail->Subject = self::$defaultSubject;
                }
                    

            }
            
            $mail->CharSet = "UTF-8";
            $textToSend = self::buildMessage($content, $typeOfMail, $name, $surname);

            if($textToSend !== ""){
                $mail->isHTML(true);
                $mail->Body = $textToSend;

           
                $mail->AltBody = 'Message de SmartGrades';

                $sent = $mail->send();
                if(!$sent){
                    $_SESSION["error"] = "Coudln't send email";
                }
                return $sent;
            }
            return false;
        }

        private static function buildMessage(String $content, int $code, String $name = null, String $surname = null): String{
            $text = "";
            switch($code){
                case self::$CODE_MAIL_PASSWORD: 
                    if($name !== null && $surname !== null){
                            
                            
                        $text = sprintf(self::$body, $surname, $name, $content); //content is the password
                        $text .= self::$endMessage;
                    }
                    break;
                case self::$CODE_MAIL_REINITIALISATION_PWD:
                    if($name !== null && $surname !== null){
                            
                            
                        $text = sprintf(self::$bodyReinitialisation, $surname, $name, $content); //content is the password
                        $text .= self::$endMessage;
                    }
                    break;    

                default: //message written for example
                    $text = $content . self::$endMessage;
                    break;
                
            }

            return $text;
        }
    }
?>