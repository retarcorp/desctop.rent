<?php

namespace Classes\Models\SharePoint\Licenses;

use Classes\Utils\Sql;
use Classes\Models\SharePoint\Rdp\Rdp;
use Classes\Models\SharePoint\Rdp\RdpConnections;
use Classes\Models\Users\User;
use Classes\Exceptions\NonExistingItemException;
use Classes\Exceptions\WrongIdException;

class License{

    const TABLE_NAME = "sp_licenses";

    private $id, $login, $password, $rdp, $uid;
    
    public function __construct(int $id) {
        if( $id <= 0 ){
            throw new WrongIdException("Wrong id $id");
        }
        
        $sql = Sql::getInstance();
        $r = $sql->getAssocArray("SELECT * FROM ".self::TABLE_NAME." WHERE id=$id");
        $this->sql->logError(__METHOD__);
        $this->id = $id;
        
        if( empty($r) ){
            throw new NonExistingItemException("Нет такой Лицензии с id $id");
        }
        
        $r = $r[0];
        $this->login = $r['login'];
        $this->password = $r['pw'];
        $this->rdp = $r['rdp'];
        $this->uid = $r['uid'];
    }

    public function updateLicense() {
        $sql = Sql::getInstance();
        $sql->query("UPDATE ".self::TABLE_NAME." SET 
            login='".mysqli_real_escape_string($sql->resource(),$this->login)."', 
            pw='".mysqli_real_escape_string($sql->resource(),$this->password)."',
            uid='{$this->uid}' WHERE id={$this->id}");
        $this->sql->logError(__METHOD__);
    }

    public function getId() {
        return $this->id;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getLogin() {
        return $this->login;
    }
    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setUid($uid) {
        $this->uid = $uid;
    }
    public function getUid() {
        return $this->uid;
    }

    public function getRdp(): Rdp{
        return new Rdp($this->rdp);
    }
    
    public static function getHash(string $str): string{
        return md5($str);
    }
    
    public function getOwner(): User{
        return new User($this->uid);
    }

    public function toArray(): array{
        return [
            'id' => $this->id,
            'login' => $this->login,
            'rdp' => $this->rdp,
            'uid' => $this->uid
        ];
    }

}