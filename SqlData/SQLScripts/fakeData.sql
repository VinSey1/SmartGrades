/*Inserting fake users ==>Password = T0T0 (0=zeros)*/

INSERT INTO `smartgrades`.`user`(`email`, `password`, `role`,  `surname`,  `name`, `date_naissance`) VALUES("toto1@gmail.com", 
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Etudiant",
                            "Dallest",
                            "Bryan",
                            "2000-11-20");

INSERT INTO `smartgrades`.`user`(`email`, `password`, `role`,  `surname`,  `name`, `date_naissance`) VALUES("toto2@gmail.com", 
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Etudiant",
                            "Baraniak",
                            "David",
                            "1997-06-17");

INSERT INTO `smartgrades`.`user`(`email`, `password`, `role`,  `surname`,  `name`, `date_naissance`) VALUES("toto3@gmail.com", 
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Etudiant",
                            "De Sousa",
                            "Benoît",
                            "1999-11-21");

INSERT INTO `smartgrades`.`user`(`email`, `password`, `role`,  `surname`,  `name`, `date_naissance`) VALUES("toto4@gmail.com", 
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Etudiant",
                            "Seyller",
                            "Vincent",
                            "1998-11-05");

INSERT INTO `smartgrades`.`user`(`email`, `password`, `role`,  `surname`,  `name`, `date_naissance`) VALUES("toto5@gmail.com", 
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Professeur",
                            "Carret",
                            "Pierre",
                            "2000-01-10");

INSERT INTO `smartgrades`.`user`(`email`, `password`, `role`,  `surname`,  `name`, `date_naissance`) VALUES("toto6@gmail.com", 
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Professeur",
                            "Delapierre",
                            "Nathan",
                            "2000-01-20");

INSERT INTO `smartgrades`.`user`(`email`, `password`, `role`,  `surname`,  `name`, `date_naissance`) VALUES("toto7@gmail.com", 
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Professeur",
                            "Dupont",
                            "Stéphanie",
                            "1987-11-21");      

INSERT INTO `smartgrades`.`user`(`email`, `password`, `role`,  `surname`,  `name`, `date_naissance`) VALUES("toto8@gmail.com", 
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Administrateur",
                            "Dutton",
                            "Jeremy",
                            "1980-05-21"); 

INSERT INTO `smartgrades`.`user`(`email`, `password`, `role`,  `surname`,  `name`, `date_naissance`) VALUES("toto9@gmail.com",
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Administrateur",
                            "Auger",
                            "René",
                            "1972-01-20"); 


INSERT INTO `smartgrades`.`annee_scolaire`(`intitule`) VALUES ("2021-2022");
INSERT INTO `smartgrades`.`annee_scolaire`(`intitule`) VALUES ("2022-2023");

/*Inserting subjects*/

INSERT INTO `smartgrades`.`matiere`(`name_matiere`, `description_matiere`, `id_annee_scolaire`) VALUES("PHP", "Matiere de PHP", 1);
INSERT INTO `smartgrades`.`matiere`(`name_matiere`, `description_matiere`, `id_annee_scolaire`) VALUES("JAVA", "Matiere de JAVA", 1);
INSERT INTO `smartgrades`.`matiere`(`name_matiere`, `description_matiere`, `id_annee_scolaire`) VALUES("Méthodes Agiles", "Matiere de méthodes Agiles", 1);

/*Inserting Promotions*/

INSERT INTO `smartgrades`.`classe`(`intitule`, `id_annee_scolaire`, `promotion`) VALUES("IM2021", 1, "INFO MOBILITE");
INSERT INTO `smartgrades`.`classe`(`intitule`, `id_annee_scolaire`, `promotion`) VALUES("IM2022", 2, "INFO MOBILITE");

/*Roles attribution*/
INSERT INTO `smartgrades`.`administrateur`(`id_user`) VALUES(9);
INSERT INTO `smartgrades`.`administrateur`(`id_user`) VALUES(8);


INSERT INTO `smartgrades`.`professeur` (`numero_professeur`, `id_gitlab`, `id_user`) VALUES(30210001,"@sdupont", 7);
INSERT INTO `smartgrades`.`professeur` (`numero_professeur`, `id_gitlab`, `id_user`) VALUES(30210002,"@nathand", 6);
INSERT INTO `smartgrades`.`professeur` (`numero_professeur`, `id_gitlab`, `id_user`) VALUES(30210003,"@pierrecarret", 5);


INSERT INTO `smartgrades`.`etudiant`(`numero_etudiant`, `id_gitlab`, `tier_temps`, `cursus_postbac`, `statut`, `id_user`, `id_classe`) 
VALUES(20200001,'@seyller',1 ,"Ecole d'ingénieur", "Initial", 4, 1);

