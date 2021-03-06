<?php
    namespace Classes\Utils;
    
    class DateUtil{
        
        const MINUTE = 60;
        const HOUR = self::MINUTE * 60;
        const DAY = self::HOUR * 24;
        const MONTH = self::DAY * 30;
        const YEAR = self::DAY * 365;
        
        public static function getDay($arg): int{
            return self::getDateByPattern($arg, "d");
        }
        
        public static function getMonth($arg): int{
            return self::getDateByPattern($arg, "m");
        }
        
        public static function getYear($arg): int{
            return self::getDateByPattern($arg, "Y");
        }
        
        public static function toRussianOnlyDate($arg): string{
            $pattern = "d.m.Y";
            return self::getDateByPattern($arg, $pattern);
        }
        
        public static function toRussianFormat($arg, bool $withoutSecs = false): string{
            $pattern = $withoutSecs ? "d.m.Y H:i" : "d.m.Y H:i:s";
            return self::getDateByPattern($arg, $pattern);
        }
        
        public static function toInterNationalFormat($arg, bool $withoutSecs = false): string{
            $pattern = $withoutSecs ? "d-m-Y H:i" : "d-m-Y H:i:s";
            return self::getDateByPattern($arg, $pattern);
        }
        
        public static function toBlogFormat($arg, bool $withoutSecs = false): string{
            $pattern = $withoutSecs ? "%B, %e (%Y) %R" : "%B, %e (%Y) %T";
            return self::getLocalDate($arg, $pattern);
        }
        
        public static function toShortBlogFormat($arg, bool $withoutSecs = false): string{
            $pattern = $withoutSecs ? "%b, %e (%Y) %R" : "%b, %e (%Y) %T";
            return self::getLocalDate($arg, $pattern);
        }
        
        public static function toSqlFormat($arg, bool $withoutSecs = false): string{
            $pattern = $withoutSecs ? "Y-m-d H:i" : "Y-m-d H:i:s";
            return self::getDateByPattern($arg, $pattern);
        }
        
        public static function getDateByPattern($arg, string $pattern): string{
            $time = self::getTimestamp($arg);
            return date($pattern, $time);
        }
        
        public static function getLocalDate($arg, string $pattern): string{
            $time = self::getTimestamp($arg);
            return strftime($pattern, $time);
        }
        
        public static function getTimestamp($arg): int{
            $type = gettype($arg);
            
            switch($type){
                case "integer":
                    return $arg;
                case "string":
                    return strtotime($arg);
            }
        }
        
        public static function toString($arg): string{
            $time = self::getTimestamp($arg);
            $current = time();
            $diff = $current - $time;
            
            if( $diff < self::MINUTE ){
                if( !$diff ){
                    return 'right now';
                }elseif( $diff == 1 ){
                    return $diff . " sec ago";
                }
                return $diff . " secs ago";
            }elseif( $diff < self::HOUR ){
                $amount = floor($diff / self::MINUTE);
                return $amount > 1 ? $amount . ' mins ago' : $amount . ' min ago';
            }elseif( $diff < self::DAY ){
                $amount = floor($diff / self::HOUR);
                return $amount > 1 ? $amount . ' hours ago' : $amount . ' hour ago';
            }elseif( $diff < self::MONTH ){
                $amount = floor($diff / self::DAY);
                return $amount > 1 ? $amount . ' days ago' : $amount . ' day ago';
            }elseif( $diff < self::YEAR ){
                $amount = floor($diff / self::MONTH);
                return $amount > 1 ? $amount . ' months ago' : $amount . ' month ago';
            }else{
                $amount = floor($diff / self::YEAR);
                return $amount > 1 ? 'more then ' . $amount . ' years ago' : 'more then ' . $amount . ' year ago';
            }
        }
        
    }
?>