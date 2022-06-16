CREATE TABLE IF NOT EXISTS `smartgrades`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(200) NOT NULL,
  `role` ENUM("professeur", "etudiant", "administrateur") NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `surname` VARCHAR(45) NOT NULL,
  `date_naissance` DATE NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `smartgrades`.`administrateur` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `id_user`),
  INDEX `fk_administrateur_user1_idx` (`id_user`),
  CONSTRAINT `fk_administrateur_user1`
    FOREIGN KEY (`id_user`)
    REFERENCES `smartgrades`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `smartgrades`.`professeur` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `numero_professeur` INT NOT NULL,
  `id_gitlab` VARCHAR(150) NOT NULL,
  `id_user` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `id_user`),
  UNIQUE INDEX `numero_professeur_UNIQUE` (`numero_professeur`),
  UNIQUE INDEX `id_gitlab_UNIQUE` (`id_gitlab`),
  INDEX `fk_professeur_user1_idx` (`id_user`),
  CONSTRAINT `fk_professeur_user1`
    FOREIGN KEY (`id_user`)
    REFERENCES `smartgrades`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `smartgrades`.`classe` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `intitule` VARCHAR(100) NOT NULL,
  `annee` VARCHAR(45) NOT NULL,
  `promotion` VARCHAR(45) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `INDEX_INTITULE_ANNEE_PROMOTION` (`intitule`, `annee`, `promotion`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `smartgrades`.`examen` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `intitule` VARCHAR(100) NOT NULL,
  `date_examen` DATE NOT NULL,
  `type` ENUM("CCI", "CCF") NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `smartgrades`.`etudiant` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `numero_etudiant` INT NOT NULL,
  `id_gitlab` VARCHAR(150),
  `tier_temps` TINYINT NOT NULL,
  `cursus_postbac` VARCHAR(200) NOT NULL,
  `statut` ENUM("Alternance", "Non-assidu", "Initial") NOT NULL,
  `id_user` INT NOT NULL,
  `id_classe` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `id_user`, `id_classe`),
  UNIQUE INDEX `numero_etudiant_UNIQUE` (`numero_etudiant` ASC),
  INDEX `fk_etudiant_user_idx` (`id_user` ASC),
  INDEX `fk_etudiant_classe_idx` (`id_classe` ASC),
  UNIQUE INDEX `id_gitlab_UNIQUE` (`id_gitlab` ASC) ,
  CONSTRAINT `fk_etudiant_user`
    FOREIGN KEY (`id_user`)
    REFERENCES `smartgrades`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_etudiant_classe`
    FOREIGN KEY (`id_classe`)
    REFERENCES `smartgrades`.`classe` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `smartgrades`.`matiere` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name_matiere` VARCHAR(45) NOT NULL,
  `description_matiere` VARCHAR(45) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_matiere_UNIQUE` (`name_matiere`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `smartgrades`.`etudiant_has_matiere` (
  `id_etudiant` INT NOT NULL,
  `id_matiere` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_etudiant`, `id_matiere`),
  INDEX `fk_etudiant_has_matiere_matiere1_idx` (`id_matiere`),
  INDEX `fk_etudiant_has_matiere_etudiant1_idx` (`id_etudiant`),
  CONSTRAINT `fk_etudiant_has_matiere_etudiant1`
    FOREIGN KEY (`id_etudiant`)
    REFERENCES `smartgrades`.`etudiant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_etudiant_has_matiere_matiere1`
    FOREIGN KEY (`id_matiere`)
    REFERENCES `smartgrades`.`matiere` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `smartgrades`.`matiere_has_professeur` (
  `id_matiere` INT NOT NULL,
  `id_professeur` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_matiere`, `id_professeur`),
  INDEX `fk_matiere_has_professeur_professeur1_idx` (`id_professeur`),
  INDEX `fk_matiere_has_professeur_matiere1_idx` (`id_matiere`),
  CONSTRAINT `fk_matiere_has_professeur_matiere1`
    FOREIGN KEY (`id_matiere`)
    REFERENCES `smartgrades`.`matiere` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_matiere_has_professeur_professeur1`
    FOREIGN KEY (`id_professeur`)
    REFERENCES `smartgrades`.`professeur` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `smartgrades`.`classe_has_professeur` (
  `id_classe` INT NOT NULL,
  `id_professeur` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_classe`, `id_professeur`),
  INDEX `fk_classe_has_professeur_professeur1_idx` (`id_professeur`),
  INDEX `fk_classe_has_professeur_classe1_idx` (`id_classe`),
  CONSTRAINT `fk_classe_has_professeur_classe1`
    FOREIGN KEY (`id_classe`)
    REFERENCES `smartgrades`.`classe` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_classe_has_professeur_professeur1`
    FOREIGN KEY (`id_professeur`)
    REFERENCES `smartgrades`.`professeur` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `smartgrades`.`etudiant_has_examen` (
  `id_etudiant` INT NOT NULL,
  `id_examen` INT NOT NULL,
  `note` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_etudiant`, `id_examen`),
  INDEX `fk_etudiant_has_examen1_examen1_idx` (`id_examen`),
  INDEX `fk_etudiant_has_examen1_etudiant1_idx` (`id_etudiant`),
  CONSTRAINT `fk_etudiant_has_examen1_etudiant1`
    FOREIGN KEY (`id_etudiant`)
    REFERENCES `smartgrades`.`etudiant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_etudiant_has_examen1_examen1`
    FOREIGN KEY (`id_examen`)
    REFERENCES `smartgrades`.`examen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `smartgrades`.`examen_has_matiere` (
  `id_examen` INT NOT NULL,
  `id_matiere` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_examen`, `id_matiere`),
  INDEX `fk_examen_has_matiere_matiere1_idx` (`id_matiere`),
  INDEX `fk_examen_has_matiere_examen1_idx` (`id_examen`),
  CONSTRAINT `fk_examen_has_matiere_examen1`
    FOREIGN KEY (`id_examen`)
    REFERENCES `smartgrades`.`examen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_examen_has_matiere_matiere1`
    FOREIGN KEY (`id_matiere`)
    REFERENCES `smartgrades`.`matiere` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `smartgrades`.`examen_has_professeur` (
  `id_examen` INT NOT NULL,
  `id_professeur` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_examen`, `id_professeur`),
  INDEX `fk_examen_has_professeur_professeur1_idx` (`id_professeur`),
  INDEX `fk_examen_has_professeur_examen1_idx` (`id_examen`),
  CONSTRAINT `fk_examen_has_professeur_examen1`
    FOREIGN KEY (`id_examen`)
    REFERENCES `smartgrades`.`examen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_examen_has_professeur_professeur1`
    FOREIGN KEY (`id_professeur`)
    REFERENCES `smartgrades`.`professeur` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

