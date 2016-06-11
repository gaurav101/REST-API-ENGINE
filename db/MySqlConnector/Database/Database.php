<?php
/**
 * Created by PhpStorm.
 * User: aeon
 * Date: 09/06/16
 * Time: 8:37 PM
 */

namespace MySqlConnector\Database;


class Database {

    private $_connection;
    private static $_instance;
    private $_host = HOST;
    private $_username = USERNAME;
    private $_password = PASSWORD;
    private $_database = DATABASE;
    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance() {

        if(!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    // Constructor
    private function __construct() {

        $this->_connection = new \mysqli($this->_host, $this->_username,
            $this->_password, $this->_database);

        // Error handling
        if(mysqli_connect_error()) {
            trigger_error("ERROR: " . mysqli_connect_error(),
                E_USER_ERROR);
            die();

        }

    }

    //prevent from cloning
    private function __clone() { }

    //prevent form unserializing

    private function __wakeup(){}

    // get the connection
    public function getConnection() {
        return $this->_connection;
    }
}