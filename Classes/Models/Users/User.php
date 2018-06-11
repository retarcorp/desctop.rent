<?php

namespace Classes\Models\Users;

use Classes\Utils\Sql;

class User{
    
    const TABLE_NAME = "users";
    const STATUS_PENDING_AUTH = 3;
    const STATUS_AUTHORIZED = 12;

    public $id, $status, $phone, $sms_code, $ssid, $registered_at, $last_login, $last_ip;

    public function __construct(int $id){
        $sql = Sql::getInstance();
        $r = $sql->getAssocArray("SELECT * FROM ".self::TABLE_NAME." WHERE id=$id");
        $r = $r[0];

        $this->id = $r['id'];
        $this->status = $r['status'];
        $this->phone = $r['phone'];
        $this->sms_code = $r['sms_code'];
        $this->ssid = $r['ssid'];
        $this->registered_at = $r['registered_at'];
        $this->last_login = $r['last_login'];
        $this->last_ip = $r['last_ip'];
    }

    public function update(){
        $sql = Sql::getInstance();
        $sql->query("UPDATE ".self::TABLE_NAME." SET status={$this->status}
            , sms_code={$this->sms_code}
            ,ssid ='{$this->ssid}'
            ,last_login = '".date("Y-m-d H:i:s")."'
            ,last_ip='".$_SERVER['REMOTE_ADDR']."'
            
        WHERE id={$this->id}");
    }

}