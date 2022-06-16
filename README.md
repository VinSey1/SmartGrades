# SmartGrades
Copie GitHub du projet https://gitlab.com/VinSey1/SmartGrades
## Nécessités avant de démarrer le projet
1. Éditer le fichier *docker/mysql.env* avec les mots de passe de votre choix
2. Éditer le fichier *app/public/orm/conf/pdo.conf* avec le mot de passe renseigné dans l'étape d'avant
## Démarrage du projet
1. Aller dans le dossier `docker`
2. Exécuter tout simplement `docker-compose up` ou `docker-compose up -d` pour pouvoir récupérer le terminal une fois le projet a démarré :)
## Initialiser la base de données
1. Naviguer sur *http://localhost:3001* (Adminer) ou *http://localhost:3002* (phpMyAdmin) et renseigner les informations de connexion telles que définies dans *docker/mysql.env*
2. Voir la partie *Installation* dans le rapport accessible dans le dossier `doc`
## Template de CSV
Le template de CSV est disponible dans le dossier `misc` sous le nom de `TEST_SMARTGRADES.csv`
## Ouvrir le projet
1. Naviguer sur *http://localhost:3000/index.php*

