<?php
namespace Classes\Utils;

use Classes\Models\Users\UsersFactory;

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
}