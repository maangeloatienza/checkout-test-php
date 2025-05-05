<?php

class Database
{
    private $host = 'sql207.infinityfree.com'; 
    private $dbName = 'if0_38910027_test_checkout';
    private $username = 'if0_38910027'; 
    private $password = 'asinsatubig';    
    private static $instance = null; 
    private $connection; 

    private function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbName}",
                $this->username,
                $this->password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}