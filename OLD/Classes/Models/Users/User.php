<?php

namespace Classes\Models\Users;

use Classes\Utils\Sql;
use Classes\Utils\DateUtil;
use Classes\Models\Rdp\Rdp;
use Classes\Models\Users\ProfileData;
use Classes\Models\SharePoint\Licenses\License;
use Classes\Models\Finance\Transaction;
use Classes\Models\Finance\Order;
use Classes\Models\Finance\BankActionsWorker;
use Classes\Models\Services\Service;
use Classes\Exceptions\WrongIdException;
use Classes\Exceptions\NonExistingItemException;
use Classes\Exceptions\SqlErrorException;

/**
 * The User class is a sample class that holds a single
 * user instance.
 *
 * The constructor of the User class takes a Data Mapper which
 * handles the user persistence in the database. In this case,
 * we will provide a fake one.
 */

class User{
/**
 * The user's db table name. 
 * @var string
 */
    const TABLE_NAME = "users";

/**
 * When the user exits status. 
 * @var string
 */
    const AUTH_LOGGED_OUT = 0;
/**
 * When the user's autorization is in progress status. 
 * @var string
 */
    const AUTH_PENDING = 3;
/**
 * When the user autorized status. 
 * @var string
 */
    const AUTH_DONE = 12;

/**
 * User's creating is started status. 
 * @var string
 */
    const STATUS_JUST_CREATED = 10;
    /**
 * User's profile data is created status. 
 * @var string
 */
    const STATUS_FILLED_PROFILE_DATA = 13;
    /**
 * User got a license. 
 * @var string
 */
    const STATUS_ASSIGNED_LICENSE = 14;
        /**
 * User set up. 
 * @var string
 */
    const STATUS_SET_UP = 15;


        /**
 * User's feature when he is a INDIVIDUAL FACE. 
 * @var string
 */
    const INDIVIDUAL_FACE = 1;
            /**
 * User's feature when he is a LEGAL ENTITY. 
 * @var string
 */
    const LEGAL_ENTITY = 2;
    
    const ADMIN = 333;

    public $id, $status, $phone, $sms_code, $ssid, $registered_at, $last_login, $last_ip, $inn, $email, $feature;
    public $auth;
    
