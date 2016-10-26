<?php

class Model extends DatabaseConfig
{
    private $_connection;
    private static $_instance; //The single instance

    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance()
    {
        if (!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    // Constructor
    protected function __construct()
    {
        $this->_connection = new \mysqli($this->_host, $this->_username, $this->_password, $this->_database);
        // Error handling
        if (mysqli_connect_error()) {
            trigger_error(
                "Failed to conencto to MySQL: " . mysql_connect_error(),
                E_USER_ERROR
            );
        }
        $this->_connection->set_charset("UTF8");
    }

    // Magic method clone is empty to prevent duplication of connection
    private function __clone()
    {
    }

    // Get mysqli connection
    public function getConnection()
    {
        return $this->_connection;
    }

    public static function prepare($query)
    {
        return self::getInstance()->getConnection()->prepare($query);
    }

    public static function query($query)
    {
        return self::getInstance()->getConnection()->query($query);
    }
    protected function toStdClass(): stdClass
    {
        return new stdClass();
    }
    protected function makeValuesReferenced($arr)
    {
        $refs = array();
        foreach ($arr as $key => $value) {
            $refs[$key] = &$arr[$key];
        }
        return $refs;
    }
}
