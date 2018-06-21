<?php

namespace Classes\Models\Users;

use Classes\Utils\Sql;

use Classes\Models\Rdp\Rdp;
use Classes\Models\Users\ProfileData;

class User{
    
    const TABLE_NAME = "users";

    const AUTH_LOGGED_OUT = 0;
    const AUTH_PENDING = 3;
    const AUTH_DONE = 12;

    const STATUS_JUST_CREATED = 10;
    const STATUS_FILLED_PROFILE_DATA = 13;
    const STATUS_ASSIGNED_LICENSE = 14;
    const STATUS_SET_UP = 15;


    public $id, $status, $phone, $sms_code, $ssid, $registered_at, $last_login, $last_ip, $inn, $email;
    public $auth;
    # @TODO add field INN to user class and database, set to '' when creating user 
    
    public function __construct(int $id){
        $sql = Sql::getInstance();
        $r = $sql->getAssocArray("SELECT * FROM ".self::TABLE_NAME." WHERE id=$id");
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
        $this->inn = $r['inn']; //\
        $this->email = $r['email'];
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
        WHERE id={$this->id}");
    }

    public function getProfileData() : ProfileData {
        # @TODO: get ProfileData object for this user
        $profileData = new ProfileData($this->id); //\
        return $profileData; //\
    }

    public function hasRightsAtLeast(int $num){
        return $this->status*1 >= $num;
    }
}