<?php

namespace Classes\Models\Folders;

use Classes\Sql\Sql;
use Classes\Utils\DateUtil;
use Classes\Exceptions\DesktopRentException;
use Classes\Models\Users\User;

class Folder {
    
    public const TABLE_NAME = '_folders';
    /*
        # id INT
        # user_id INT
        # title VARCHAR(1024)
        # created DATETIME
    */
    
    protected const PROPS_COLUMNS_INFO = [
        'user_id' => ['alias' => 'userId', 'type' => 'int', 'get'],
        'title' => ['type' => 'str', 'get', 'set'],
        'created' => ['type' => 'str', 'get'],
    ];
    
    use \Classes\Traits\Entity;
    
    private $id;
    private $userId;
    private $title;
    private $created;
    
    public function getValidatedData(array $data): array{
        $data['created'] = DateUtil::toRussian($data['created']);
        return $data;
    }
    
    public function isOwnedByUser(User $user): bool{
        $sql = Sql::getInstance();
        return $sql->getRowsAmountIn(self::TABLE_NAME, "user_id = {$user->getId()}");
    }
    
}