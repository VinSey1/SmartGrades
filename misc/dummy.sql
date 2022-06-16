-- Adminer 4.8.1 MySQL 8.0.28 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `Administrateur`;
CREATE TABLE `Administrateur` (
  `idAdmin` varchar(120) NOT NULL,
  `User_email` varchar(100) NOT NULL,
  PRIMARY KEY (`idAdmin`,`User_email`),
  KEY `fk_Administrateur_User1_idx` (`User_email`),
  CONSTRAINT `fk_Administrateur_User1` FOREIGN KEY (`User_email`) REFERENCES `User` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Classe`;
CREATE TABLE `Classe` (
  `idClasse` varchar(100) NOT NULL,
  `promotion` varchar(45) NOT NULL,
  `annee` varchar(45) NOT NULL,
  PRIMARY KEY (`idClasse`),
  UNIQUE KEY `UNQ_PROMOTION_ANNEE_IDX` (`promotion`,`annee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Classe_has_Professeur`;
CREATE TABLE `Classe_has_Professeur` (
  `Classe_idClasse` varchar(100) NOT NULL,
  `Professeur_idProfesseur` int NOT NULL,
  `Professeur_User_email` varchar(100) NOT NULL,
  PRIMARY KEY (`Classe_idClasse`,`Professeur_idProfesseur`,`Professeur_User_email`),
  KEY `fk_Classe_has_Professeur_Professeur1_idx` (`Professeur_idProfesseur`,`Professeur_User_email`),
  KEY `fk_Classe_has_Professeur_Classe1_idx` (`Classe_idClasse`),
  CONSTRAINT `fk_Classe_has_Professeur_Classe1` FOREIGN KEY (`Classe_idClasse`) REFERENCES `Classe` (`idClasse`),
  CONSTRAINT `fk_Classe_has_Professeur_Professeur1` FOREIGN KEY (`Professeur_idProfesseur`, `Professeur_User_email`) REFERENCES `Professeur` (`idProfesseur`, `User_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Etudiant`;
CREATE TABLE `Etudiant` (
  `idEtudiant` int NOT NULL,
  `User_email` varchar(100) NOT NULL,
  `Classe_idClasse` varchar(100) NOT NULL,
  PRIMARY KEY (`idEtudiant`,`User_email`,`Classe_idClasse`),
  UNIQUE KEY `User_email_UNIQUE` (`User_email`),
  KEY `fk_Etudiant_User1_idx` (`User_email`),
  KEY `fk_Etudiant_Classe1_idx` (`Classe_idClasse`),
  CONSTRAINT `fk_Etudiant_Classe1` FOREIGN KEY (`Classe_idClasse`) REFERENCES `Classe` (`idClasse`),
  CONSTRAINT `fk_Etudiant_User1` FOREIGN KEY (`User_email`) REFERENCES `User` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Matiere`;
CREATE TABLE `Matiere` (
  `idMatiere` varchar(45) NOT NULL,
  `nameMatiere` varchar(45) NOT NULL,
  PRIMARY KEY (`idMatiere`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Matiere_has_Etudiant`;
CREATE TABLE `Matiere_has_Etudiant` (
  `Matiere_idMatiere` varchar(45) NOT NULL,
  `Etudiant_idEtudiant` int NOT NULL,
  `Etudiant_User_email` varchar(100) NOT NULL,
  `Etudiant_Classe_idClasse` varchar(100) NOT NULL,
  PRIMARY KEY (`Matiere_idMatiere`,`Etudiant_idEtudiant`,`Etudiant_User_email`,`Etudiant_Classe_idClasse`),
  KEY `fk_Matiere_has_Etudiant_Etudiant1_idx` (`Etudiant_idEtudiant`,`Etudiant_User_email`,`Etudiant_Classe_idClasse`),
  KEY `fk_Matiere_has_Etudiant_Matiere1_idx` (`Matiere_idMatiere`),
  CONSTRAINT `fk_Matiere_has_Etudiant_Etudiant1` FOREIGN KEY (`Etudiant_idEtudiant`, `Etudiant_User_email`, `Etudiant_Classe_idClasse`) REFERENCES `Etudiant` (`idEtudiant`, `User_email`, `Classe_idClasse`),
  CONSTRAINT `fk_Matiere_has_Etudiant_Matiere1` FOREIGN KEY (`Matiere_idMatiere`) REFERENCES `Matiere` (`idMatiere`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Matiere_has_Professeur`;
CREATE TABLE `Matiere_has_Professeur` (
  `Matiere_idMatiere` varchar(45) NOT NULL,
  `Professeur_idProfesseur` int NOT NULL,
  `Professeur_User_email` varchar(100) NOT NULL,
  PRIMARY KEY (`Matiere_idMatiere`,`Professeur_idProfesseur`,`Professeur_User_email`),
  KEY `fk_Matiere_has_Professeur_Professeur1_idx` (`Professeur_idProfesseur`,`Professeur_User_email`),
  KEY `fk_Matiere_has_Professeur_Matiere1_idx` (`Matiere_idMatiere`),
  CONSTRAINT `fk_Matiere_has_Professeur_Matiere1` FOREIGN KEY (`Matiere_idMatiere`) REFERENCES `Matiere` (`idMatiere`),
  CONSTRAINT `fk_Matiere_has_Professeur_Professeur1` FOREIGN KEY (`Professeur_idProfesseur`, `Professeur_User_email`) REFERENCES `Professeur` (`idProfesseur`, `User_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Professeur`;
CREATE TABLE `Professeur` (
  `idProfesseur` int NOT NULL,
  `User_email` varchar(100) NOT NULL,
  PRIMARY KEY (`idProfesseur`,`User_email`),
  KEY `fk_Professeur_User1_idx` (`User_email`),
  CONSTRAINT `fk_Professeur_User1` FOREIGN KEY (`User_email`) REFERENCES `User` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `User`;
CREATE TABLE `User` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` enum('Professeur','Etudiant','Administrateur') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `surname` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  PRIMARY KEY (`email`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `User` (`id`, `email`, `password`, `role`, `name`, `surname`, `age`) VALUES
(1,	'test',	'$2y$10$xF5VH7655xOx/q3C1umwduXDCrv8Wq2fcsLEtzsGTSHdSyD5G5V8G',	NULL,	NULL,	NULL,	NULL);

-- 2022-01-29 14:57:48
