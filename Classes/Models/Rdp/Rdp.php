<?php
namespace Classes\Models\Rdp;

use Classes\Utils\Sql;

class Rdp{
    const TABLE_NAME = "rdp_connections";
    public $id, $ip, $created_at, $due_to, $uid ;
    public function __construct(int $id){
        $sql = Sql::getInstance(); 
        $r = $sql->getAssocArray("SELECT ip, created_at, due_to, uid FROM ".self::TABLE_NAME." WHERE id=$id");
        $r = $r[0];
        $this->id = $id;
        $this->ip = $r['ip'];
        $this->created_at = $r['created_at'];
        $this->due_to = $r['due_to'];
        $this->uid = $r['uid'];
    }

    public function getContent(){
        $sql = Sql::getInstance();
        $id = $this->id;
        $r = $sql->getAssocArray("SELECT content FROM ".self::TABLE_NAME." WHERE id=$id");
        $r = $r[0];
        return $r['content'];
    }
}