<?php

/**
 * This class is responsible for connection to the DB.
 * It is designed to be a singleton. It is possible to create only one instance of this class.
 */
class DB {

    // This object is an instance of this DB class
    private static $_instance = null;

    // This is the data which is used to connect to the DB
    private $conn;
    private $database = '127.0.0.1';
    private $port = 8889;
    private $dbName = 'js223fz';
    private $dbUserName = 'root';
    private $dbPassword = 'root';

    /**
     * Private constructor. It connect to the DB and
     * crates an instance of this class.
     */
    private function __construct() {

        // Connect to database
        $this->conn = new mysqli($this->database, $this->dbUserName, $this->dbPassword, $this->dbName, $this->port);

        // If couldn't connect to DB, kill the script
        if ($this->conn->connect_error) {
            die();
        }
    }

    /**
     * A static method which returns the instance of this DB class.
     * @param nothing
     * @return object of DB class
     */
    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    /**
     * Method which returns an array containing rows from the DB
     * @param nothing
     * @return array containing rows from the DB
     */
    public function getAllUsers() {

            $sql = "SELECT * FROM users"; // Select all entries
            $result = $this->conn->query($sql); // Prepare for analysis

            if ($result == false) { // Error with the DB. Kill the script
                die();
            }
            // If no error, continue

            $array = array();
            while ($row = $result->fetch_assoc()) { // Fetch row after row
                $array[] = $row;
            }
            return $array;
    }
}