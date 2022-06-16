SELECT * 
FROM Etudiant 
INNER JOIN User as u ON u.email = Etudiant.User_email; 

SELECT * 
FROM Etudiant as etu 
INNER JOIN Matiere_has_Etudiant as m ON m.Etudiant_idEtudiant = etu.idEtudiant 
INNER JOIN Matiere as mat ON mat.idMatiere = m.Matiere_idMatiere; 


/*--- get column value for enum ---*/
SELECT SUBSTRING(COLUMN_TYPE,5)
FROM information_schema.COLUMNS
WHERE TABLE_SCHEMA='smartgrades' 
    AND TABLE_NAME='User'
    AND COLUMN_NAME='role';