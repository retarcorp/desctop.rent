<?php

namespace Classes\Utils;

class Curl{

    public static function get(string $path, array $data, array $headers = []){
        $curl = curl_init($path."?".http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, self::retrieveHeadersString($headers));
        
        $res = [
            "status"=>null
            ,"data"=>""
            ,"headers"=>[]
        ];
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
        $res['data'] = curl_exec($curl);
        $res['error'] = curl_error($curl);
        return $res;
    }

    public static function post(string $path, array $data, array $headers = []){
        $curl = curl_init($path);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, self::retrieveHeadersString($headers));
        
        $res = [
            "status"=>null
            ,"data"=>""
            ,"headers"=>[]
        ];
        
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
        
        $res['data'] = curl_exec($curl);
        $res['error'] = curl_error($curl);
        return $res;
    }
    
    private static function retrieveHeadersString($headers){
        $res = [];
        foreach($headers as $h=>$v){
            $res[]= "$h: $v";
        }
        return $res;
    }
}