<?php

namespace Classes\Models\Finance;

use Classes\Utils\Sql;
use Classes\Utils\Log;
use Classes\Utils\DateUtil;
use Classes\Utils\Common;
use Classes\Exceptions\DesktopRentException;

class Transaction {
    
    public const TABLE_NAME = 'users_transactions';
    /*
        # id INT
        # sum DECIMAL
        # order_id INT
        # payment_way INT
        # status INT
    */
    
    protected const PROPS_COLUMNS_INFO = [
        'sum' => ['type' => 'float', 'get', 'set'],
        'order_id' => ['alias' => 'orderId', 'type' => 'int', 'get'],
        'payment_way' => ['alias' => 'payment', 'type' => 'int', 'get', 'set'],
        'status' => ['type' => 'int', 'get', 'set']
    ];
    
    use \Classes\Traits\Entity;
    
    private $id;
    private $sum;
    private $payment;
    private $status;
    private $orderId;
    
    public const STATUS_OPENED = 1;
    public const STATUS_DECLINED = 2;
    public const STATUS_PAID = 3;
    public const STATUS_RETURNED = 4;
    public const STATUS_ERORR = 5;
    
    public const PAYMENT_BY_SBERBANK = 11;
    
    public function setPaid(){
        $this->status = self::STATUS_PAID;
        $this->update();
    }
    
}