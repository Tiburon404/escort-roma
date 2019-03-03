<?php
/**
 * Represent the Connection
 */

namespace escort;
use PDO;
use PDOException;

//require_once('../model/Logger.php');

class Connection {

    /**
     * Connection
     * @var type
     */
    private static $conn;

    /**
     * Connect to the database and return an instance of \PDO object
     * @return \PDO
     * @throws \Exception
     */
    public function connect() {

        // read parameters in the ini configuration file
        $params = parse_ini_file('../escortConfig.ini', true);
        $logger = new Logger('Connection');

        if ($params === false) {
            throw new Exception("Error reading database configuration file");
            $this->logger = error("Error reading database configuration file");
        }
        // connect to the postgresql database
        $conStr = sprintf("pgsql:host=%s;port=%d;user=%s;password=%s",
            $params['database']['host'],
            $params['database']['port'],
            $params['database']['user'],
            $params['database']['password']);


        $pdo = new PDO($conStr);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        //Impostazione dello schema da utilizzare
        $pdo->exec("SET search_path TO ".$params['database']['database']);

        return $pdo;
    }

    /**
     * return an instance of the Connection object
     * @return type
     */
    public static function get() {
        if (null === static::$conn) {
            static::$conn = new static();
        }

        return static::$conn;
    }
    //l'ho cambiato in public (era protected) perchè altrimenti non potevo creare un nuovo oggetto in salModel.php
    public function __construct() {

    }

    private function __clone() {

    }

    private function __wakeup() {

    }

}
