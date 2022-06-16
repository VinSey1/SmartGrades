<?php
    class ConnectionFactory {
        // Attributs
        static private $pdo;
        // Méthodes
        static function makeConnection($conf, $recreate = false) {
            if (self::$pdo === null || $recreate == true) {
                $dsn = "mysql:host=".$conf["DB_HOST"].";dbname=".$conf["DB_NAME"].";charset=".$conf["DB_CHARSET"];
                $options = array(
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_STRINGIFY_FETCHES => false
                );
                try {
                    self::$pdo = new PDO($dsn, $conf["DB_USER"], $conf["DB_PASS"], $options);
                    return self::$pdo;
                } catch (PDOException $e) {
                    throw new PDOException($e->getMessage(), (int)$e->getCode());
                }
            }
        }
        static function getConnection() {
            return self::$pdo;
        }
    }
?>
