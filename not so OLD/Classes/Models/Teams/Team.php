<?php

namespace Classes\Models\Teams;

use Classes\Utils\Sql;
use Classes\Utils\Log;
use Classes\Utils\DateUtil;
use Classes\Utils\Common;
use Classes\Utils\Sms;
use Classes\Exceptions\DesktopRentException;
use Classes\Models\Users\User;

class Team {
    
    public const TABLE_NAME = '_teams';
    /*
        # id INT
        # owner INT
        # title VARCHAR(256)
        # inn VARCHAR(32)
        # created DATETIME
    */
    
    public const USERS_TEAMS_TABLE = '_users_teams';
    /*
        # id INT
        # user_id INT
        # team_id INT
        # added DATETIME
        # status INT
    */
    
    protected const PROPS_COLUMNS_INFO = [
        'owner' => ['type' => 'int', 'get'],
        'title' => ['type' => 'str', 'get', 'set'],
        'inn' => ['type' => 'str', 'get', 'set'],
        'created' => ['type' => 'str', 'get']
    ];
    
    use \Classes\Traits\Entity;
    
    const USER_STATUS_JOINED = 0;
    const USER_STATUS_APPROVED = 1;
    const USER_STATUS_REJECTED = -1;
    const USER_STATUS_DELETED = 2;
    
    private $id;
    private $owner;
    private $title;
    private $inn;
    private $created;
    
    public function getValidatedData(array $data): array{
        $data['created'] = DateUtil::toRussian($data['created']);
        return $data;
    }
    
    private function changeUserStatus(User $user, int $status): self{
        $sql = Sql::getInstance();
        
        $sql->update(
            self::USERS_TEAMS_TABLE,
            ['status' => $status],
            ['user_id' => $user->getId(), 'team_id' => $this->id]
        );
        $sql->logError(__METHOD__);
        
        return $this;
    }
    
    public function approveUser(User $user){
        return $this->changeUserStatus($user, self::USER_STATUS_APPROVED);
    }
    
    public function rejectUser(User $user){
        return $this->changeUserStatus($user, self::USER_STATUS_REJECTED);
    }
    
    public function deleteUser(User $user){
        return $this->changeUserStatus($user, self::USER_STATUS_DELETED);
    }
    
    public function getUserInfo(User $user){
        $sql = Sql::getInstance();
        
        $q = "SELECT status, added FROM " . self::USERS_TEAMS_TABLE . "
            WHERE user_id = {$user->getId()} AND team_id = {$this->id}";
        
        return $sql->getRow($q);
    }
    
    public static function getStatusName(int $const): string{
        switch($const){
            case self::USER_STATUS_JOINED:
                return 'Присоединен';
                
            case self::USER_STATUS_APPROVED:
                return 'Подтвержден';
                
            case self::USER_STATUS_REJECTED:
                return 'Отклонен';
                
            case self::USER_STATUS_DELETED:
                return 'Удален';
            
            default:
                return 'Неопознан';
        }
    }
    
}