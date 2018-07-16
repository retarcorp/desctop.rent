<?php

namespace Classes\Models\SharePoint\Licenses;

use Classes\Utils\Sql;
use Classes\Models\SharePoint\Rdp\Rdp;
use Classes\Models\SharePoint\Rdp\RdpConnections;

class License{

    const TABLE_NAME = "sp_licenses";

    # @TODO make private and getters/setters + update method

    // public $id, $login, $password, $rdp, $uid;

    private $id, $login, $password, $rdp, $uid;
    
    public function __construct(int $id) {
        $sql = Sql::getInstance();
        $r = $sql->getAssocArray("SELECT * FROM ".self::TABLE_NAME." WHERE id=$id");
        $this->id = $id;
        if( empty($r) ){
            throw new \Exception("Нет такой Лицензии с id $id");
        }

        $r = $r[0];
        $this->login = $r['login'];
        $this->password = $r['pw'];
        $this->rdp = $r['rdp'];
        $this->uid = $r['uid'];
    }

    public function updateLicense() { //\
        $sql = Sql::getInstance();
        $sql->query("UPDATE ".self::TABLE_NAME." SET 
            login='".mysqli_real_escape_string($sql->resource(),$this->login)."', 
            pw='".mysqli_real_escape_string($sql->resource(),$this->password)."',
            uid='{$this->uid}' WHERE id={$this->id}");
        print_r($sql->getLastError());
    }

    public function getId() { //\
        return $this->id;
    }

    public function setLogin($login) { //\
        $this->login = $login;
    }

    public function getLogin() { //\
        return $this->login;
    }
    public function setPassword($password) { //\
        $this->password = $password;
    }

    public function getPassword() { //\
        return $this->password;
    }

    /*public function getRdpId() { //\
        return $this->rdp;
    }*/

    /*public function setRdpId($rdp) { //\
        $this->rdp = $rdp;
    }*/

    public function setUid($uid) { //\
        $this->uid = $uid;
    }
    public function getUid() { //\
        return $this->uid;
    }

    public function getRdp(): Rdp{
        return new Rdp($this->rdp);
    }
    
    public static function getHash(string $str): string{
        return md5($str);
    }

    public function toArray(): array{
        return [
            'id' => $this->id,
            'login' => $this->login,
            'rdp' => $this->rdp,
            'uid' => $this->uid
            //,'password' => str_pad("",strlen($this->password),"*") //пароль не нужно передавать
        ];
        // // $arr = [];
        // foreach($this as $prop => $value){
        //     $arr[$prop] = $value;
        // }
        // return $arr;
    }

}