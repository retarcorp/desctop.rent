<?php
namespace Classes\Utils;

use Classes\Models\Users\UsersFactory;
use Classes\Models\Users\User;

class Safety{


    const PUBLIC_ZONE_URL = "/login/";
    public static function declareProtectedZone(){
        $factory = new UsersFactory();
        $user = $factory->getCurrentUser();
        if(!$user){
            header("Location: ".self::PUBLIC_ZONE_URL);
            die();
        }
    }

    const AUTHORIZED_ZONE_URL = "/";
    public static function declareUnauthorizedOnlyZone(){
        $factory = new UsersFactory();
        $user = $factory->getCurrentUser();
        if($user){
            header("Location: ".self::AUTHORIZED_ZONE_URL);
            die();
        }
    }

    public static function declareSetUpUsersAccessZone(){
        $factory = new UsersFactory();
        $user = $factory->getCurrentUser();
        if($user){
            if($user->status == User::STATUS_SET_UP){
                return;
            }
            
        }
        header("Location: ".self::AUTHORIZED_ZONE_URL);
        die();
    }

    public static function declareAccessZone($accessStatuses = []){
        $factory = new UsersFactory();
        $user = $factory->getCurrentUser();
        if($user){
            if(in_array($user->status,$accessStatuses)){
                return;
            } 
        }
        header("Location: ".self::AUTHORIZED_ZONE_URL);
        die();
    }
    
    const ADMIN_ZONE_URL = '/admin/';
    public static function declareAdminZone(){
        $factory = new UsersFactory();
        $user = $factory->getCurrentAdmin();
        if( is_null($user) ){
            header("Location: " . self::ADMIN_ZONE_URL);
            die();
        }
    }
    
    public static function getProtectedString(string $str): string{
        return addslashes(htmlspecialchars(strip_tags(trim($str))));
    }
    
    public static function protect(string $str){
        return self::getProtectedString($str);
    }
    
}