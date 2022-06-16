/*DROPPING CONSTRAINTS*/
ALTER TABLE `administrateur`
DROP CONSTRAINT `fk_administrateur_user1`; 

ALTER TABLE `professeur`
DROP CONSTRAINT `fk_professeur_user1`; 

ALTER TABLE `etudiant` 
DROP CONSTRAINT `fk_etudiant_user`;
ALTER TABLE `etudiant` 
DROP CONSTRAINT `fk_etudiant_classe`;

ALTER TABLE `etudiant_has_matiere`
DROP CONSTRAINT `fk_etudiant_has_matiere_etudiant1`;
ALTER TABLE `etudiant_has_matiere`
DROP CONSTRAINT `fk_etudiant_has_matiere_matiere1`;

ALTER TABLE `matiere_has_professeur` 
DROP CONSTRAINT `fk_matiere_has_professeur_matiere1`;
ALTER TABLE `matiere_has_professeur`
DROP CONSTRAINT `fk_matiere_has_professeur_professeur1`;

ALTER TABLE `classe_has_professeur` 
DROP CONSTRAINT `fk_classe_has_professeur_classe1`;
ALTER TABLE `classe_has_professeur`
DROP CONSTRAINT `fk_classe_has_professeur_professeur1`;

ALTER TABLE `etudiant_has_examen`
DROP CONSTRAINT `fk_etudiant_has_examen1_etudiant1`;
ALTER TABLE `etudiant_has_examen`
DROP CONSTRAINT `fk_etudiant_has_examen1_examen1`;

ALTER TABLE `examen_has_matiere` 
DROP CONSTRAINT `fk_examen_has_matiere_examen1`;
ALTER TABLE `examen_has_matiere` 
DROP CONSTRAINT`fk_examen_has_matiere_matiere1`;

ALTER TABLE `examen_has_professeur`
DROP CONSTRAINT `fk_examen_has_professeur_examen1`;
ALTER TABLE `examen_has_professeur`
DROP CONSTRAINT `fk_examen_has_professeur_professeur1`;

ALTER TABLE `question_has_examen`
DROP CONSTRAINT `fk_question_has_examen_question1`;
ALTER TABLE `question_has_examen`
DROP CONSTRAINT `fk_question_has_examen_examen1`;

ALTER TABLE `smartgrades`.`classe`
DROP CONSTRAINT `fk_annee_scolaire_idx_classe`;
ALTER TABLE `smartgrades`.`matiere`
DROP CONSTRAINT `fk_annee_scolaire_idx_matiere`;


/*TRUNCATING DATA FROM TABLES */
TRUNCATE `administrateur`;
TRUNCATE `etudiant`;
TRUNCATE `classe`;
TRUNCATE `classe_has_professeur`;
TRUNCATE `etudiant_has_examen`;
TRUNCATE `etudiant_has_matiere`;
TRUNCATE `examen`;
TRUNCATE `examen_has_matiere`;
TRUNCATE `matiere`;
TRUNCATE `matiere_has_professeur`;
TRUNCATE `professeur`;
TRUNCATE `user`;
TRUNCATE `examen_has_professeur`;
TRUNCATE `question_has_examen`;
TRUNCATE `question`;
TRUNCATE `annee_scolaire`;

/*PUT BACK CONSTRAINTS ON THE TABLES */
ALTER TABLE `administrateur` ADD CONSTRAINT `fk_administrateur_user1`
    FOREIGN KEY (`id_user`)
    REFERENCES `smartgrades`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

ALTER TABLE `professeur` ADD CONSTRAINT `fk_professeur_user1`
    FOREIGN KEY (`id_user`)
    REFERENCES `smartgrades`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

ALTER TABLE `etudiant` ADD CONSTRAINT `fk_etudiant_user`
    FOREIGN KEY (`id_user`)
    REFERENCES `smartgrades`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

ALTER TABLE `etudiant` ADD CONSTRAINT `fk_etudiant_classe`
    FOREIGN KEY (`id_classe`)
    REFERENCES `smartgrades`.`classe` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

