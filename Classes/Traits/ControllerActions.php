<?php

namespace Classes\Traits;

trait ControllerActions {
    
    private function toPrimitive(array $objects): array{
        $primitive = [];
        foreach($objects as $object){
            $primitive [] = $object->toArray();
        }
        return $primitive;
    }
    
    private function getObjectById(string $class, int $id){
        return (new $class($id))->toArray();
    }
    
}