    /**
     * Constructor initialises the db-connection and gets all parameters of user.
     *
     * @param string void
     *
     * @return  void
     * @throws  NonExistingItemException
     * @todo    Check to make sure the username isn't already taken
     *
     * @since   2018-27-07
     * @author  Bruno Skvorc <bruno@skvorc.me>
     *
     * @edit    2018-27-07<br />
     *          RCorp Olex<br />
     *          Changed some essential
     *          functionality for the better<br/>
     *          #edit1
     */
    public function __construct(int $id){
        if( $id <= 0 ){
            throw new WrongIdException("Wrong id $id");
        }
        
        $sql = Sql::getInstance();
        $r = $sql->getAssocArray("SELECT * FROM ".self::TABLE_NAME." WHERE id=$id");
        $sql->logError(__METHOD__);
        
        if( empty($r) ){
            throw new NonExistingItemException("There is no such user $id");
        }
        
        $r = $r[0];
        
        $this->id = $r['id'];
        $this->auth = $r['auth'];
        $this->status = $r['status'];
        $this->phone = $r['phone'];
        $this->sms_code = $r['sms_code'];
        $this->ssid = $r['ssid'];
        $this->registered_at = $r['registered_at'];
        $this->last_login = $r['last_login'];
        $this->last_ip = $r['last_ip'];
        $this->inn = $r['inn']; 
        $this->email = $r['email'];
        $this->feature = $r['feature'];
    }
    /**
     * "Update" does a update user's parameters in db.
     *
     * @param string void
     *
     * @return  void
     * @throws  Sql log error
     * @todo    i don't know because this is TEST
     *
     * @since   2018-27-07
     * @author  Olix >
     *
     * @edit    2018-27-07<br />
     *          RCorp Olex<br />
     *          Changed some essential
     *          functionality for the better<br/>
     *          #edit1
     */
    public function update(){
        $sql = Sql::getInstance();
        
        $sql->query("UPDATE ".self::TABLE_NAME." SET 
            status={$this->status}
            ,auth={$this->auth}
            ,sms_code={$this->sms_code}
            ,email='{$this->email}'
            ,inn='{$this->inn}'
            ,ssid ='{$this->ssid}'
            ,last_login = '".date("Y-m-d H:i:s")."'
            ,last_ip='".$_SERVER['REMOTE_ADDR']."'
            ,feature={$this->feature}
        WHERE id={$this->id}");
        
        $sql->logError(__METHOD__);
    }
    
    public function isAdmin(): bool{
        return $this->feature == self::ADMIN;
    }
    
    public function getLicense(): ?License{
        $sql = Sql::getInstance();
        $q = "SELECT id FROM " . License::TABLE_NAME . "
            WHERE uid = {$this->id}";
            
        $data = $sql->getAssocArray($q);
        $sql->logError(__METHOD__);
        
        $id = @intval($data[0]['id']);
        return $id ? new License($id) : null;
    }

    public function getProfileData() : ProfileData {
        $profileData = new ProfileData($this->id);
        return $profileData;
    }

    public function hasRightsAtLeast(int $num){
        return $this->status*1 >= $num;
    }
    
    public function onCompanyDataApproved(){
        $this->status = $this->status < self::STATUS_FILLED_PROFILE_DATA ? self::STATUS_FILLED_PROFILE_DATA : $this->status;
        $this->update();
    }
    
    public function onLicenseAttached(){
        $this->status = $this->status < self::STATUS_ASSIGNED_LICENSE ? self::STATUS_ASSIGNED_LICENSE : $this->status;
        $this->update();
    }
    
    public function onLicenseDettached(){
        $this->status = self::STATUS_FILLED_PROFILE_DATA;
        $this->update();
    }
    
    private function getObjectsDataByQuery(string $q, int $amount = 0, int $step = 0): array{
        $q = $amount ? $q . " LIMIT $amount " : $q;
        $q = $step ? $q . " OFFSET $step " : $q;
        
        $sql = Sql::getInstance();
        $data = $sql->getAssocArray($q);
        
        if( $e = $sql->getLastError() ){
            throw new SqlErrorException(__METHOD__ . ": $e");
        }
        
        return $data;
    }
    
    public function getOrders(int $amount = 0, int $step = 0): array {
        $q = "SELECT id FROM " . Order::TABLE_NAME . "
            WHERE uid = {$this->id}
            ORDER BY id DESC";
        
        $data = $this->getObjectsDataByQuery($q, $amount, $step);
        return Order::toInstances($data);
    }
    
    public function getTransactions(int $amount = 0, int $step = 0): array{
        $orders = $this->getOrders($amount, $step);
        
        return array_map(function($order){
            $baw = new BankActionsWorker();
            $transaction = $baw->getTransactionForOrder($order);
            return $transaction;
        }, $orders);
    }
    
    public function getServices(int $amount = 0, int $step = 0): array{
        $q = "SELECT service_id AS id FROM " . Service::USERS_SERVICES_TABLE . "
            WHERE user_id = {$this->id}
            ORDER BY id DESC";
        
        $data = $this->getObjectsDataByQuery($q, $amount, $step);
        return Service::toInstances($data);
    }
    
    public function addService(Service $service){
        $sql = Sql::getInstance();
        
        $q = "INSERT INTO " . Service::USERS_SERVICES_TABLE . "
            (user_id, service_id, added)
            VALUES(?, ?, '?')";
        
        $sql->execPrepared($q, [$this->id, $service->id, DateUtil::toSqlFormat(time())]);
        if( $e = $sql->getLastError() ){
            throw new SqlErrorException(__METHOD__ . ": $e");
        }
    }
    
}