<?php
    class Authentifieur {
        // Fonctions à redéfinir en fonction du contexte d'utilisation
        static private function getHashedPassword($username) {
            require_once M_CLASSES.DS.'user.php';
            $user = User::first(["email", "=", $username], ["email", "password"]);
            if ($user === NULL)
                return false;
            else
                return $user->password;
        }
        static private function addNewUser($attributs) {
            require_once M_CLASSES.DS.'user.php';
            $user = new User();
            $user->email = $attributs['username'];
            $user->password = password_hash($attributs['password'], PASSWORD_BCRYPT);
            $user->role = $attributs['type'];
            $user->name = $attributs['nom'];
            $user->surname = $attributs['prenom'];
            $user->date_naissance = $attributs['date'];
            $insertionuser = $user->insert();
            return $insertionuser;
        }
        static private function setNewPassword($username, $password) {
            require_once M_CLASSES.DS.'user.php';
            $user = User::first(["email", "=", $_SESSION['username']]);
            $user->password = password_hash($password, PASSWORD_BCRYPT);
            $user->updated_at = null;
            $miseajouruser = $user->update();
            return $miseajouruser;
        }
        static private function removeUser($username) {
            require_once M_CLASSES.DS.'user.php';
            $user = User::first(["email", "=", $_SESSION['username']]);
            $suppressionuser = $user->delete();
            return $suppressionuser;
        }
        // Fonction vérifiant si les identifiants donnés sont bons ou pas
        static function authentifier($username, $password) {
            if (empty($username) || empty($password))
                return false;
            // Filtrage du code malveillant
            $username = htmlentities($username);
            $password = htmlentities($password);
            $hashedPassword = self::getHashedPassword($username);
            if ($hashedPassword)
                return password_verify($password, $hashedPassword);
            else
                return false;
        }
        // Function à appeler pour rajouter des nouveaux identifiants valides
        static function insertNew($attributs) {
            if (empty($attributs))
                return false;
            // Filtrage du code malveillant
            foreach ($attributs as $cleattribut => $attribut)
                $attributs[$cleattribut] = htmlentities($attribut);
            $ajoutNouvelUtilisateur = self::addNewUser($attributs);
            return $ajoutNouvelUtilisateur;
        }
        // Function à appeler pour changer le mot de passe
        static function updatePassword($username, $password) {
            if (empty($username) || empty($password))
                return false;
            // Filtrage du code malveillant
            $username = htmlentities($username);
            $password = htmlentities($password);
            $miseAJourMotDePasse = self::setNewPassword($username, $password);
            return $miseAJourMotDePasse;
        }
        // Function à appeler pour supprimer un utilisateur de la base
        static function delete($username) {
            if (empty($username))
                return false;
            // Filtrage du code malveillant
            $username = htmlentities($username);
            $suppression = self::removeUser($username);
            return $suppression;
        }
    }
?>