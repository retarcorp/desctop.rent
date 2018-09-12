<?php

namespace Classes\Traits;

use Classes\Sql\Sql;
use Classes\Exceptions\TraitException;

trait FactoryMethods {
    
    private static function getObjects(
        string $class,
        string $where = '',
        $limit = null,
        $offset = null,
        $sort = 'id',
        $sortDirection = 'desc'
    ): array{
        $sql = self::getSqlInstance();
        
        $q = "SELECT * FROM " . $class::TABLE_NAME;
        
        $q .= $where ? " WHERE $where " : '';
        $q .= " ORDER BY $sort $sortDirection ";
        $q .= is_null($limit) ? '' : " LIMIT $limit ";
        $q .= is_null($offset) ? '' : " OFFSET $offset ";
        
        $data = $sql->getAssoc($q);
        return $class::toInstances($data);
    }
    
    private static function createObject(string $class, array $cols_values): Object{
        $sql = self::getSqlInstance();
        $sql->insert($class::TABLE_NAME, $cols_values);
        
        $id = $sql->getInsertId();
        return new $class($id);
    }
    
    private static function deleteObject(Object $object, $where = []) {
        $sql = self::getSqlInstance();
        $class = get_class($object);
        $params = empty($where) ? ['id' => $object->getId()] : $where;
        $sql->delete($class::TABLE_NAME, $params);
    }
    
}