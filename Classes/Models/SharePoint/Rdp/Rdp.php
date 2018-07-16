<?php
namespace Classes\Models\SharePoint\Rdp;

use Classes\Utils\Sql;

class Rdp{
    
    const TABLE_NAME = "rdp_connections";
    
    public $id, $ip, $created_at, $due_to;
    
    public function __construct(int $id){
        $sql = Sql::getInstance(); 
        $r = $sql->getAssocArray("SELECT ip, created_at, due_to FROM ".self::TABLE_NAME." WHERE id=$id");
        
        if( empty($r) ){
            throw new \Exception("Нет такого RDP элемета с id $id");
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
        $r = $r[0];
        return $r['content'];
    }
    public function updateRdp() {
        $sql = Sql::getInstance();
        $sql->query("UPDATE ".self::TABLE_NAME." SET 
            ip='".mysqli_real_escape_string($sql->resource(),$this->ip)."', 
            
            created_at='{$this->created_at}', due_to='{$this->due_to}' WHERE id=$this->id");
        print_r($sql->getLastError());
    }

    public function updateContent(string $content){
        $sql = Sql::getInstance();
        $sql->query("UPDATE ".self::TABLE_NAME." SET 
            content='".mysqli_real_escape_string($sql->resource(),$content)."' WHERE id=$this->id");
        print_r($sql->getLastError());
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
        // // $arr = [];
        // foreach($this as $prop => $value){
        //     $arr[$prop] = $value;
        // }
        // return $arr;
    }
}