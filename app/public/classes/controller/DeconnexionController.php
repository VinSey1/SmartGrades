<?php
    require_once CLASSES.DS.'Controller.php';
    class DeconnexionController extends Controller {
        function showContent($infos) {
            if (empty($_SESSION)) session_start();
            session_destroy();
            header('Location: accueil');
        }
    }
?>
