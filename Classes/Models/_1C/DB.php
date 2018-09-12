<?php

namespace Classes\Models\_1C;

use Classes\Sql\Sql;
use Classes\Utils\DateUtil;
use Classes\Models\_1C\Configuration;
use Classes\Models\Users\User;
use Classes\Exceptions\DesktopRentException;

class DB {
    
    public const TABLE_NAME = '_1c_dbs';
    /*
        # id INT
        # user_id INT
        # conf_id INT
        # title VARCHAR(1024)
        # hand_handled BOOL
        # created DATETIME
    */
    
    protected const PROPS_COLUMNS_INFO = [
        'user_id' => ['alias' => 'userId', 'type' => 'int', 'get'],
        'conf_id' => ['alias' => 'confId', 'type' => 'int', 'get', 'set'],
        'title' => ['type' => 'str', 'get', 'set'],
        'hand_handled' => ['alias' => 'handHandled', 'type' => 'bool', 'get', 'set'],
        'created' => ['type' => 'str', 'get'],
    ];
    
    use \Classes\Traits\Entity;
    
    private $id;
    private $userId;
    private $confId;
    private $title;
    private $handHandled;
    private $created;
    
    private function getValidatedData(array $data): array{
        $data['created'] = DateUtil::toRussian($data['created']);
        return $data;
    }
    
    public function isOwnedByUser(User $user): bool{
        $sql = Sql::getInstance();
        return $sql->getRowsAmountIn(DB::TABLE_NAME, "user_id = {$user->getId()}");
    }
    
}