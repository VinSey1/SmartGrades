INSERT INTO `smartgrades`.`user`(`email`, `password`, `role`,  `surname`,  `name`, `date_naissance`) VALUES("toto9@gmail.com",
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Administrateur",
                            "Auger",
                            "René",
                            "1972-01-20"); 

INSERT INTO `smartgrades`.`administrateur`(`id_user`) VALUES(1);

ALTER TABLE classe
ADD CONSTRAINT UC_Classe UNIQUE (intitule, annee, promotion);

ALTER TABLE classe
DROP INDEX INDEX_INTITULE_ANNEE_PROMOTION;

CREATE TABLE IF NOT EXISTS smartgrades.question (
  id INT NOT NULL AUTO_INCREMENT,
  contenu VARCHAR(150) NOT NULL,
  commentaire VARCHAR(300) NOT NULL,
  points VARCHAR(45) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id))
ENGINE = InnoDB;

/* Creating pivot table between question table and examen table */
CREATE TABLE IF NOT EXISTS smartgrades.question_has_examen (
  id_question INT NOT NULL,
  id_examen INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id_question, id_examen),
  INDEX fk_question_has_examen_examen1_idx (id_examen),
  INDEX fk_question_has_examen_question1_idx (id_question),
  CONSTRAINT fk_question_has_examen_question1
    FOREIGN KEY (id_question)
    REFERENCES smartgrades.question (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_question_has_examen_examen1
    FOREIGN KEY (id_examen)
    REFERENCES smartgrades.examen (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

ALTER TABLE `examen`
ADD examen_publie TINYINT(1) NOT NULL DEFAULT 0;

ALTER TABLE `smartgrades`.`etudiant_has_examen` CHANGE `note` `note` DOUBLE NOT NULL DEFAULT '-1';

/*Remove NULL CONSTRAINT on id_gitlab field in Etudiant TABLES */
ALTER TABLE `smartgrades`.`etudiant` MODIFY `id_gitlab` VARCHAR(150);


/*Creating annee_scolaire table*/
CREATE TABLE IF NOT EXISTS `smartgrades`.`annee_scolaire`(
  `id` INT AUTO_INCREMENT NOT NULL,
  `intitule` VARCHAR(45) NOT NULL UNIQUE,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB;

/*Removing annee field to put an FK referencing annee_scolaire table */
ALTER TABLE `smartgrades`.`classe`
DROP COLUMN `annee`, 
ADD `id_annee_scolaire` INT AFTER `intitule`; /*Add not null?*/

CREATE INDEX `fk_annee_scolaire_idx_classe` ON `smartgrades`.`classe`(`id_annee_scolaire`);

ALTER TABLE `smartgrades`.`classe`
ADD CONSTRAINT `fk_annee_scolaire_idx_classe`
  FOREIGN KEY (`id_annee_scolaire`)
  REFERENCES `smartgrades`.`annee_scolaire`(`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


/*Add FK in matiere referencing annee_scolaire table*/
ALTER TABLE `smartgrades`.`matiere`
ADD `id_annee_scolaire` INT AFTER `description_matiere`; /*Add not null ?*/

CREATE INDEX `fk_annee_scolaire_idx_matiere` ON `smartgrades`.`matiere`(`id_annee_scolaire`);

ALTER TABLE `smartgrades`.`matiere`
ADD CONSTRAINT `fk_annee_scolaire_idx_matiere`
  FOREIGN KEY (`id_annee_scolaire`)
  REFERENCES `smartgrades`.`annee_scolaire`(`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `smartgrades`.`administrateur` ADD UNIQUE(`id_user`);
ALTER TABLE `smartgrades`.`etudiant` ADD UNIQUE(`id_user`);
ALTER TABLE `smartgrades`.`professeur` ADD UNIQUE(`id_user`);

ALTER TABLE `classe`
  ADD UNIQUE `intitule_promotion_id_annee_scolaire` (`intitule`, `promotion`, `id_annee_scolaire`);
ALTER TABLE `classe` DROP INDEX `UC_Classe`;

ALTER TABLE `matiere`
  ADD UNIQUE `name_matiere_id_annee_scolaire` (`name_matiere`, `id_annee_scolaire`);
ALTER TABLE `matiere` DROP INDEX `name_matiere_UNIQUE`;