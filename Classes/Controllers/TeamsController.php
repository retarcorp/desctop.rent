<?php

namespace Classes\Controllers;

use Classes\Utils\Safety;
use Classes\Utils\Sms;
use Classes\Utils\DataHolder;
use Classes\Models\Users\UsersActions;
use Classes\Models\Users\User;
use Classes\Models\Users\UserData;
use Classes\Models\Teams\Team;
use Classes\Exceptions\DesktopRentException;

class TeamsController {
    
    use \Classes\Traits\ControllerActions;

    # @http GET /team/
    public function getTeam(){
        $id = (int) $_GET['id'];
        $team = new Team($id);
        $roles = $team->getRoles();
        return $team->toArray() + ['roles' => $roles];
    }
    
    # @http POST /team/
    public function createTeam(){
        $actions = new UsersActions();
        
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        if( $current->hasRelationWithTeams() ){
            throw new DesktopRentException('Вы пока не можете создавать команды');
        }
        
        $title = $_POST['title'] ?? 'Новая команда';
        Safety::protect($title);
        
        $team = $current->createTeam($title);
        return $team->toArray();
    }
    
    # @http POST /team/edit/
    public function updateTeam(){
        $actions = new UsersActions();
        
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        $id = (int) $_POST['id'];
        $team = new Team($id);
        
        if( !$current->isOwnerForTeam($team) ){
            throw new DesktopRentException('Вы не владеете этой командой');
        }
        
        $team->setTitle(Safety::protect($_POST['title']));
        $team->update();
        return 'Выполнено успешно';
    }
    
    # @http POST /team/join/
    public function joinTeam(){
        $actions = new UsersActions();
        
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        $id = intval($_POST['id']);
        $team = new Team($id);
        
        // if( $current->isOwnerForTeam($team) ){
        //     throw new DesktopRentException('Вы владеете этой командой!');
        // }elseif($current->hasRelationWithTeam($team)){
        //     throw new DesktopRentException('Вы уже в этой командой!');
        // }
        
        $current->joinTeam($team);
        return 'Выполнено успешно!';
    }
    
    private function changeUserStatus(int $teamId, int $userId, $func){
        $actions = new UsersActions();
        
        $current = $actions->getCurrentUser();
        Safety::checkAuth($current);
        
        $team = new Team($teamId);
        
        if( !$current->isOwnerForTeam($team) ){
            throw new DesktopRentException('Вы не владеете этой командой!');
        }
        
        $user = new User($userId);
        $team->$func($user);
        return 'Выполнено успешно!';
    }
    
    # @http POST /team/user/approve/
    public function approveUserFromTeam(){
        return $this->changeUserStatus($_POST['teamId'], $_POST['userId'], 'approveUser');
    }
    
    # @http POST /team/user/reject/
    public function rejectUserFromTeam(){
        return $this->changeUserStatus($_POST['teamId'], $_POST['userId'], 'rejectUser');
    }
    
    # @http POST /team/user/fire/
    public function deleteUserFromTeam(){
        return $this->changeUserStatus($_POST['teamId'], $_POST['userId'], 'deleteUser');
    }
    
}