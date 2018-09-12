<?php

namespace Classes\Sql;

use Classes\Sql\DBConnection;

class Mysql extends DBConnection {
    
    protected function __construct(
        string $host,
        string $dbname,
        string $userName,
        string $password
    ){
        try{
            $dsn = "mysql:host=$host;dbname=$dbname";
            
            $this->connection = new \PDO($dsn, $userName, $password);
            $this->connection->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
            
            self::$link = $this;
        }catch(\PDOException $e) {
            $this->logError($e->getMessage());
        }
    }
    
    public static function getInstance(
        string $host = self::DB_HOST,
        string $dbname = self::DB_NAME,
        string $userName = self::USER_NAME,
        string $password = self::PASSWORD
    ){
        return is_null(self::$link) ? 
            new Mysql($host, $dbname, $userName, $password) : self::$link;
    }
    
}