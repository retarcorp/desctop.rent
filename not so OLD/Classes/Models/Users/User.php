<?php

namespace Classes\Models\Users;

use Classes\Utils\Sql;
use Classes\Utils\Log;
use Classes\Utils\DateUtil;
use Classes\Utils\Common;
use Classes\Utils\Sms;
use Classes\Exceptions\DesktopRentException;
use Classes\Models\Teams\Team;
use Classes\Models\Users\UserData;

class User {
    
    public const TABLE_NAME = '_users';
    /*
        # id INT
        # phone VARCHAR(20)
        # registered DATETIME
        # auth_status BOOL
    */
    
    public const SMS_TABLE = '_users_sms';
    /*
        # id INT
        # user_id INT
        # code VARCHAR(32)
        # sended DATETIME
    */
    
    public const CONNECTIONS_TABLE = '_users_connections';
    /*
        # id INT
        # user_id INT
        # cookie VARCHAR(256)
        # ip VARCHAR(32)
        # setted DATETIME
    */
    
    protected const PROPS_COLUMNS_INFO = [
        'phone' => ['type' => 'str', 'get'],
        'registered' => ['type' => 'str', 'get'],
        'auth_status' => ['alias'=> 'authStatus', 'type' => 'int', 'get', 'set'],
    ];
    
    use \Classes\Traits\Entity;
    use \Classes\Traits\FactoryMethods;
    
    const COOKIE_NAME = 'desktoprent_user';
    const COOKIE_LIFE_TIME = 60 * 60 * 24 * 7; // week
    
    const AUTH_STATUS_UNAUTHORIZED = 0;
    const AUTH_STATUS_AUTHORIZED = 1;
    
    const SMS_CODE_LIFE_TIME = 60 * 3; //3 mins
    
    private $id;
    private $phone;
    private $registered;
    private $authStatus;
    
    private function getValidatedData(array $data): array{
        $data['registered'] = DateUtil::toRussian($data['registered']);
        return $data;
    }
    
    public function getUserData(): UserData{
        $sql = Sql::getInstance();
        
        $q = "SELECT id FROM " . UserData::TABLE_NAME . "
            WHERE user_id = {$this->id}";
        
        $data = $sql->getRow($q);
        $sql->logError(__METHOD__);
        
        $id = +$data['id'];
        return new UserData($id);
    }
    
    public function hasUserData(): bool{
        $sql = Sql::getInstance();
        return $sql->getRowsAmountIn(UserData::TABLE_NAME, "user_id = {$this->id}");
    }
    
    public function createUsersData(): UserData{
        return $this->createObject(
            "Classes\Models\Users\UserData",
            ['user_id' => $this->id]
        );
    }
    
    public function clearSmsCodes(){
        $sql = Sql::getInstance();
        $sql->deleteFrom( self::SMS_TABLE, ['user_id' => $this->id] );
        $sql->logError(__METHOD__);
    }
    
    public function addSmsCode(string $code){
        $sql = Sql::getInstance();
        $values = [ $this->id, $code, DateUtil::toSql(time()) ];
        $columns = ['user_id', 'code', 'sended'];
        
        $sql->insertTo( self::SMS_TABLE, $values, $columns);
        $sql->logError(__METHOD__);
    }
    
    public function checkSmsCode(string $code): bool{
        $sql = Sql::getInstance();
        
        $smsExpiration = DateUtil::toSql(time() - User::SMS_CODE_LIFE_TIME);
        
        return $sql->getRowsAmountIn(
            self::SMS_TABLE,
            "code = '$code' AND user_id = {$this->id} AND sended > $smsExpiration"
        );
    }
    
    public function generateHash(): string{
        return md5(time());
    }
    
    public function auth(){
        $value = $this->generateHash();
        
        $sql = Sql::getInstance();
        $values = [ $this->id, $value, $_SERVER['REMOTE_ADDR'], DateUtil::toSql(time()) ];
        $columns = ['user_id', 'cookie', 'ip', 'setted'];
        
        $sql->insertTo( self::CONNECTIONS_TABLE, $values, $columns );
        $sql->logError(__METHOD__);
        
        setcookie(self::COOKIE_NAME, $value, time() + self::COOKIE_LIFE_TIME, '/');
    }
    
    public function logout(){
        $sql = Sql::getInstance();
        $value = $_COOKIE[self::COOKIE_NAME];
        
        $sql->deleteFrom(self::CONNECTIONS_TABLE, "user_id = ? AND cookie = '?'", [$this->id, $value]);
        $sql->logError(__METHOD__);
        
        setcookie(self::COOKIE_NAME, '', time() - 1, '/');
        
        $this->authStatus = self::AUTH_STATUS_UNAUTHORIZED;
        $this->update();
    }
    
    public function createTeam(string $title, string $inn = ''): Team{
        return $this->createObject(
            "Classes\Models\Teams\Team",
            [
                'owner' => $this->id,
                'title' => $title,
                'inn' => $inn,
                'created' => DateUtil::toSql(time())
            ]
        );
    }
    
    public function getOwnedTeams($limit = null, $offset = null): array{
        return $this->getObjects(
            "Classes\Models\Teams\Team",
            "owner = {$this->id}",
            $limit, $offset
        );
    }
    
    public function getJoinedTeams($limit = null, $offset = null): array{
        $sql = Sql::getInstance();
        
        $q = "SELECT team_id id FROM " . Team::USERS_TEAMS_TABLE . "
            WHERE user_id = {$this->id}
            ORDER BY added DESC";
        
        $q .= is_null($limit) ? '' : " LIMIT $limit ";
        $q .= is_null($offset) ? '' : " OFFSET $offset ";
        
        $data = $sql->getAssocArray($q);
        $sql->logError(__METHOD__);
        
        return Team::toInstances($data);
    }
    
    public function isOwnerForTeam(Team $team): bool{
        $sql = Sql::getInstance();
        return $sql->getRowsAmountIn(Team::TABLE_NAME, "owner = {$this->id} AND id = {$team->getId()}");
    }
    
    public function joinTeam(Team $team){
        $sql = Sql::getInstance();
        $sql->insertTo(
            Team::USERS_TEAMS_TABLE,
            [ $this->id, $team->getId(), DateUtil::toSql(time()), Team::USER_STATUS_JOINED ],
            ['user_id', 'team_id', 'added', 'status']
        );
        $sql->logError(__METHOD__);
    }
    
    public function hasRelationWithTeam(Team $team): bool{
        $sql = Sql::getInstance();
        return $sql->getRowsAmountIn(
            Team::USERS_TEAMS_TABLE,
            "user_id = {$this->id} AND team_id = {$team->getId()}"
        );
    }
    
}