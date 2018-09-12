<?php

namespace Classes\Models\Teams;

use Classes\Sql\Sql;
use Classes\Utils\DateUtil;
use Classes\Exceptions\DesktopRentException;
use Classes\Models\Users\User;
use Classes\Models\Teams\Role;

class Team {
    
    public const TABLE_NAME = '_teams';
    /*
        # id INT
        # owner INT
        # title VARCHAR(256)
        # created DATETIME
    */
    
    public const USERS_TEAMS_TABLE = '_users_teams';
    /*
        # id INT
        # user_id INT
        # role_id INT
        # team_id INT
        # added DATETIME
        # status INT
    */
    
    protected const PROPS_COLUMNS_INFO = [
        'owner' => ['type' => 'int', 'get'],
        'title' => ['type' => 'str', 'get', 'set'],
        'created' => ['type' => 'str', 'get'],
    ];
    
    use \Classes\Traits\Entity;
    
    const USER_STATUS_JOINED = 0;
    const USER_STATUS_APPROVED = 1;
    const USER_STATUS_REJECTED = -1;
    
    private $id;
    private $owner;
    private $title;
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
        
        return $this;
    }
    
    public function approveUser(User $user){
        return $this->changeUserStatus($user, self::USER_STATUS_APPROVED);
    }
    
    public function rejectUser(User $user){
        return $this->changeUserStatus($user, self::USER_STATUS_REJECTED);
    }
    
    public function deleteUser(User $user){
        $sql = Sql::getInstance();
        
        $sql->delete(
            self::USERS_TEAMS_TABLE,
            "user_id = {$user->getId()} AND team_id = {$this->id}"
        );
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
    
    public function addRole(User $user, Role $role, $status = self::USER_STATUS_JOINED): self{
        $sql = Sql::getInstance();
        $sql->insert(
            Team::USERS_TEAMS_TABLE,
            [
                'user_id' => $user->getId(),
                'team_id' => $this->getId(),
                'role_id' => $role->getId(),
                'added' => DateUtil::toSql(time()),
                'status' => $status
            ]
        );
        return $this;
    }
    
    public function getRoles(): array{
        $sql = Sql::getInstance();
        
        $q = "SELECT role_id, status, added FROM " . self::USERS_TEAMS_TABLE . "
            WHERE team_id = {$this->id}";
        
        $data = $sql->getAssoc($q);
        $results = [];
        
        foreach($data as $line){
            $arr['status'] = (int) $line['status'];
            $arr['statusName'] = self::getStatusName($arr['status']);
            $arr['added'] = DateUtil::toRussian($line['added']);
            
            $roleId = (int) $line['role_id'];
            $role = new Role($roleId);
            
            $arr['roleId'] = $roleId;
            $arr['roleName'] = $role->getTitle();
            
            $results [] = $arr;
        }
        
        return $results;
    }
    
}