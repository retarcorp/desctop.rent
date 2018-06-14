<?php
namespace Classes\Models\Rdp;

use Classes\Utils\Sql;

class Rdp{
    public $id, $ip, $created_at, $due_to, $uid ;
    private $content; 
    public function __construct(int $id){
        $sql = Sql::getInstance(); 
        # @TODO fill this rdp from database by given id
        $r = $sql->getAssocArray("SELECT id, ip, created_at, due_to, uid, FROM rdp_connections WHERE id=$id"); //\\
        $r = $r[0];
        $this->id = $r['id'];
        $this->ip = $r['ip'];
        $this->uid = $r['uid'];
        $this->created_at = $r['created_at'];
        $this->due_to = $r['due_to'];
    }

    public function getContent(){
        # @TODO get text contents of this rdp from database
        $r = $sql->getAssocArray("SELECT content FROM rdp_connections WHERE id=$id");
        $r = $r[0];
        $this->content = $r['content'];
        return $this->content; 
    }
}