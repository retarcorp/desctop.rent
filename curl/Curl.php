<?php

namespace curl;

class Curl {

    public static function get(string $path, array $data, array $headers = [], string $cookies = '') {
        $url = $path."?".http_build_query($data);
        return self::execCurl($url, $data, $headers, $cookies);
    }

    public static function post(string $path, array $data, array $headers = [], string $cookies = '') {
        return self::execCurl($path, $data, $headers, $cookies, function($curl, $data){
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        });
    }
    
    public static function delete(string $path, array $data, array $headers = [], string $cookies = '') {
        $url = $path."?".http_build_query($data);
        return self::execCurl($url, $data, $headers, $cookies, function($curl, $data){
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        });
    }
    
    public static function put(string $path, array $data, array $headers = [], string $cookies = '') {
        return self::execCurl($path, $data, $headers, $cookies, function($curl, $data){
            $q = http_build_query($data);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $q);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Length: ' . strlen($q)));
        });
    }
    
    private static function execCurl(string $url, array $data, array $headers, string $cookies, $func = null): array {
        $curl = curl_init($url);
        
        if( is_callable($func) ){
            $func($curl, $data);
        }
        
        $res = [
            "status"=>null
            ,"data"=>""
            ,"headers"=>[]
        ];
        
        self::setCommonOptions($curl, $headers, $cookies, $res);
        
        $res['data'] = curl_exec($curl);
        $res['error'] = curl_error($curl);
        return $res;
    }
    
    private static function setCommonOptions($curl, array $headers, string $cookies, array &$res) {
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, self::retrieveHeadersString($headers));
        curl_setopt($curl, CURLOPT_COOKIE, $cookies);
        
        curl_setopt($curl, CURLOPT_HEADERFUNCTION,
            function($curl, $header) use (&$res){
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                    return $len;
                
                $name = strtolower(trim($header[0]));
                if (!array_key_exists($name, $res['headers']))
                    $res['headers'][$name] = [trim($header[1])];
                else
                    $res['headers'][$name][] = trim($header[1]);
                
                return $len;
            });
    }
    
    private static function retrieveHeadersString($headers) {
        $res = [];
        foreach($headers as $h=>$v){
            $res[]= "$h: $v";
        }
        return $res;
    }
}