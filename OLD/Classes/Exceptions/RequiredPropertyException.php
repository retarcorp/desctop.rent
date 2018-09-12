<?php

namespace Classes\Exceptions;

use Classes\Exceptions\DesktopRentException;

class RequiredPropertyException extends DesktopRentException{
    
    public function __construct(){
        $args = func_get_args();
        parent::__construct("Поле(я) (" . implode(', ', $args) . ") должны присутсвовать и не должны быть пусты");
    }
    
}