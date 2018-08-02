<?php

namespace Classes\Traits;

use Classes\Utils\Sql;
use Classes\Utils\Log;
use Classes\Utils\DateUtil;
use Classes\Utils\Common;
use Classes\Exceptions\DesktopRentException;
use Classes\Exceptions\UnEqualAmountException;
use Classes\Exceptions\SqlErrorException;

trait ObjectOperations {
    
    private function createObject(string $class, array $columns, array $values): ?Object{
        $sql = Sql::getInstance();
        
        $columnsAmount = count($columns);
        $valuesAmount = count($values);
        
        if( $columnsAmount != $valuesAmount ){
            throw new UnEqualAmountException(__METHOD__ . ": Amount of columns ($columnsAmount) must be equal to amount of values ($valuesAmount)");
        }
        
        $placeholders = [];
        
        foreach($values as $i => $arr){
            $placeholders [] = "'?'";
        }
        
        $q = "INSERT INTO " . $class::TABLE_NAME . "
            (" . implode(', ', $columns) . ")
            VALUES (" . implode(',', $placeholders) . ")";
        
        $q = $sql->execPrepared($q, $values);
        
        if( $e = $sql->getLastError() ){
            throw new SqlErrorException(__METHOD__ . ": $e");
        }
        
        $id = $sql->getInsertId();
        return new $class($id);
    }
    
    private function deleteObject(Object $object) {
        $sql = Sql::getInstance();
        $class = get_class($object);
        
        $q = "DELETE FROM " . $class::TABLE_NAME .
            " WHERE id = " . $object->getId();
            
        if( $e = $sql->getLastError() ){
            throw new SqlErrorException(__METHOD__ . ": $e");
        }
    }
    
}