<?php

namespace Classes\Controllers;

use Classes\Utils\Safety;
use Classes\Utils\DateUtil;
use Classes\Utils\DataHolder;
use Classes\Models\Users\UsersActions;
use Classes\Models\Users\User;
use Classes\Models\Folders\Folder;
use Classes\Models\Folders\Scanner;
use Classes\Exceptions\DesktopRentException;

class FoldersController {
    
    use \Classes\Traits\ControllerActions;
    
    # @http POST /folder/
    public function createFolder(){
        $actions = new UsersActions();
        
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        if( !isset($_POST['title']) || !trim($_POST['title']) ){
            throw new DesktopRentException('Название не может быть пустым');
        }
        
        $folder = $current->createFolder(Safety::protect($_POST['title']));
        return $folder->toArray();
    }
    
    # @http POST /folder/edit/
    public function updateFolder(){
        $actions = new UsersActions();
        
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        $id = (int) $_POST['id'];
        $folder = new Folder($id);
        
        if( !$folder->isOwnedByUser($current) ){
            throw new DesktopRentException('У Вас нет прав на совершение данной операции');
        }
        
        $title = $_POST['title'] ?? $folder->getTitle();
        $folder->setTitle(Safety::protect($title));
        
        return $folder->update()->toArray();
    }
    
    # @http DELETE /folder/
    public function deleteFolder(){
        $actions = new UsersActions();
        
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        $id = (int) $_GET['id'];
        $folder = new Folder($id);
        
        if( !$folder->isOwnedByUser($current) ){
            throw new DesktopRentException('У Вас нет прав на совершение данной операции');
        }
        
        $current->deleteFolder($folder);
        return 'Выполнено успешно';
    }
    
    # @http POST /scanner/
    public function createScanner(){
        $actions = new UsersActions();
        
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        $data = new DataHolder();
        $data->append('title', $_POST['title'])
            ->append('address', $_POST['address'])
            ->append('login', $_POST['login'])
            ->append('password', $_POST['password']);
        
        $scanner = $current->createScanner($data);
        return $scanner->toArray();
    }
    
    private function setPropsInScanner(array $props, Scanner $scanner){
        foreach($props as $prop){
            $get = 'get' . ucfirst($prop);
            $set = 'set' . ucfirst($prop);
            $value = $_POST[$prop] ?? $scanner->$get();
            $scanner->$set(Safety::protect($value));
        }
    }
    
    # @http POST /scanner/edit/
    public function updateScanner(){
        $actions = new UsersActions();
        
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        $id = (int) $_POST['id'];
        $scanner = new Scanner($id);
        
        if( !$scanner->isOwnedByUser($current) ){
            throw new DesktopRentException('У Вас нет прав на совершение данной операции');
        }
        
        $this->setPropsInScanner(['title', 'address', 'login', 'password'], $scanner);
        return $scanner->update()->toArray();
    }
    
    # @http DELETE /scanner/
    public function deleteScanner(){
        $actions = new UsersActions();
        
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        $id = (int) $_GET['id'];
        $scanner = new Scanner($id);
        
        if( !$scanner->isOwnedByUser($current) ){
            throw new DesktopRentException('У Вас нет прав на совершение данной операции');
        }
        
        $current->deleteScanner($scanner);
        return 'Выполнено успешно';
    }
    
}