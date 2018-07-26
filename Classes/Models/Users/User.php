<?php

namespace Classes\Models\Users;

use Classes\Utils\Sql;

use Classes\Models\Rdp\Rdp;
use Classes\Models\Users\ProfileData;
use Classes\Models\SharePoint\Licenses\License;
use Classes\Models\Finance\Transaction;
use Classes\Exceptions\WrongIdException;
use Classes\Exceptions\NonExistingItemException;

class User{
    
    const TABLE_NAME = "users";

    const AUTH_LOGGED_OUT = 0;
    const AUTH_PENDING = 3;
    const AUTH_DONE = 12;

    const STATUS_JUST_CREATED = 10;
    const STATUS_FILLED_PROFILE_DATA = 13;
    const STATUS_ASSIGNED_LICENSE = 14;
    const STATUS_SET_UP = 15;

    const INDIVIDUAL_FACE = 1;
    const LEGAL_ENTITY = 2;

    public $id, $status, $phone, $sms_code, $ssid, $registered_at, $last_login, $last_ip, $inn, $email, $feature;
    public $auth;
    
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
    
    public function getTransactions(int $amount = 0, int $step = 0): array{
        $q = "SELECT * FROM " . Transaction::TABLE_NAME . "
            WHERE uid = {$this->id}
            ORDER BY id DESC";
        
        $q = $amount ? $q . " LIMIT $amount " : $q;
        $q = $amount ? $q . " OFFSET $step " : $q;
        
        $sql = Sql::getInstance();
        $data = $sql->getAssocArray($q);
        $sql->logError(__METHOD__);
        return Transaction::toInstances($data);
    }
    
}