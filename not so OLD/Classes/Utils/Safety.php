<?php
namespace Classes\Utils;

use Classes\Models\Users\UsersActions;
use Classes\Models\Users\User;
use Classes\Exceptions\DesktopRentException;

class Safety {

    public static function checkAuth($user){
        if( is_null($user) ){
            throw new DesktopRentException("Пользователь не авторизован");
        }
    }
    
    public static function checkExistance($user){
        if( is_null($user) ){
            throw new DesktopRentException("Пользователь не найден");
        }
    }
    
    public static function checkPhone($phone){
        if( is_null($phone) ){
            throw new DesktopRentException("Номер телефона введен в неверном формате!");
        }
    }
    
    public static function getProtectedString(string $str): string{
        return htmlspecialchars(strip_tags(trim($str)));
    }
    
    public static function protect(string &$str){
        $str = self::getProtectedString($str);
    }
    
}