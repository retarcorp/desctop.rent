<?php

namespace Classes\Controllers;

use Classes\Utils\RegExp;
use Classes\Utils\Safety;
use Classes\Utils\Sms;
use Classes\Utils\DateUtil;
use Classes\Utils\DataHolder;
use Classes\Models\Users\UsersActions;
use Classes\Models\Users\User;
use Classes\Models\Users\UserData;
use Classes\Models\Teams\Team;
use Classes\Exceptions\DesktopRentException;

class UsersController {
    
    use \Classes\Traits\ControllerActions;
    
    # @http GET /user/data/
    public function getUserData(){
        $actions = new UsersActions();
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        $userData = $current->getUserData();
        return $userData->toArray();
    }

    # @http POST /user/data/edit/
    public function updateUserData(){
        $actions = new UsersActions();
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        $userData = $current->getUserData();
        
        $name = $_POST['name'] ?? $userData->getName();
        $surname = $_POST['surname'] ?? $userData->getSurname();
        $patronymic = $_POST['patronymic'] ?? $userData->getPatronymic();
        $inn = $_POST['inn'] ?? $userData->getInn() ?? '';
        
        if( isset($_POST['inn']) && !trim($inn) ){
            throw new DesktopRentException('ИНН обяательный для заполнения');
        }
        
        $userData->setName(Safety::protect($name));
        $userData->setSurname(Safety::protect($surname));
        $userData->setPatronymic(Safety::protect($patronymic));
        $userData->setInn(Safety::protect($inn));
        
        return $userData->update()->toArray();
    }
    
    # @http GET /user/via/phone/
    public function getUserViaPhone(){
        $actions = new UsersActions();
        
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        Safety::protect($_GET['phone']);
        $phone = UserData::getValidPhone($_GET['phone']);
        Safety::checkPhone($phone);
        
        $user = $actions->getUserByPhone($phone);
        Safety::checkExistance($user);
        
        return $user->toArray();
    }
    
    private function getTeamsForUser(User $user, $global): array{
        $limit = $global['limit'] ?? null;
        $offset = $global['offset'] ?? null;
        
        $teams = $user->getOwnedTeams($limit, $offset);
        return $this->toPrimitive($teams);
    }
    
    # @http GET /user/teams/owned/
    public function getOwnedTeams(){
        $actions = new UsersActions();
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        return $this->getTeamsForUser($current, $_GET);
    }
    
    # @http GET /user/teams/
    public function getUserTeams(){
        $actions = new UsersActions();
        
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        $id = intval($_GET['id']);
        $user = new User($id);
        
        return $this->getTeamsForUser($user, $_GET);
    }
    
    // # @http GET /user/teams/joined/
    // public function getJoinedTeams(){
    //     $actions = new UsersActions();
        
    //     $current = $actions->getCurrentUser();
    //     Safety::checkAuth($current);
        
    //     $limit = $_GET['limit'] ?? null;
    //     $offset = $_GET['offset'] ?? null;
        
    //     $teams = $current->getJoinedTeams($limit, $offset);
        
    //     $results = [];
    //     foreach($teams as $team){
    //         $data = $team->toArray();
    //         $data['roles'] = $team->getRoles();
    //         $results [] = $data;
    //     }
        
    //     return $results;
    // }
    
    # @http GET /user/1c/db/
    public function get1CDataBases(){
        $actions = new UsersActions();
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        return $this->toPrimitive($current->get1CDataBases());
    }
    
    # @http GET /user/folders/
    public function getFolders(){
        $actions = new UsersActions();
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        return $this->toPrimitive($current->getFolders());
    }
    
    # @http GET /user/scanners/
    public function getScanners(){
        $actions = new UsersActions();
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        return $this->toPrimitive($current->getScanners());
    }
    
}