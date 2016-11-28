<?php

abstract class DbConn
{
    private $db_config;

    public function __construct($db_config)
    {
        $this->db_config = $db_config;
    }

    /**
     * Db connection
     * @return mysqli|null
     */
    protected function getConnection()
    {
        //Connection
        $conn = new mysqli($this->db_config['host'], $this->db_config['username'], $this->db_config['password'], $this->db_config['dbname']);
        $conn->set_charset("utf8");

        // Check connection, returns null if error happened
        if ($conn->connect_error) {
            return null;
        }

        return $conn;
    }
}