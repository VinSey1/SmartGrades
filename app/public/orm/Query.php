<?php
    require_once ORM.DS.'ConnectionFactory.php';
    class Query {
        // Attributs
        private $nomTable;
        private $selects = [];
        private $wheres = [];
        // Constructeur
        function __construct($nomTable) {
            $this->nomTable = $nomTable;
        }
        // Méthodes
        static function table($nomTable) {
            return new self($nomTable);
        }
        function select($nomsColonnes) {
            $this->selects[] = $nomsColonnes;
            return $this;
        }
        function where($nomColonne, $comparateur, $valeurAComparer) {
            $this->wheres[] = [$nomColonne, $comparateur, $valeurAComparer];
            return $this;
        }
        function get() {
            $requete = "SELECT ";
            if (count($this->selects) > 0)
                foreach ($this->selects as $cleSelect => $select) {
                    $requete .= $select;
                    if ($cleSelect != count($this->selects)-1)
                        $requete .= ", ";
                }
            else
                $requete .= "*";
            $requete .= " FROM ".$this->nomTable;
            if (count($this->wheres) > 0) {
                $requete .= " WHERE ";
                $valeursAComparer = [];
                foreach ($this->wheres as $cleWhere => $where) {
                    $requete .= $where[0]." ".$where[1]." ?";
                    $valeursAComparer[] = $where[2];
                    if ($cleWhere != count($this->wheres)-1)
                        $requete .= " and ";
                }
                $pdo = ConnectionFactory::getConnection();
                $stmt = $pdo->prepare($requete);
                $stmt->execute($valeursAComparer);
                $lignes = array();
                while ($ligne = $stmt->fetch())
                    $lignes[] = $ligne;
                return $lignes;
            } else {
                $pdo = ConnectionFactory::getConnection();
                $stmt = $pdo->query($requete);
                $lignes = array();
                while ($ligne = $stmt->fetch())
                    $lignes[] = $ligne;
                return $lignes;
            }
        }
        function insert($autoIncrement, $valeursNouvelleLigne) {
            $requete = "INSERT INTO ".$this->nomTable." VALUES (";
            if ($autoIncrement)
                $requete .= "NULL, ";
            foreach ($valeursNouvelleLigne as $cleValeurNouvelleLigne => $valeurNouvelleLigne) {
                if ($valeurNouvelleLigne === null)
                    $requete .= "DEFAULT";
                else
                    $requete .= "?";
                if ($cleValeurNouvelleLigne != count($valeursNouvelleLigne)-1)
                    $requete .= ", ";
            }    
            // Il faut supprimer les valeurs pour lesquelles on a pas mis des '?'
            $valeursNouvelleLigne = array_filter($valeursNouvelleLigne, function($valeurATester) {
                return $valeurATester !== null;
            });
            // Réindexation (sinon PDO n'aimera pas)
            $valeursNouvelleLigneReindexees = array_values($valeursNouvelleLigne);
            $requete .= ")";
            $pdo = ConnectionFactory::getConnection();
            $stmt = $pdo->prepare($requete);
            $stmt->execute($valeursNouvelleLigneReindexees);
            if ($pdo->lastInsertId() != 0)
                return $pdo->lastInsertId();
            else
                return $stmt->rowCount();
        }
        function delete() {
            $requete = "DELETE FROM ".$this->nomTable;
            if (count($this->wheres) > 0) {
                $requete .= " WHERE ";
                $valeursAComparer = [];
                foreach ($this->wheres as $cleWhere => $where) {
                    $requete .= $where[0]." ".$where[1]." ?";
                    $valeursAComparer[] = $where[2];
                    if ($cleWhere != count($this->wheres)-1)
                        $requete .= " and ";
                }
                $pdo = ConnectionFactory::getConnection();
                $stmt = $pdo->prepare($requete);
                $stmt->execute($valeursAComparer);
                return $stmt->rowCount();
            }
        }
        function update($valeursAModifier) {
            $requete = "UPDATE ".$this->nomTable." SET ";
            $derniereCleValeurAModifier = array_key_last($valeursAModifier);
            foreach ($valeursAModifier as $cleValeurAModifier => $valeurAModifier) {
                if ($valeurAModifier === null)
                    $requete .= $cleValeurAModifier." = DEFAULT";
                else
                    $requete .= $cleValeurAModifier." = ?";
                if ($cleValeurAModifier != $derniereCleValeurAModifier)
                    $requete .= ", ";
            }
            // Il faut supprimer les valeurs pour lesquelles on a pas mis des '?'
            $valeursAModifier = array_filter($valeursAModifier, function($valeurATester) {
                return $valeurATester !== null;
            });
            if (count($this->wheres) > 0) {
                $requete .= " WHERE ";
                // Rajout de wheres et réindexation (sinon PDO n'aimera pas)
                $valeursAComparer = array_values($valeursAModifier);
                foreach ($this->wheres as $cleWhere => $where) {
                    $requete .= $where[0]." ".$where[1]." ?";
                    $valeursAComparer[] = $where[2];
                    if ($cleWhere != count($this->wheres)-1)
                        $requete .= " and ";
                }
                $pdo = ConnectionFactory::getConnection();
                $stmt = $pdo->prepare($requete);
                $stmt->execute($valeursAComparer);
                return $stmt->rowCount();
            }
        }
    }
?>
