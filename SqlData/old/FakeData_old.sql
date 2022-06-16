/*Inserting fake users ==>Password = T0T0 (0=zeros)*/

INSERT INTO `smartgrades`.`user` VALUES("toto@gmail.com", 
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Etudiant",
                            "Dallest",
                            "Bryan",
                            "21");

INSERT INTO `smartgrades`.`user` VALUES("toto1@gmail.com", 
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Etudiant",
                            "Baraniak",
                            "David",
                            "24");

INSERT INTO `smartgrades`.`user` VALUES("toto3@gmail.com", 
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Etudiant",
                            "Desousa",
                            "Benoît",
                            "22");

INSERT INTO `smartgrades`.`user` VALUES("toto4@gmail.com", 
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Etudiant",
                            "Seyller",
                            "Vincent",
                            "75");

INSERT INTO `smartgrades`.`user` VALUES("toto5@gmail.com", 
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Professeur",
                            "Mustafic",
                            "Adnan",
                            "21");

INSERT INTO `smartgrades`.`user` VALUES("toto6@gmail.com", 
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Professeur",
                            "Dahy",
                            "Nathan",
                            "21");

INSERT INTO `smartgrades`.`user` VALUES("toto7@gmail.com", 
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Professeur",
                            "Cena",
                            "John",
                            "50");      

INSERT INTO `smartgrades`.`user` VALUES("toto8@gmail.com", 
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Administrateur",
                            "Deng",
                            "Xiao Ping",
                            "21"); 

INSERT INTO `smartgrades`.`user` VALUES("toto9@gmail.com",
                            "$2y$10$XmAapAYHoIPeTQRkrFjq/e.uKk12wH5rfd0l2KcWx.47Ban4hPY.C", 
                            "Administrateur",
                            "Skywalker",
                            "Anakin",
                            "21"); 


/*Inserting subjects*/

INSERT INTO `smartgrades`.`matiere` VALUES("PHP", "Matiere de PHP");
INSERT INTO `smartgrades`.`matiere` VALUES("JAVA", "Matiere de JAVA");
INSERT INTO `smartgrades`.`matiere` VALUES("MethdsAgles", "Matiere de méthodes Agile");

/*Inserting Promotions*/

INSERT INTO `smartgrades`.`classe` VALUES("IM2021", "INFO MOBILITE", "2021-2022");

/*Roles attribution*/
INSERT INTO `smartgrades`.`administrateur` VALUES("ADM1", "toto9@gmail.com");
INSERT INTO `smartgrades`.`administrateur` VALUES("ADM1", "toto8@gmail.com");


INSERT INTO `smartgrades`.`professeur` VALUES(3021001, "toto7@gmail.com");
INSERT INTO `smartgrades`.`professeur` VALUES(3021002, "toto6@gmail.com");
INSERT INTO `smartgrades`.`professeur` VALUES(3021003, "toto5@gmail.com");


INSERT INTO `smartgrades`.`etudiant` VALUES(2020001, "toto4@gmail.com", "IM2021");
INSERT INTO `smartgrades`.`etudiant` VALUES(2020002, "toto3@gmail.com", "IM2021");
INSERT INTO `smartgrades`.`etudiant` VALUES(2020003, "toto1@gmail.com", "IM2021");
INSERT INTO `smartgrades`.`etudiant` VALUES(2020004, "toto@gmail.com", "IM2021");


INSERT INTO `smartgrades`.`Matiere_has_Etudiant` VALUES("PHP", 2020001, "toto4@gmail.com", "IM2021");
INSERT INTO `smartgrades`.`Matiere_has_Etudiant` VALUES("PHP", 2020002, "toto3@gmail.com", "IM2021");
INSERT INTO `smartgrades`.`Matiere_has_Etudiant` VALUES("JAVA", 2020003, "toto1@gmail.com", "IM2021");
INSERT INTO `smartgrades`.`Matiere_has_Etudiant` VALUES("JAVA", 2020004, "toto@gmail.com", "IM2021");


INSERT INTO `smartgrades`.`Matiere_has_Professeur` VALUES("JAVA", 3021001, "toto7@gmail.com");
INSERT INTO `smartgrades`.`Matiere_has_Professeur` VALUES("PHP", 3021002, "toto6@gmail.com");

INSERT INTO `smartgrades`.`Classe_has_Professeur` VALUES("IM2021", 3021001, "toto7@gmail.com");
INSERT INTO `smartgrades`.`Classe_has_Professeur` VALUES("IM2021", 3021002, "toto6@gmail.com");