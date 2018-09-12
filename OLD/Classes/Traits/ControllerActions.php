<?php

namespace Classes\Traits;

trait ControllerActions {
    
    private function serializeObjects(array $objects, bool $fill = false): array{
        $serialized = [];
        foreach($objects as $object){
            if( $fill ){
                $object->setPropsFromDB();
            }
            $serialized [] = $object->toArray();
        }
        return $serialized;
    }
    
}