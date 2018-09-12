<?php

namespace Classes\Traits;

trait ControllerActions {
    
    private function toPrimitive(array $objects, bool $fill = false): array{
        $primitive = [];
        foreach($objects as $object){
            if( $fill ){
                $object->setPropsFromDB();
            }
            $primitive [] = $object->toArray();
        }
        return $primitive;
    }
    
    private function getObjectById(string $class, int $id){
        return (new $class($id))->setPropsFromDB()->toArray();
    }
    
}