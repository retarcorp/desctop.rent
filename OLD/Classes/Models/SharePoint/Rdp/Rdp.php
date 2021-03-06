<?php
namespace Classes\Models\SharePoint\Rdp;

use Classes\Utils\Sql;
use Classes\Exceptions\WrongIdException;
use Classes\Exceptions\NonExistingItemException;

class Rdp{
    
    const TABLE_NAME = "rdp_connections";
    
    public $id, $ip, $created_at, $due_to;
    
    public function __construct(int $id){
        if( $id <= 0 ){
            throw new WrongIdException("Wrong id $id");
        }
        
        $sql = Sql::getInstance(); 
        $r = $sql->getAssocArray("SELECT ip, created_at, due_to FROM ".self::TABLE_NAME." WHERE id=$id");
        $sql->logError(__METHOD__);
        
        if( empty($r) ){
            throw new NonExistingItemException("Нет такого rdp с id $id");
        }
        
        $r = $r[0];
        $this->id = $id;
        $this->ip = $r['ip'];
        $this->created_at = $r['created_at'];
        $this->due_to = $r['due_to'];

    }

    public function getContent(){
        $sql = Sql::getInstance();
        $id = $this->id;
        $r = $sql->getAssocArray("SELECT content FROM ".self::TABLE_NAME." WHERE id=$id");
        $sql->logError(__METHOD__);
        $r = $r[0];
        return $r['content'];
    }
    public function updateRdp() {
        $sql = Sql::getInstance();
        $sql->query("UPDATE ".self::TABLE_NAME." SET 
            ip='".mysqli_real_escape_string($sql->resource(),$this->ip)."', 
            
            created_at='{$this->created_at}', due_to='{$this->due_to}' WHERE id=$this->id");
        $sql->logError(__METHOD__);
    }

    public function updateContent(string $content){
        $sql = Sql::getInstance();
        $sql->query("UPDATE ".self::TABLE_NAME." SET 
            content='".mysqli_real_escape_string($sql->resource(),$content)."' WHERE id=$this->id");
        $sql->logError(__METHOD__);
    }

    public static function getRemoteIP(): string{
        return $_SERVER['REMOTE_ADDR'];
    }

    public function toArray(): array{
        return [
            'id' => $this->id,
            'ip' => $this->ip,
            'created_at' => $this->created_at,
            'due_to' => $this->due_to
        ];
    }
}