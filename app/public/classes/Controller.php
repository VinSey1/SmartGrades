<?php
    require_once ORM.DS.'API.php';
    abstract class Controller {
        abstract function showContent($infos);
    }
?>