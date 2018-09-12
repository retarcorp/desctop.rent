<?php

namespace Classes\Traits;

use Classes\Utils\Sql;
use Classes\Utils\Log;
use Classes\Utils\DateUtil;
use Classes\Utils\Common;
use Classes\Exceptions\DesktopRentException;
use Classes\Exceptions\UnEqualAmountException;

trait FactoryMethods {
    
    private function getObjects(
        string $class, 
        string $where = '',
        $limit = null,
        $offset = null,
        $sort = 'id',
        $sortDirection = 'desc'
    ): array{
        $sql = Sql::getInstance();
        
        $q = "SELECT id FROM " . $class::TABLE_NAME;
        
        $q .= $where ? " WHERE $where " : '';
        $q .= " ORDER BY $sort $sortDirection ";
        $q .= is_null($limit) ? '' : " LIMIT $limit ";
        $q .= is_null($offset) ? '' : " OFFSET $offset ";
        
        $data = $sql->getAssocArray($q);
        $sql->logError(__METHOD__);
        
        return $class::toInstances($data);
    }
    
    private function createObject(string $class, array $cols_values): Object{
        $sql = Sql::getInstance();
        $sql->insertTo(
            $class::TABLE_NAME,
            array_values($cols_values),
            array_keys($cols_values)
        );
        $sql->logError(__METHOD__);
        
        $id = $sql->getInsertId();
        return new $class($id);
    }
    
    private function deleteObject(Object $object, $where = []) {
        $sql = Sql::getInstance();
        $class = get_class($object);
        $params = empty($where) ? ['id' => $object->getId()] : $where;
        
        $sql->deleteFrom($class::TABLE_NAME, $params);
        $sql->logError(__METHOD__);
    }
    
}