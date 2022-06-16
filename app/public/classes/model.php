<?php
    require_once ORM.DS.'Query.php';
    require_once M_CLASSES.DS.'user.php';
    abstract class Model {
        // Attributs
        static protected $nomTable;
        static protected $clePrimaire;
        protected $attributs;
        // Constructeur
        function __construct($attributs = []) {
            if (array_values($attributs) !== $attributs)
                $this->attributs = $attributs;
            else {
                $attributsPrepares = [];
                foreach ($attributs as $attribut)
                    $attributsPrepares[$attribut] = null;
                $this->attributs = $attributsPrepares;
            }
        }
        // Méthodes
        function __get($nomAttribut) {
            return $this->attributs[$nomAttribut];
        }
        function __set($nomAttribut, $valeurAttribut) {
            $this->attributs[$nomAttribut] = $valeurAttribut;
        }
        function update() {
            // Vérification si la valeur pour la clé primaire a bien été renseignée
            $clePrimaire = static::$clePrimaire;
            if ($this->$clePrimaire !== null) {
                $query = Query::table(static::$nomTable);
                $query->where($clePrimaire, "=", $this->$clePrimaire);
                $valeursAModifier = [];
                foreach ($this->attributs as $cleAttribut => $attribut)
                    if ($cleAttribut !== $clePrimaire)
                        $valeursAModifier[$cleAttribut] = $attribut;
                return $query->update($valeursAModifier) > 0;
            }
        }
        function delete() {
            // Vérification si la valeur pour la clé primaire a bien été renseignée
            $clePrimaire = static::$clePrimaire;
            if ($this->$clePrimaire !== null) {
                $query = Query::table(static::$nomTable);
                $query->where($clePrimaire, "=", $this->$clePrimaire);
                return $query->delete() > 0;
            }
        }
        function insert() {
            $clePrimaire = static::$clePrimaire;
            if (!empty($this->attributs)) {
                $query = Query::table(static::$nomTable);
                $valeursNouvelleLigne = [];
                foreach ($this->attributs as $cleAttribut => $attribut)
                    if ($cleAttribut !== $clePrimaire)
                        $valeursNouvelleLigne[] = $attribut;
                $this->$clePrimaire = $query->insert($clePrimaire !== null, $valeursNouvelleLigne);
                return $this->$clePrimaire;
            }
        }
        static function all($colonnesASelectionner = []) {
            $query = Query::table(static::$nomTable);
            if (!empty($colonnesASelectionner)) {
                foreach ($colonnesASelectionner as $colonneASelectionner)
                    $query->select($colonneASelectionner);
                // Si la clé primaire n'a pas été sélectionnée je la sélectionne
                if (static::$clePrimaire != null && !in_array(static::$clePrimaire, $colonnesASelectionner))
                    $query->select(static::$clePrimaire);
            }
            $models = [];
            foreach ($query->get() as $model)
                $models[] = new static($model);
            return $models;
        }
        static function find($criteresRecherche, $colonnesASelectionner = []) {
            $query = Query::table(static::$nomTable);
            if (!empty($colonnesASelectionner)) {
                foreach ($colonnesASelectionner as $colonneASelectionner)
                    $query->select($colonneASelectionner);
                // Si la clé primaire n'a pas été sélectionnée je la sélectionne
                if (static::$clePrimaire != null && !in_array(static::$clePrimaire, $colonnesASelectionner))
                    $query->select(static::$clePrimaire);
            }
            if (is_int($criteresRecherche))
                $resultatQuery = $query->where(static::$clePrimaire, "=", $criteresRecherche)->get();
            else if (is_array($criteresRecherche)) {
                $rechercheAvancee = false;
                foreach ($criteresRecherche as $critereRecherche)
                    if (is_array($critereRecherche))
                        $rechercheAvancee = true;
                if (!$rechercheAvancee)
                    $resultatQuery = $query->where($criteresRecherche[0], $criteresRecherche[1], $criteresRecherche[2])->get();
                else {
                    foreach ($criteresRecherche as $critereRecherche)
                        $resultatQuery = $query->where($critereRecherche[0], $critereRecherche[1], $critereRecherche[2]);
                    $resultatQuery = $query->get();
                }
            }
            $models = [];
            foreach ($resultatQuery as $model)
                $models[] = new static($model);
            return $models;
        }
        static function first($criteresRecherche, $colonnesASelectionner = []) {
            return self::find($criteresRecherche, $colonnesASelectionner)[0];
        }
        function belongs_to($nomModelLie, $cleEtrangere) {
            require_once M_CLASSES.DS.$nomModelLie.'.php';
            return str_replace('_', '', $nomModelLie)::first($this->$cleEtrangere);
        }
        function has_many($nomModelLie, $cleEtrangere) {
            require_once M_CLASSES.DS.$nomModelLie.'.php';
            $clePrimaire = static::$clePrimaire;
            return str_replace('_', '', $nomModelLie)::find([$cleEtrangere, "=", $this->$clePrimaire]);
        }
        function belongs_to_many($nomModelLie, $nomModelPivot, $premiereCleEtrangere, $deuxiemeCleEtrangere) {
            require_once M_CLASSES.DS.$nomModelLie.'.php';
            require_once M_CLASSES.DS.$nomModelPivot.'.php';
            $clePrimaire = static::$clePrimaire;
            // Dans la table pivot la première clé étrangère doit être égale à la clé primaire de l'objet
            $criteresRecherche = array();
            foreach (str_replace('_', '', $nomModelPivot)::find([$premiereCleEtrangere, "=", $this->$clePrimaire], [$deuxiemeCleEtrangere]) as $correspondaceTrouvee)
                $criteresRecherche[] = $correspondaceTrouvee->$deuxiemeCleEtrangere;
            $modelsLies = array();
            foreach ($criteresRecherche as $critereRecherche)
                $modelsLies[] = str_replace('_', '', $nomModelLie)::first($critereRecherche);
            return $modelsLies;
        }
    }
?>
