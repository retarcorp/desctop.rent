<?php

namespace Classes\Models\_1C;

use Classes\Sql\Sql;
use Classes\Utils\DateUtil;
use Classes\Exceptions\DesktopRentException;

class Configuration {
    
    public const TABLE_NAME = '_1c_db_configurations';
    /*
        # id INT
        # title VARCHAR(1024)
    */
    
    protected const PROPS_COLUMNS_INFO = [
        'title' => ['type' => 'str', 'get', 'set'],
    ];
    
    use \Classes\Traits\Entity;
    use \Classes\Traits\FactoryMethods;
    
    private $id;
    private $title;
    
    public static function getAll(): array{
        return self::getObjects(__CLASS__);
    }
    
}