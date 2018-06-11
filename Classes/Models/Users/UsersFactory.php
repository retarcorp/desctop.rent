<?php

namespace Classes\Models\Users;

use Classes\Utils\Sql;

class UsersFactory{

    private $sql;
    public function __construct(){
        $this->sql = new Sql();
    }

}