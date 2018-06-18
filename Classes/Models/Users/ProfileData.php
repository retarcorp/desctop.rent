<?php

namespace Classes\Models\Users;

use Classes\Utils\Sql;

class ProfileData {
    
    const TABLE_NAME = "profile_data";
    static $fields = [
            0 => "Название компании"
            ,1 => "Регион"
            ,2 => "Название банка"
            ,3 => "КПП"
            ,4 => "БИК"
            ,5 => "Расчетный счет"
        ];
        
    private $data = [];
    public function __construct(int $uid){
        # @TODO get from database profile data object and fill fields
    }
    
    public function update(){
        # @TODO update in db all the fields for 
    }

}