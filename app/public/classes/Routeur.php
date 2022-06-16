<?php
    class Routeur {
        static function getPage($url) {
            $cible = null;
            $infos = array();
            foreach ($url as $composantUrl) {
                if (strpos($composantUrl, '?') !== false) break;
                if (is_numeric($composantUrl)) {
                    array_push($infos, intval($composantUrl));
                } else if ($composantUrl != '') $cible = $composantUrl;
            }
            $cible = str_replace('-', '', ucwords($cible, '-'));
            $cible = ucfirst($cible).'Controller';
            if(!FILE_EXISTS(C_CLASSES.DS.$cible.'.php')) {
                $cible = 'AccueilController';
            }
            require_once C_CLASSES.DS.$cible.'.php';
            $controlleur = new $cible();
            $controlleur->showContent($infos);
        }
    }
?>