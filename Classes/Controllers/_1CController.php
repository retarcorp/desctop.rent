<?php

namespace Classes\Controllers;

use Classes\Utils\Safety;
use Classes\Utils\DateUtil;
use Classes\Utils\DataHolder;
use Classes\Models\Users\UsersActions;
use Classes\Models\Users\User;
use Classes\Models\Users\UserData;
use Classes\Models\_1c\Configuration;
use Classes\Models\_1c\DB;
use Classes\Exceptions\DesktopRentException;

class _1CController {
    
    use \Classes\Traits\ControllerActions;
    
    # @http GET /1c/configs/
    public function getConfigurations(){
        $configs = Configuration::getAll();
        return $this->toPrimitive($configs);
    }
    
    # @http POST /1c/db/
    public function createDB(){
        $actions = new UsersActions();
        
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        $confId = (int) $_POST['configId'];
        $config = new Configuration($confId);
        
        $title = $_POST['title'] ?? '';
        $handled = $_POST['handHandled'] ?? 0;
        
        $db = $current->create1CDataBase($config, Safety::protect($title), (int) $handled);
        return $db->toArray();
    }
    
    # @http POST /1c/db/edit/
    public function updateDB(){
        $actions = new UsersActions();
        
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        $dbId = (int) $_POST['dbId'];
        $db = new DB($dbId);
        
        if( !$db->isOwnedByUser($current) ){
            throw new DesktopRentException('У Вас нет прав на совершение данной операции');
        }
        
        $configId = $_POST['configId'] ?? $db->getConfId();
        $db->setConfId( (int) $configId);
        
        $title = $_POST['title'] ?? $db->getTitle();
        $db->setTitle(Safety::protect($title));
        
        $handHandled = $_POST['handHandled'] ?? $db->getHandHandled();
        $db->setHandHandled($handHandled);
        
        return $db->update()->toArray();
    }
    
    # @http DELETE /1c/db/
    public function deleteDB(){
        $actions = new UsersActions();
        
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        $dbId = (int) $_GET['id'];
        $db = new DB($dbId);
        
        if( !$db->isOwnedByUser($current) ){
            throw new DesktopRentException('У Вас нет прав на совершение данной операции');
        }
        
        $current->delete1CDatabase($db);
        return 'Выполнено успешно';
    }
    
}