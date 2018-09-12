<?php

namespace Classes\Models\Teams;

use Classes\Sql\Sql;
use Classes\Utils\DateUtil;
use Classes\Exceptions\DesktopRentException;

class Role {
    
    public const TABLE_NAME = '_roles';
    /*
        # id INT
        # title VARCHAR(64)
    */
    
    protected const PROPS_COLUMNS_INFO = [
        'title' => ['type' => 'str', 'get', 'set'],
    ];
    
    use \Classes\Traits\Entity;
    
    private $id;
    private $title;
    
    public const MASTER = 1;
    public const EMPLOYEE = 2;
    public const CANDIDATE = 3;
    
    public static function master(){
        return new Role(self::MASTER);
    }
    
    public static function employee(){
        return new Role(self::EMPLOYEE);
    }
    
    public static function candidate(){
        return new Role(self::CANDIDATE);
    }
    
}