ALTER TABLE `etudiant_has_matiere` ADD CONSTRAINT `fk_etudiant_has_matiere_etudiant1`
    FOREIGN KEY (`id_etudiant`)
    REFERENCES `smartgrades`.`etudiant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;
ALTER TABLE `etudiant_has_matiere` ADD CONSTRAINT `fk_etudiant_has_matiere_matiere1`
    FOREIGN KEY (`id_matiere`)
    REFERENCES `smartgrades`.`matiere` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

ALTER TABLE `matiere_has_professeur` ADD CONSTRAINT `fk_matiere_has_professeur_matiere1`
    FOREIGN KEY (`id_matiere`)
    REFERENCES `smartgrades`.`matiere` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;
ALTER TABLE `matiere_has_professeur` ADD CONSTRAINT `fk_matiere_has_professeur_professeur1`
    FOREIGN KEY (`id_professeur`)
    REFERENCES `smartgrades`.`professeur` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

ALTER TABLE `classe_has_professeur` ADD CONSTRAINT `fk_classe_has_professeur_classe1`
    FOREIGN KEY (`id_classe`)
    REFERENCES `smartgrades`.`classe` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;
ALTER TABLE `classe_has_professeur` ADD CONSTRAINT `fk_classe_has_professeur_professeur1`
    FOREIGN KEY (`id_professeur`)
    REFERENCES `smartgrades`.`professeur` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

ALTER TABLE `etudiant_has_examen` ADD CONSTRAINT `fk_etudiant_has_examen1_etudiant1`
    FOREIGN KEY (`id_etudiant`)
    REFERENCES `smartgrades`.`etudiant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;
ALTER TABLE `etudiant_has_examen` ADD CONSTRAINT `fk_etudiant_has_examen1_examen1`
    FOREIGN KEY (`id_examen`)
    REFERENCES `smartgrades`.`examen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

ALTER TABLE `examen_has_matiere` ADD CONSTRAINT `fk_examen_has_matiere_examen1`
    FOREIGN KEY (`id_examen`)
    REFERENCES `smartgrades`.`examen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;
ALTER TABLE `examen_has_matiere` ADD CONSTRAINT `fk_examen_has_matiere_matiere1`
    FOREIGN KEY (`id_matiere`)
    REFERENCES `smartgrades`.`matiere` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

ALTER TABLE `examen_has_professeur` ADD CONSTRAINT `fk_examen_has_professeur_examen1`
    FOREIGN KEY (`id_examen`)
    REFERENCES `smartgrades`.`examen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;
ALTER TABLE `examen_has_professeur` ADD CONSTRAINT `fk_examen_has_professeur_professeur1`
    FOREIGN KEY (`id_professeur`)
    REFERENCES `smartgrades`.`professeur` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION; 

ALTER TABLE `question_has_examen` ADD CONSTRAINT `fk_question_has_examen_question1`
    FOREIGN KEY (`id_question`)
    REFERENCES `smartgrades`.`question` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;
ALTER TABLE `question_has_examen` ADD  CONSTRAINT `fk_question_has_examen_examen1`
    FOREIGN KEY (`id_examen`)
    REFERENCES `smartgrades`.`examen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

ALTER TABLE `smartgrades`.`classe` ADD CONSTRAINT `fk_annee_scolaire_idx_classe`
  FOREIGN KEY (`id_annee_scolaire`)
  REFERENCES `smartgrades`.`annee_scolaire`(`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `smartgrades`.`matiere` ADD CONSTRAINT `fk_annee_scolaire_idx_matiere`
  FOREIGN KEY (`id_annee_scolaire`)
  REFERENCES `smartgrades`.`annee_scolaire`(`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


/*Resetting auto_increment*/
ALTER TABLE `smartgrades`.`user` AUTO_INCREMENT=1;
ALTER TABLE `smartgrades`.`administrateur` AUTO_INCREMENT=1; 
ALTER TABLE `smartgrades`.`professeur` AUTO_INCREMENT=1; 
ALTER TABLE `smartgrades`.`classe` AUTO_INCREMENT=1; 
ALTER TABLE `smartgrades`.`examen` AUTO_INCREMENT=1; 
ALTER TABLE `smartgrades`.`etudiant` AUTO_INCREMENT=1; 
ALTER TABLE `smartgrades`.`matiere` AUTO_INCREMENT=1; 
ALTER TABLE `smartgrades`.`question` AUTO_INCREMENT=1;
ALTER TABLE `smartgrades`.`annee_scolaire` AUTO_INCREMENT=1;