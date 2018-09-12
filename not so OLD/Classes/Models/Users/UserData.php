<?php

namespace Classes\Models\Users;

use Classes\Utils\Sql;
use Classes\Utils\Log;
use Classes\Utils\DateUtil;
use Classes\Utils\Common;
use Classes\Utils\Sms;
use Classes\Exceptions\DesktopRentException;
use Classes\Models\Users\User;

class UserData {
    
    public const TABLE_NAME = '_users_info';
    /*
        # id INT UNSIGNED
        # user_id INT
        # first_name VARCHAR(32)
        # last_name VARCHAR(32)
        # patronymic VARCHAR(32)
        # inn VARCHAR(32) 
    */
    
    protected const PROPS_COLUMNS_INFO = [
        'user_id' => ['alias' => 'userId', 'type' => 'int', 'get'],
        'first_name' => ['alias' => 'name', 'type' => 'str', 'get', 'set'],
        'last_name' => ['alias' => 'surname', 'type' => 'str', 'get', 'set'],
        'patronymic' => ['type' => 'str', 'get', 'set'],
        'inn' => ['type' => 'str', 'get', 'set'],
    ];
    
    use \Classes\Traits\Entity;
    
    const COOKIE_NAME = 'desktoprent_user';
    const COOKIE_LIFE_TIME = 3600 * 24 * 7;
    
    const AUTH_STATUS_UNAUTHORIZED = 0;
    const AUTH_STATUS_AUTHORIZED = 1;
    
    private $id;
    private $userId;
    private $name;
    private $surname;
    private $patronymic;
    private $inn;
    
    const NUMBERS_AMOUNT_IN_RU_PHONE_NUMBER = 11;
    const NUMBERS_AMOUNT_IN_BY_PHONE_NUMBER = 12;
    
    public static function getValidPhone(string $phone): ?string{
        if( UserData::isRuPhone($phone) ){
            return UserData::getValidatedRuPhone($phone);
        }elseif( UserData::isByPhone($phone) ){
            return UserData::getValidatedByPhone($phone);
        }
        return null;
    }
    
    public static function isRuPhone(string $phone): bool{
        $pattern = '/([\d])/';
        preg_match_all($pattern, $phone, $matches);
        $numbers = $matches[1];
        return count($numbers) == self::NUMBERS_AMOUNT_IN_RU_PHONE_NUMBER 
            && ($numbers[0] == '8' || $numbers[0] == '7');
    }
    
    public static function isByPhone(string $phone): bool{
        $pattern = '/\+?\s?(375)[\s\-]*[\(\)]?([\d]{2})[\(\)]?[\s\-]*([\d]{2,3})[\s\-]*([\d]{2})[\s\-]*([\d]{2,3})/';
        preg_match_all($pattern, $phone, $matches);
        unset($matches[0]);
        
        $numsAmount = 0;
        foreach($matches as $match){
            if(empty($match)){
                return false;
            }
            $numsAmount += strlen($match[0]);
        }
        
        return $numsAmount == self::NUMBERS_AMOUNT_IN_BY_PHONE_NUMBER;
    }
    
    public static function getValidatedRuPhone(string $phone): string{
        $pattern = '/([\d])/';
        preg_match_all($pattern, $phone, $matches);
        $numbers = $matches[1];
        
        if( $numbers[0] == '8' ){
            $numbers[0] = '7';
        }
        $numbers[0] = '+' . $numbers[0];
        
        return implode("", $numbers);
    }
    
    public static function getValidatedByPhone(string $phone): string{
        $pattern = '/\+?\s?(375)[\s\-]*[\(\)]?([\d]{2})[\(\)]?[\s\-]*([\d]{2,3})[\s\-]*([\d]{2})[\s\-]*([\d]{2,3})/';
        preg_match_all($pattern, $phone, $matches);
        unset($matches[0]);
        return '+' . array_reduce($matches, function($carry, $curr){
            return $carry . implode('', $curr);
        }, '');
    }
    
}

