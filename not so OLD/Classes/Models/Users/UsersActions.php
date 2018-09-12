<?php

namespace Classes\Models\Users;

use Classes\Utils\Sql;
use Classes\Utils\Log;
use Classes\Utils\DateUtil;
use Classes\Utils\Common;
use Classes\Utils\Sms;
use Classes\Exceptions\DesktopRentException;
use Classes\Models\Teams\Team;
use Classes\Models\Users\User;
use Classes\Models\Users\UserData;

class UsersActions {
    
    public function deleteOldSms(){
        $sql = Sql::getInstance();
        $smsExpiration = DateUtil::toSql(time() - User::SMS_CODE_LIFE_TIME);
        
        $q = "DELETE FROM " . User::SMS_TABLE . "
            WHERE sended > '?'";
        
        $sql->execPrepared($q, [$smsExpiration]);
        $sql->logError(__METHOD__);
    }
    
    public function registerUser(string $phone): User{
        $sql = Sql::getInstance();
        
        $sql->insertTo(
            User::TABLE_NAME,
            [$phone, DateUtil::toSql(time())],
            ['phone', 'registered']
        );
        $sql->logError(__METHOD__);
        
        $id = $sql->getInsertId();
        $user = new User($id);
        
        if( !$user->hasUserData() ){
            $data = $user->createUsersData();
        }
        return $user;
    }
    
    private function getUserByQuery(string $q): ?User{
        $sql = Sql::getInstance();
        $data = $sql->getRow($q);
        $sql->logError(__METHOD__);
        
        return empty($data) ? null : new User( +$data['id'] );
    }
    
    public function getUserByPhone(string $phone): ?User{
        $q = "SELECT id FROM " . User::TABLE_NAME . "
            WHERE phone = '$phone' ";
        
        return $this->getUserByQuery($q);
    }
    
    public function getCurrentUser(): ?User{
        $value = $_COOKIE[User::COOKIE_NAME];
        
        $q = "SELECT user_id id FROM " . User::CONNECTIONS_TABLE . "
            WHERE cookie = '$value' ";
        
        return $this->getUserByQuery($q);
    }
    
    public function getAuthCurrentUser(): ?User{
        $value = $_COOKIE[User::COOKIE_NAME];
        
        $q = "SELECT id FROM " . User::TABLE_NAME . "
            WHERE id = 
            (SELECT user_id id FROM " . User::CONNECTIONS_TABLE . "
            WHERE cookie = '$value') AND auth_status = " . User::AUTH_STATUS_AUTHORIZED;
        
        return $this->getUserByQuery($q);
    }
    
}