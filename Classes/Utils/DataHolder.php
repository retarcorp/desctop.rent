<?php

namespace Classes\Utils;

class DataHolder {
    
    /* 
        [
            'propName' => ['type' => 'str', 'val' => 'ABC'],
        ]
    */
    
    private $data = [];
    
    public function __construct(array $objData = []){
        $this->data = $objData;
    }
    
    public function getProperties(): array{
        return array_keys($this->data);
    }
    
    public function append($name, $value, $type = ''): self{
        if( $type ){
            $this->data[$name] = ['type' => $type, 'val' => $value];
        }else{
            if( !is_array($value) ){
                $this->data[$name] = [$value];
            }else{
                $this->data[$name] = $value;
            }
        }
        
        return $this;
    }
    
    public function remove($name): self{
        if( isset($this->data[$name]) ){
            unset($this->data[$name]);
        }
        return $this;
    }
    
    public function __get(string $prop){
        if( isset($this->data[$prop]['type']) ){
            $type = $this->data[$prop]['type'];
        }elseif( count($this->data[$prop]) > 1 ){ // if we have only value
            $type = $this->data[$prop][0];
        }else{
            $type = 'str';
        }
        
        if( isset($this->data[$prop]['val']) ){
            $value = $this->data[$prop]['val'];
        }elseif( isset($this->data[$prop]['value']) ){
            $value = $this->data[$prop]['value'];
        }else{
            $value = count($this->data[$prop]) > 1 ? $this->data[$prop][1] : $this->data[$prop][0];
        }
        
        return $this->getProtectedValue($type, $value);
    }
    
    private function getProtectedValue(string $type, $value){
        switch($type){
            
            case 'str':
            case 'string':
                return $this->getProtectedString($value);
                
            case 'int':
            case 'integer':
                return intval($value);
                
            case 'float':
            case 'double':
                return floatval($value);
            
            case 'obj':    
            case 'object':
                return $value;
            
            default:
                return $this->getProtectedString($value);;
        }
    }
    
    private function getProtectedString(string $str): string{
        return htmlspecialchars(trim($str));
    }
    
}