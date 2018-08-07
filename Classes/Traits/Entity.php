<?php

namespace Classes\Traits;

use Classes\Utils\Sql;
use Classes\Utils\Log;
use Classes\Utils\DateUtil;
use Classes\Utils\Common;
use Classes\Exceptions\DesktopRentException;
use Classes\Exceptions\WrongIdException;
use Classes\Exceptions\NonExistingItemException;
use Classes\Exceptions\UnAvailablePropertyException;
use Classes\Exceptions\UndefinedMethodException;
use Classes\Exceptions\SqlErrorException;

trait Entity {
    
    # Requires:
    # 1) public const TABLE_NAME
    # 2) public const PROPS_COLUMNS_INFO = []
    /*
        [
            'uid' => ['type' => 'int', 'get'],
            'payment_way' => ['alias' => 'payment', 'type' => 'int', 'get', 'set']
        ]
    */
    
    public function __construct(int $id){
        if( $id <= 0 ){
            throw new WrongIdException(__METHOD__ . ": Wrong id $id, it must be positive");
        }
        
        $this->id = $id;
    }
    
    public function setPropsFromDB(): self{
        $columns = array_keys(self::PROPS_COLUMNS_INFO);
        $columns = implode(', ', $columns);
        
        $q = "SELECT $columns FROM "
            . self::TABLE_NAME . " WHERE id = {$this->id}";
        
        $sql = $sql = Sql::getInstance();
        $data = $sql->getAssocArray($q);
        
        if( $e = $sql->getLastError() ){
            throw new SqlErrorException(__METHOD__ . ": $e");
        }
        
        if( empty($data) ){
            throw new NonExistingItemException(__METHOD__ . ": There is no such item {$this->id} in DB");
        }
        
        $this->setProps($data[0]);
        return $this;
    }
    
    public function setProps(array $data): self{
        foreach(self::PROPS_COLUMNS_INFO as $column => $propInfo){
            $prop = isset($propInfo['alias']) ? $propInfo['alias'] : $column;
            
            if( isset($propInfo['type']) ){
                $func = $propInfo['type'] . 'val';
                $this->$prop = $func($data[$column]);
            }else{
                $this->$prop = $data[$column];
            }
            
        }
        return $this;
    }
    
    public static function toInstance(array $data): Object{
        $id = intval($data['id']);
        unset($data['id']);
        $class = self::class;
        $object = new $class($id);
        
        if( !empty($data) ){
            $object->setProps($data);
        }
        
        return $object;
    }
    
    public function update(): self{
        $subqs = [];
        $values = [];
        
        foreach(self::PROPS_COLUMNS_INFO as $column => $propInfo){            
            $prop = isset($propInfo['alias']) ? $propInfo['alias'] : $column;
            
            if( !($this->hasSetter($prop, 'set')) ){
                continue;
            }
            
            $subqs [] = "$column = '?'";
            $values [] = $this->$prop;
        }
        
        if( empty($subqs) && empty($values) ){
            return $this;
        }
        
        $sql = Sql::getInstance();
        $q = "UPDATE " . self::TABLE_NAME . "
            SET " . implode(', ', $subqs) . " WHERE id = ?";
        
        $values [] = $this->id;
        
        $sql->execPrepared($q , $values);
        
        if( $e = $sql->getLastError() ){
            throw new SqlErrorException(__METHOD__ . ": $e");
        }
        
        return $this;
    }
    
    private function isPropertyExists(string $prop): bool{
        foreach(self::PROPS_COLUMNS_INFO as $column => $info){
            if( $column == $prop || isset($info['alias']) && $info['alias'] == $prop){
                return true;
            }
        }
        return false;
    }
    
    public function hasGetter(string $prop): bool{
        return $this->hasKey($prop, 'get');
    }
    
    public function hasSetter(string $prop): bool{
        return $this->hasKey($prop, 'set');
    }
    
    private function hasKey(string $prop, string $key): bool{
        foreach(self::PROPS_COLUMNS_INFO as $column => $info){
            if( $column == $prop || isset($info['alias']) && $info['alias'] == $prop){
                if( in_array($key, $info) ){
                    return true;
                }
            }
        }
        return false;
    }
    
    public function __get(string $prop){
        if( $prop == 'id'){
            return $this->$prop;
        }
        
        if( $this->hasGetter($prop) ){
            return $this->$prop;
        }
        
        throw new UnAvailablePropertyException(__METHOD__ . ": Trying to get value of unavailable property $prop");
    }
    
    public function __set(string $prop, $value){
        if( $this->hasSetter($prop) ){
            $this->$prop = $value;
        }else{
            throw new UnAvailablePropertyException(__METHOD__ . ": Trying to set value $value of unavailable property $prop");
        }
    }
    
    public function toArray(): array{
        $arr = [];
        foreach($this as $prop => $value){
            if( $prop != 'sql' ){
                $arr [$prop] = $value;
            }
        }
        
        $method = "getValidatedData";
        if( method_exists($this, $method) ){
            $arr = $this->$method($arr);
        }
        
        return $arr;
    }
    
    public function getId(): int{
        return $this->id;
    }
    
    public function __call(string $method, array $args){
        if( strpos($method, 'set') !== false ){
            
            $prop = strtolower(substr($method, strlen('set'), 1)) 
                . substr($method, strlen('set') + 1);
            $this->$prop = $args[0];
            
        }elseif( strpos($method, 'get') !== false ){
            
            $prop = strtolower(substr($method, strlen('set'), 1)) 
                . substr($method, strlen('set') + 1);
            return $this->$prop;
            
        }else{
            throw new UndefinedMethodException(__METHOD__ . ": Undefined method $method");
        }
    }
    
    public static function toInstances(array $data): array{
        return array_map(function($e){
            return self::toInstance($e);
        }, $data);
    }
    
    public function __toString(): string{
        return array_reduce($this, function($carry, $curr){
            $carry .= serialize($curr);
        }, '');
    }
    
    public static function getInfo(): array{
        return self::PROPS_COLUMNS_INFO;
    }
    
}