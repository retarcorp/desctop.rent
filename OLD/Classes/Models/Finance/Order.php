<?php

namespace Classes\Models\Finance;

use Classes\Utils\Sql;
use Classes\Utils\Log;
use Classes\Utils\DateUtil;
use Classes\Utils\Common;
use Classes\Exceptions\DesktopRentException;
use Classes\Exceptions\SqlErrorException;

class Order {
    
    public const TABLE_NAME = 'users_orders';
    /*
        # id INT
        # uid INT
        # created DATETIME
        # bank_order_id VARCHAR(128)
        # redirect_url VARCHAR(512)
    */
    
    public const ERRORS_TABLE = 'orders_errors';
    
    protected const PROPS_COLUMNS_INFO = [
        'uid' => ['type' => 'int', 'get'],
        'created' => ['type' => 'str', 'get'],
        'bank_order_id' => ['alias'=>'bankOrderId', 'type' => 'str', 'get'],
        'redirect_url' => ['alias' => 'redirect', 'type' => 'str', 'get']
    ];
    
    use \Classes\Traits\Entity;
    
    private $id;
    private $uid;
    private $created;
    private $bankOrderId;
    private $redirect;
    
    public function getValidatedData(array $data): array{
        $data['created'] = DateUtil::toRussianFormat($data['created']);
        return $data;
    }
    
    public function addError(int $code, string $message){
        $sql = Sql::getInstance();
        $q = "INSERT INTO " . self::ERRORS_TABLE . "
            (order_id, error_code, error_message)
            VALUES(?, ?, '?')";
        
        $sql->execPrepared($q, [$this->id, $code, $message]);
        
        if( $e = $sql->getLastError() ){
            throw new SqlErrorException(__METHOD__ . ": $e");
        }
    }
}
