<?php

namespace Classes\Models\Services;

use Classes\Utils\Sql;
use Classes\Utils\Log;
use Classes\Utils\DateUtil;
use Classes\Utils\Common;
use Classes\Exceptions\DesktopRentException;

class Service {
    
    public const TABLE_NAME = 'services';
    /*
        # id INT
        # name VARCHAR(128)
        # description VARCHAR(512)
        # price DECIMAL(10, 2)
        # duration INT
        # created DATETIME
    */
    
    public const USERS_SERVICES_TABLE = 'users_services';
    /*
        # id INT
        # user_id INT
        # service_id INT
        # added DATETIME
    */
    
    protected const PROPS_COLUMNS_INFO = [
        'name' => ['type' => 'str', 'get', 'set'],
        'description' => ['type' => 'str', 'get', 'set'],
        'price' => ['type' => 'float', 'get', 'set'],
        'duration' => ['type' => 'int', 'get', 'set'],
        'created' => ['type' => 'str', 'get', 'set']
    ];
    
    use \Classes\Traits\Entity;
    
    private $id;
    private $name;
    private $description;
    private $price;
    private $created;
    
    public function getValidatedData(array $data): array{
        $data['created'] = DateUtil::toRussianFormat($data['created']);
        return $data;
    }
    
}