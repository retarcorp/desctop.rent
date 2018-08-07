<?php

namespace Classes\Models\Users;

use Classes\Utils\Sql;
use Classes\Models\Users\User;
use Classes\Utils\Sms;
use Classes\Models\Users\ProfileData;
use Classes\Exceptions\DesktopRentException;

class UsersFactory{
    
    private $sql;
    
    public function __construct(){
        $this->sql = new Sql();
    }

    public function isPhoneValid($phone){
        preg_match("/.*/",$phone,$matches);
        return count($matches) !== 0;
    }

    public function getCurrentUser(){
        if(isset($_COOKIE[self::COOKIE_NAME])){
            $ssid = $_COOKIE[self::COOKIE_NAME];
        }else{
            return null;
        }
        
        $r = $this->sql->getArray("SELECT id FROM ".User::TABLE_NAME." WHERE ssid='$ssid' AND auth=".User::AUTH_DONE);
        $this->sql->logError(__METHOD__);
        
        if(count($r)){
            return new User($r[0][0]);
        }
        return null;
    }
    
    public function getCurrentAdmin(): ?User{
        $user = $this->getCurrentUser();
        return is_null($user) || !($user->isAdmin()) ? null : $user;
    }
    
    public function logout(){
        $user = $this->getCurrentUser();
        if ($user != null) {
            
            if (isset($_COOKIE[self::COOKIE_NAME])) {
                unset($_COOKIE[self::COOKIE_NAME]);
                setcookie(self::COOKIE_NAME, '', 0, '/');
            }
            $user->auth = User::AUTH_LOGGED_OUT; // ??
            $user->update();

            header('Location: ../login/');
        }
        
    }

   

    public function generateSmsCode(){
        return rand(100000,999999);
    }

    public function generateSsid(){
        return md5(rand(0,1000101001).microtime().time());
    }

    const COOKIE_NAME = "dr_ssid";
    const COOKIE_LIFETIME = 86400;

    public function auth($user){
        $user->ssid = $this->generateSsid();
        setcookie(self::COOKIE_NAME,$user->ssid,time()+self::COOKIE_LIFETIME,"/");
        $user->auth = User::AUTH_DONE;
        $user->update();
    }

    public function smsAuth($user){
        $user->sms_code = $this->generateSmsCode();
        // Sms::send($user->phone, Sms::getMessage(Sms::LOGIN_CODE, $user->sms_code));
        Sms::send($user->phone, Sms::getMessage(Sms::LOGIN_CODE, $user->sms_code));
        $user->auth = User::AUTH_PENDING;
        $user->update();
    }

    public function insertOrUpdate(string $phone){
        $user = $this->phoneIsTaken($phone) ? $this->getUserByPhone($phone) : $this->createUser($phone) ;
        $this->smsAuth($user);
        
    }

    public function phoneIsTaken(string $phone){
        $r = $this->sql->getArray("SELECT COUNT(id) FROM ".User::TABLE_NAME." WHERE phone = '$phone';");
        $this->sql->logError(__METHOD__);
        return $r[0][0] > 0;
    }


    public function createUser($phone){
        $this->sql->query("INSERT INTO ".User::TABLE_NAME." (phone, status, registered_at, inn, feature) 
            VALUES ('$phone',".User::STATUS_JUST_CREATED.",'".date("Y-m-d H:i:s")."', '',".User::INDIVIDUAL_FACE.")");
        
        $this->sql->logError(__METHOD__);
        $user = $this->getUserByPhone($phone);
        $pd = new ProfileData($user->id);
        $pd->update();

        return $user;
    }

    public function getUserByPhone(string $phone){
        $r = $this->sql->getArray("SELECT id FROM ".User::TABLE_NAME." WHERE phone='$phone'");
        $this->sql->logError(__METHOD__);
        return new User(intval($r[0][0]));
    }

    public function getUserBySmsCode(int $code){
        $r = $this->sql->getArray("SELECT id FROM ".User::TABLE_NAME." 
            WHERE sms_code=$code AND auth=".User::AUTH_PENDING);
        
        $this->sql->logError(__METHOD__);
        if(count($r)){
            return new User($r[0][0]);
        }
        return null;
    }

}