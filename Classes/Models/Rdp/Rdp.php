<?php
namespace Classes\Models\Rdp;

use Classes\Utils\Sql;

class Rdp{

    public $id, $ip, $uid;
    public function __construct(int $id){
        $sql = Sql::getInstance();
        # @TODO fill this rdp from database by given id
    }

    public function getContent(){
        # @TODO get text contents of this rdp from database
    }
}