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
        $userData->setPropsFromDB();
        return $userData->toArray();
    }

    # @http POST /user/data/edit/
    public function updateUserData(){
        $actions = new UsersActions();
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        $userData = $current->getUserData();
        $userData->setPropsFromDB();
        
        $name = $_POST['name'] ?? $userData->getName();
        $surname = $_POST['surname'] ?? $userData->getSurname();
        $patronymic = $_POST['patronymic'] ?? $userData->getPatronymic();
        $inn = $_POST['inn'] ?? $userData->getInn();
        
        Safety::protect($name);
        Safety::protect($surname);
        Safety::protect($patronymic);
        Safety::protect($inn);
        
        $userData->setName($name);
        $userData->setSurname($surname);
        $userData->setPatronymic($patronymic);
        $userData->setInn($inn);
        
        $userData->update();
        return $userData->toArray();
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
        
        $user->setPropsFromDB();
        return $user->toArray();
    }
    
    private function getTeamsForUser(User $user, $global): array{
        $limit = $global['limit'] ?? null;
        $offset = $global['offset'] ?? null;
        
        $teams = $user->getOwnedTeams($limit, $offset);
        return $this->toPrimitive($teams, 1);
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
    
    # @http GET /user/teams/joined/
    public function getJoinedTeams(){
        $actions = new UsersActions();
        
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        $limit = $_GET['limit'] ?? null;
        $offset = $_GET['offset'] ?? null;
        
        $teams = $current->getJoinedTeams($limit, $offset);
        
        $results = [];
        foreach($teams as $team){
            $data = $team->setPropsFromDB()->toArray();
            $info = $team->getUserInfo($current);
            $data['status'] = $info['status'];
            $data['added'] = DateUtil::toRussian($info['added']);
            $data['statusName'] = Team::getStatusName($data['status']);
            $results [] = $data;
        }
        
        return $results;
    }
    
}