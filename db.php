<?php
/**
 * Opens a new connection to database
 */
class Database
{
    private static $instance = null;
    private $conn;
    private $server;
    private $dbname;
    private $username;
    private $password;

    private function __construct()
    {
        $this->server = "localhost";
        $this->dbname = "mindarc_assessment";
        $this->username = "username";
        $this->password = "password";
        $this->conn = new mysqli($this->server, $this->username, $this->password, $this->dbname);
    }

    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function connect()
    {
        return $this->conn;
    }
}