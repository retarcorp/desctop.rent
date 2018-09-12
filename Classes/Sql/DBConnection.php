<?php

namespace Classes\Sql;

abstract class DBConnection {
    
    protected $connection = null;
    protected $statement = null;
    
    protected static $link = null;
    
    protected const DB_HOST = 'localhost';
    protected const DB_NAME = 'desktop.rent';
    protected const USER_NAME = 'root';
    protected const PASSWORD = 'retarcorp-dev-2018';
    
    private const ERRORS_LOGS_FILE_LOCATION = '/Classes/Sql/errors.log';
    
    abstract protected function __construct(
        string $host,
        string $dbname,
        string $userName,
        string $password
    );
    
    public static function getDrivers(): array{
        return \PDO::getAvailableDrivers();
    }
    
    abstract public static function getInstance(
        string $host = self::DB_HOST,
        string $dbname = self::DB_NAME,
        string $userName = self::USER_NAME,
        string $password = self::PASSWORD
    );
    
    private function getEqualsPlaceholders(array $columns){
        return array_map(function($col){
            return "$col = :$col";
        }, $columns);
    }
    
    private function addWhereCondition(string &$q, array $where){
        if( !empty($where) ){
            $equals = $this->getEqualsPlaceholders(array_keys($where));
            $q = "$q WHERE " . implode(' AND ', $equals);
        }
    }
    
    public function prepare(string $query){
        $this->statement = $this->connection->prepare($query);
    }
    
    public function insert(string $table, array $cols_vals){
        $this->prepareInsert($table, array_keys($cols_vals));
        $this->executeStatement($cols_vals);
    }
    
    public function prepareInsert(string $table, array $columns){
        $placeholders = array_map(function($col){
            return ":$col";
        }, $columns);
        
        $q = "INSERT INTO $table (" . implode(', ', $columns) . ")
            VALUES(" . implode(', ', $placeholders) . ")";
        
        $this->prepare($q);
    }
    
    public function update(string $table, array $cols_vals, array $where = []){
        $this->prepareUpdate($table, array_keys($cols_vals), $where);
        $this->executeStatement($cols_vals + $where);
    }
    
    public function prepareUpdate(string $table, array $columns, array $where = []){
        $equals = $this->getEqualsPlaceholders($columns);
        
        $q = "UPDATE $table SET " . implode(', ', $equals);
        $this->addWhereCondition($q, $where);
        
        $this->prepare($q);
    }
    
    public function delete(string $table, array $where = []){
        $this->prepareDelete($table, $where);
        $this->executeStatement($where);
    }
    
    public function prepareDelete(string $table, array $where = []){
        $q = "DELETE FROM $table";
        $this->addWhereCondition($q, $where);
        $this->prepare($q);
    }
    
    private function getStatementColumns(): array{
        if( !$this->statement->queryString ) {
            return [];
        }
        
        $parts = explode('(', $this->statement->queryString);
        $parts = explode(')', $parts[1]); // part with columns names
        $columns = explode(',', $parts[0]); // part with columns names
        
        return array_map(function($col){
            return trim($col);
        }, $columns);
    }
    
    public function execStmt(array $values){
        $columns = $this->getStatementColumns();
        
        $data = [];
        foreach($columns as $i => $column){
            $data[$column] = $values[$i];
        }
        
        $this->executeStatement($data);
    }
    
    // ['column' => value]
    public function executeStatement(array $data){
        try{
            $this->statement->execute($data);
        }catch(\PDOException $e) {
            $this->logError($e->getMessage());
        }
    }
    
    public function execute(string $query){
        try{
            return $this->connection->exec($query);
        }catch(\PDOException $e){
            $this->logError($e->getMessage());
        }
    }
    
    public function getAssoc(string $q): array{
        return $this->getByQuery($q, \PDO::FETCH_ASSOC);
    }
    
    public function getObj(string $q): array{
        return $this->getByQuery($q, \PDO::FETCH_OBJ);
    }
    
    public function getClass(string $q, string $className): array{
        return $this->getByQuery($q, \PDO::FETCH_CLASS, $className);
    }
    
    public function getByQuery(string $query, $mode = \PDO::FETCH_ASSOC, string $className = ''){
        try{
            $this->statement = $this->connection->query($query);
            
            if( $mode != \PDO::FETCH_CLASS ){
                $this->statement->setFetchMode($mode);
            }else{
                $this->statement->setFetchMode($mode, $className);
            }
            
            $results = [];
            while($row = $this->statement->fetch()) {  
                $results [] = $row;
            }
            return $results;
        }catch(\PDOException $e){
            $this->logError($e->getMessage());
        }
    }
    
    public function getRow($q){
        $data = $this->getAssoc($q);
        return empty($data) ? [] : $data[0];
    }
    
    public function getRowsAmountIn(string $table, string $where = ''){
        $q = "SELECT COUNT(*) amount FROM $table";
        $q .= $where ? " WHERE $where " : '';
        $data = $this->getRow($q);
        return (int)$data['amount'];
	}
    
    public function getInsertId(): int{
        return $this->connection->lastInsertId();
    }
    
    public function getAffectedRows(): int{
        return $this->statement->rowCount();
    }
    
    public function logError(string $message){
        $log = date("d.m.Y H:i:s") . ": " . $message."\n";
        file_put_contents(
            $_SERVER['DOCUMENT_ROOT'] . self::ERRORS_LOGS_FILE_LOCATION,
            $log,
            FILE_APPEND
        );
    }
    
    public function __destruct(){
        $this->connection = null;
    }
    
}