INSERT INTO `smartgrades`.`etudiant`(`numero_etudiant`, `id_gitlab`, `tier_temps`, `cursus_postbac`, `statut`, `id_user`, `id_classe`) 
VALUES(20200002,'@desousa',0,"Prépa", "Initial", 3, 1);

INSERT INTO `smartgrades`.`etudiant`(`numero_etudiant`, `id_gitlab`, `tier_temps`, `cursus_postbac`, `statut`, `id_user`, `id_classe`) 
VALUES(20200003,'@baraniak',1 ,"Licence", "Initial", 2, 1);

INSERT INTO `smartgrades`.`etudiant`(`numero_etudiant`, `id_gitlab`, `tier_temps`, `cursus_postbac`, `statut`, `id_user`, `id_classe`) 
VALUES(20200004,'@dallest',0 ,"Licence", "Initial", 1, 1);


INSERT INTO `smartgrades`.`etudiant_has_matiere`(`id_etudiant`, `id_matiere`) VALUES(1,1);
INSERT INTO `smartgrades`.`etudiant_has_matiere`(`id_etudiant`, `id_matiere`) VALUES(2,1);
INSERT INTO `smartgrades`.`etudiant_has_matiere`(`id_etudiant`, `id_matiere`) VALUES(3,2);
INSERT INTO `smartgrades`.`etudiant_has_matiere`(`id_etudiant`, `id_matiere`) VALUES(4,2);


INSERT INTO `smartgrades`.`matiere_has_professeur`(`id_matiere`, `id_professeur`) VALUES(2, 1);
INSERT INTO `smartgrades`.`matiere_has_professeur`(`id_matiere`, `id_professeur`) VALUES(1, 2);
INSERT INTO `smartgrades`.`matiere_has_professeur`(`id_matiere`, `id_professeur`) VALUES(3, 1);


INSERT INTO `smartgrades`.`classe_has_professeur` (`id_classe`, `id_professeur`) VALUES(1, 1);
INSERT INTO `smartgrades`.`classe_has_professeur` (`id_classe`, `id_professeur`) VALUES(1, 2);


INSERT INTO `smartgrades`.`examen`(`intitule`, `date_examen`, `type`) 
VALUES ('Examen de JAVA', '2022-05-21','CCF');

INSERT INTO `smartgrades`.`examen`(`intitule`, `date_examen`, `type`) 
VALUES ('MINI TEST PHP', '2022-02-11','CCI');

INSERT INTO `smartgrades`.`etudiant_has_examen`(`id_etudiant`, `id_examen`, `note`) 
VALUES (1,1,-1);

INSERT INTO `smartgrades`.`etudiant_has_examen`(`id_etudiant`, `id_examen`, `note`) 
VALUES (1,2,15);

INSERT INTO `smartgrades`.`etudiant_has_examen`(`id_etudiant`, `id_examen`, `note`) 
VALUES (2,1,-1);

INSERT INTO `smartgrades`.`etudiant_has_examen`(`id_etudiant`, `id_examen`, `note`) 
VALUES (2,2,10);


INSERT INTO `smartgrades`.`examen_has_matiere`(`id_examen`, `id_matiere`) 
VALUES (1,2); /*Examen de JAVA avec matière JAVA*/

INSERT INTO `smartgrades`.`examen_has_matiere`(`id_examen`, `id_matiere`) 
VALUES (2,1); /*MiniExamen de PHP avec matière PHP*/

INSERT INTO `smartgrades`.`examen_has_professeur`(`id_examen`, `id_professeur`)
VALUES(1,1); /*examen de JAVA avec prof id 1 => num prof => 30210001*/

INSERT INTO `smartgrades`.`examen_has_professeur`(`id_examen`, `id_professeur`)
VALUES(2,2);/*Mini examen de PHP avec prof id 2 => num prof => 30210002*/

INSERT INTO `smartgrades`.`question`(`contenu`, `commentaire`, `points`) VALUES("Date de création de PHP?", "un commenraire", 4);
INSERT INTO `smartgrades`.`question`(`contenu`, `commentaire`, `points`) VALUES("Date de création de JAVA?", "un commentaire", 4);

INSERT INTO `smartgrades`.`question_has_examen`(`id_question`, `id_examen`) 
VALUES(1,2); /*Date de création de PHP? dans l'examen MiniExamen de PHP ayant une valeur de 4 points*/
INSERT INTO `smartgrades`.`question_has_examen`(`id_question`, `id_examen`) 
VALUES(2,1); /*Date de création de JAVA? MiniExamen de PHP ayant une valeur de 4 points*/