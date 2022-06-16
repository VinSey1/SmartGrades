DROP TABLE IF EXISTS `Matiere_has_Etudiant`;
DROP TABLE IF EXISTS `Matiere_has_Professeur`;
DROP TABLE IF EXISTS `Classe_has_Professeur`;
DROP TABLE IF EXISTS `Etudiant`;
DROP TABLE IF EXISTS `Professeur`;
DROP TABLE IF EXISTS `Administrateur`;
DROP TABLE IF EXISTS `Classe`;
DROP TABLE IF EXISTS `Matiere`;
DROP TABLE IF EXISTS `User`;

CREATE TABLE IF NOT EXISTS `smartgrades`.`User` (
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(200) NOT NULL,
  `role` ENUM("Professeur", "Etudiant", "Administrateur") NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `surname` VARCHAR(45) NOT NULL,
  `age` INT NOT NULL,
  PRIMARY KEY (`email`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `smartgrades`.`Administrateur` (
  `idAdmin` VARCHAR(120) NOT NULL,
  `User_email` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idAdmin`, `User_email`),
  INDEX `fk_Administrateur_User1_idx` (`User_email`),
  CONSTRAINT `fk_Administrateur_User1`
    FOREIGN KEY (`User_email`)
    REFERENCES `smartgrades`.`User` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `smartgrades`.`Professeur` (
  `idProfesseur` INT NOT NULL,
  `User_email` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idProfesseur`, `User_email`),
  INDEX `fk_Professeur_User1_idx` (`User_email`),
  CONSTRAINT `fk_Professeur_User1`
    FOREIGN KEY (`User_email`)
    REFERENCES `smartgrades`.`User` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `smartgrades`.`Classe` (
  `idClasse` VARCHAR(100) NOT NULL,
  `promotion` VARCHAR(45) NOT NULL,
  `annee` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idClasse`))
ENGINE = InnoDB;


ALTER TABLE  `smartgrades`.`Classe`
ADD CONSTRAINT `UNQ_PROMOTION_ANNEE_IDX` UNIQUE(`promotion`, `annee`);



CREATE TABLE IF NOT EXISTS `smartgrades`.`Matiere` (
  `idMatiere` VARCHAR(45) NOT NULL,
  `nameMatiere` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idMatiere`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `smartgrades`.`Etudiant` (
  `idEtudiant` INT NOT NULL,
  `User_email` VARCHAR(100) NOT NULL,
  `Classe_idClasse` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idEtudiant`, `User_email`, `Classe_idClasse`),
  INDEX `fk_Etudiant_User1_idx` (`User_email`),
  INDEX `fk_Etudiant_Classe1_idx` (`Classe_idClasse`),
  UNIQUE INDEX `User_email_UNIQUE` (`User_email`),
  CONSTRAINT `fk_Etudiant_User1`
    FOREIGN KEY (`User_email`)
    REFERENCES `smartgrades`.`User` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Etudiant_Classe1`
    FOREIGN KEY (`Classe_idClasse`)
    REFERENCES `smartgrades`.`Classe` (`idClasse`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `smartgrades`.`Matiere_has_Etudiant` (
  `Matiere_idMatiere` VARCHAR(45) NOT NULL,
  `Etudiant_idEtudiant` INT NOT NULL,
  `Etudiant_User_email` VARCHAR(100) NOT NULL,
  `Etudiant_Classe_idClasse` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Matiere_idMatiere`, `Etudiant_idEtudiant`, `Etudiant_User_email`, `Etudiant_Classe_idClasse`),
  INDEX `fk_Matiere_has_Etudiant_Etudiant1_idx` (`Etudiant_idEtudiant`, `Etudiant_User_email`, `Etudiant_Classe_idClasse`),
  INDEX `fk_Matiere_has_Etudiant_Matiere1_idx` (`Matiere_idMatiere`),
  CONSTRAINT `fk_Matiere_has_Etudiant_Matiere1`
    FOREIGN KEY (`Matiere_idMatiere`)
    REFERENCES `smartgrades`.`Matiere` (`idMatiere`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Matiere_has_Etudiant_Etudiant1`
    FOREIGN KEY (`Etudiant_idEtudiant` , `Etudiant_User_email` , `Etudiant_Classe_idClasse`)
    REFERENCES `smartgrades`.`Etudiant` (`idEtudiant` , `User_email` , `Classe_idClasse`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `smartgrades`.`Matiere_has_Professeur` (
  `Matiere_idMatiere` VARCHAR(45) NOT NULL,
  `Professeur_idProfesseur` INT NOT NULL,
  `Professeur_User_email` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Matiere_idMatiere`, `Professeur_idProfesseur`, `Professeur_User_email`),
  INDEX `fk_Matiere_has_Professeur_Professeur1_idx` (`Professeur_idProfesseur`, `Professeur_User_email`),
  INDEX `fk_Matiere_has_Professeur_Matiere1_idx` (`Matiere_idMatiere`),
  CONSTRAINT `fk_Matiere_has_Professeur_Matiere1`
    FOREIGN KEY (`Matiere_idMatiere`)
    REFERENCES `smartgrades`.`Matiere` (`idMatiere`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Matiere_has_Professeur_Professeur1`
    FOREIGN KEY (`Professeur_idProfesseur` , `Professeur_User_email`)
    REFERENCES `smartgrades`.`Professeur` (`idProfesseur` , `User_email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `smartgrades`.`Classe_has_Professeur` (
  `Classe_idClasse` VARCHAR(100) NOT NULL,
  `Professeur_idProfesseur` INT NOT NULL,
  `Professeur_User_email` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Classe_idClasse`, `Professeur_idProfesseur`, `Professeur_User_email`),
  INDEX `fk_Classe_has_Professeur_Professeur1_idx` (`Professeur_idProfesseur`, `Professeur_User_email`),
  INDEX `fk_Classe_has_Professeur_Classe1_idx` (`Classe_idClasse`),
  CONSTRAINT `fk_Classe_has_Professeur_Classe1`
    FOREIGN KEY (`Classe_idClasse`)
    REFERENCES `smartgrades`.`Classe` (`idClasse`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Classe_has_Professeur_Professeur1`
    FOREIGN KEY (`Professeur_idProfesseur` , `Professeur_User_email`)
    REFERENCES `smartgrades`.`Professeur` (`idProfesseur` , `User_email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;




                                                                