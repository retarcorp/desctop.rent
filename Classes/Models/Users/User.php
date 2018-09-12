<?php

namespace Classes\Models\Users;

use Classes\Sql\Sql;
use Classes\Utils\DateUtil;
use Classes\Utils\Common;
use Classes\Utils\DataHolder;
use Classes\Utils\Sms;
use Classes\Exceptions\DesktopRentException;
use Classes\Models\Teams\Team;
use Classes\Models\Teams\Role;
use Classes\Models\Users\UserData;
use Classes\Models\_1C\DB;
use Classes\Models\_1C\Configuration;
use Classes\Models\Folders\Folder;
use Classes\Models\Folders\Scanner;

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
        //'auth_status' => ['alias'=> 'authStatus', 'type' => 'int', 'get', 'set'],
    ];
    
    use \Classes\Traits\Entity;
    use \Classes\Traits\FactoryMethods;
    
    const COOKIE_NAME = 'desktoprent_user';
    const COOKIE_LIFE_TIME = 60 * 60 * 24 * 7; // week
    
    //const SMS_CODE_LIFE_TIME = 60 * 3; //3 mins
    
    private $id;
    private $phone;
    private $registered;
    //private $authStatus;
    
    private function getValidatedData(array $data): array{
        $data['registered'] = DateUtil::toRussian($data['registered']);
        return $data;
    }
    
    public function getUserData(): UserData{
        $sql = Sql::getInstance();
        
        $q = "SELECT * FROM " . UserData::TABLE_NAME . "
            WHERE user_id = {$this->id}";
        
        $data = $sql->getRow($q);
        return UserData::toInstance($data);
    }
    
    public function hasUserData(): bool{
        $sql = Sql::getInstance();
        return $sql->getRowsAmountIn(UserData::TABLE_NAME, "user_id = {$this->id}");
    }
    
    public function createUsersData(): UserData{
        return $this->createObject(
            "Classes\Models\Users\UserData",
            ['user_id' => $this->id, 'inn' => '']
        );
    }
    
    public function clearSmsCodes(){
        $sql = Sql::getInstance();
        $sql->delete( self::SMS_TABLE, ['user_id' => $this->id] );
    }
    
    public function addSmsCode(string $code){
        $sql = Sql::getInstance();
        $data = [
            'user_id' => $this->id,
            'code' => $code,
            'sended' => DateUtil::toSql(time())
        ];
        
        $sql->insert(self::SMS_TABLE, $data);
    }
    
    public function checkSmsCode(string $code): bool{
        $sql = Sql::getInstance();
        
        //$smsExpiration = DateUtil::toSql(time() - User::SMS_CODE_LIFE_TIME);
        
        return $sql->getRowsAmountIn(
            self::SMS_TABLE,
            "code = '$code' AND user_id = {$this->id} " // AND sended > '$smsExpiration'"
        );
    }
    
    public function generateHash(): string{
        return md5(time());
    }
    
    public function auth(){
        $value = $this->generateHash();
        
        $sql = Sql::getInstance();
        
        $data = [
            'user_id' => $this->id,
            'cookie' => $value,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'setted' => DateUtil::toSql(time())
        ];
        
        $sql->insert(self::CONNECTIONS_TABLE, $data);
            
        setcookie(self::COOKIE_NAME, $value, time() + self::COOKIE_LIFE_TIME, '/');
    }
    
    public function logout(){
        if( isset($_COOKIE[self::COOKIE_NAME]) ){
            
            $sql = Sql::getInstance();
            $value = $_COOKIE[self::COOKIE_NAME];
            
            $sql->delete(self::CONNECTIONS_TABLE, ['user_id' => $this->id, 'cookie' => $value]);
            $sql->logError(__METHOD__);
            
            setcookie(self::COOKIE_NAME, '', time() - 1, '/');
            
            //$this->authStatus = self::AUTH_STATUS_UNAUTHORIZED;
            $this->update();
        }
    }
    
    public function hasTeam(): bool{
        $sql = Sql::getInstance();
        return $sql->getRowsAmountIn(Team::TABLE_NAME, " owner = {$this->id} ");
    }
    
    public function createTeam(string $title = 'Новая команда'): Team{
        return $this->createObject(
            "Classes\Models\Teams\Team",
            [
                'owner' => $this->id,
                'title' => $title,
                'created' => DateUtil::toSql(time())
            ]
        )->addRole($this, Role::master(), Team::USER_STATUS_APPROVED);
    }
    
    public function getOwnedTeams($limit = null, $offset = null): array{
        return $this->getObjects(
            "Classes\Models\Teams\Team",
            "owner = {$this->id}",
            $limit, $offset
        );
    }
    
    public function isOwnerForTeam(Team $team): bool{
        $sql = Sql::getInstance();
        return $sql->getRowsAmountIn(Team::TABLE_NAME, "owner = {$this->id} AND id = {$team->getId()}");
    }
    
    public function hasRelationWithTeams(): bool{
        $sql = Sql::getInstance();
        return $sql->getRowsAmountIn(Team::USERS_TEAMS_TABLE, "user_id = {$this->id}");
    }
    
    public function hasRelationWithTeam(Team $team): bool{
        $sql = Sql::getInstance();
        return $sql->getRowsAmountIn(
            Team::USERS_TEAMS_TABLE,
            "user_id = {$this->id} AND team_id = {$team->getId()}"
        );
    }
    
    public function joinTeam(Team $team){
        $team->addRole($this, Role::candidate());
        
        $userData = $this->getUserData();
        
        $data = new DataHolder([
            'name' => [$userData->getName()],
            'surname' => [$userData->getSurname()],
            'patronymic' => [$userData->getPatronymic()],
            'phone' => [$this->phone]
        ]);
        
        Sms::send($this->phone, Sms::getMessage(Sms::JOINED_USER, $data));
    }
    
    public function getJoinedTeams($limit = null, $offset = null): array{
        $sql = Sql::getInstance();
        
        $q = "SELECT * FROM " . Team::TABLE_NAME . "
            WHERE id IN (SELECT team_id id FROM " . Team::USERS_TEAMS_TABLE . "
            WHERE user_id = {$this->id}
            ORDER BY added DESC)";
        
        $q .= is_null($limit) ? '' : " LIMIT $limit ";
        $q .= is_null($offset) ? '' : " OFFSET $offset ";
        
        $data = $sql->getAssoc($q);
        return Team::toInstances($data);
    }
    
    public function create1CDataBase(Configuration $conf, string $title, int $handHandled = 0): DB{
        return $this->createObject(
            "Classes\Models\_1C\DB",
            [
                'user_id' => $this->id,
                'conf_id' => $conf->getId(),
                'title' => $title,
                'hand_handled' => $handHandled,
                'created' => DateUtil::toSql(time())
            ]
        );
    }
    
    public function get1CDataBases(): array{
        return $this->getObjects(
            "Classes\Models\_1C\DB",
            "user_id = {$this->id}"
        );
    }
    
    public function delete1CDatabase(DB $db){
        $this->deleteObject($db);
    }
    
    public function createFolder(string $title): Folder{
        return $this->createObject(
            "Classes\Models\Folders\Folder",
            [
                'user_id' => $this->id,
                'title' => $title,
                'created' => DateUtil::toSql(time())
            ]
        );
    }
    
    public function getFolders(): array{
        return $this->getObjects(
            "Classes\Models\Folders\Folder",
            "user_id = {$this->id}"
        );
    }
    
    public function deleteFolder(Folder $folder){
        $this->deleteObject($folder);
    }
    
    public function createScanner(DataHolder $data): Scanner{
        return $this->createObject(
            "Classes\Models\Folders\Scanner",
            [
                'user_id' => $this->id,
                'title' => $data->title,
                'address' => $data->address,
                'login' => $data->login,
                'password' => $data->password,
                'created' => DateUtil::toSql(time())
            ]
        );
    }
    
    public function getScanners(): array{
        return $this->getObjects(
            "Classes\Models\Folders\Scanner",
            "user_id = {$this->id}"
        );
    }
    
    public function deleteScanner(Scanner $scanner){
        $this->deleteObject($scanner);
    }
    
}