<?php

namespace Classes\Utils;

class Common{
    
    public static function getProtectedString(string $str): string{
        return addslashes(htmlspecialchars(strip_tags($str)));
    }
    
    const DEFAULT_MIN_LENGTH = 12;
    const DEFAULT_MAX_LENGTH = 128;
    const MIN_PASSWORD_LENGTH = 8;
    
    public static function getRandomString(
        $from = self::DEFAULT_MIN_LENGTH,
        $to = self::DEFAULT_MAX_LENGTH
    ): string{
        $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $alphabetLength = strlen($alphabet);
        
        $len = random_int($from, $to);
        $string = '';
        
        for($i = 0; $i < $len; $i++){
            $start = random_int(0, $alphabetLength - 1);
            $char = substr($alphabet, $start,  1);
            $case = random_int(0, 1);
            if( $case ){
                $char = strtolower($char);
            }
            $string .= $char;
        }
        
        return $string;
    }
    
    public static function replace(string $s, array $values): string{
        foreach($values as $key => $value){
            $s = str_replace('{{' . $key. '}}', $value, $s);
        }
        return $s;
    }
    
    public static function isPhoneNumberValid(string $phone): bool{
        # TODO write code
    }
    
    public static function isEmailValid(string $email): bool{
        $emeil = trim($email);
        $pattern = "/[\w\-\d\.\#]{2,}@[\wа-яА-Я]*\.?[\wа-яА-Я]{2,}.[\wа-яА-Я]{2,}/";
        preg_match($pattern, $email, $matches);
        return empty($matches) ? false : true;
    }
    
    public static function isPasswordValid(string $password): bool{
        return strlen($password) >= self::MIN_PASSWORD_LENGTH;
    }
    
    public static function getHash(string $str): string{
        return md5($str);
    }
    
}