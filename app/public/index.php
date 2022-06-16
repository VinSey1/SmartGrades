<?php
    require_once 'defines.php';
    require_once ORM.DS.'ConnectionFactory.php';
    require_once CLASSES.DS.'Routeur.php';
    // Initialisation de la connexion à la BDD
    $conf = parse_ini_file(ORM.DS.'conf/pdo.conf');
    ConnectionFactory::makeConnection($conf);
    // Routeur
    Routeur::getPage(explode('/', $_SERVER['REQUEST_URI']));
?>