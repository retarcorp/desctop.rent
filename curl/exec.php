<?php

    require_once $_SERVER['DOCUMENT_ROOT']."/Core/Global.php";

    use curl\Curl;
    
    function validateBySplitters(string $haystack, string $splitter1, string $splitter2): array{
        if( !trim($haystack) ){
            return [];
        }
        
        $params = [];
        $data = explode($splitter1, trim($haystack));
        
        foreach($data as $i => $pair){
            if( !empty($pair) ){
                $d = explode($splitter2, trim($pair));
                $params[$d[0]] = $d[1];
            }
        }
        return $params;
    }
    
    function validateSearchParams(string $query): array{
        return validateBySplitters($query, '&', '=');
    }
    
    function validateHeaders(string $info): array{
        return validateBySplitters($info, ';', ':');
    }
    
    
    
    
    $cookies = $_POST['cookies'];
    $headers = validateHeaders($_POST['headers']);
    
    switch($_POST['method']){
        
        case "GET":
            $urlParts = parse_url($_POST['path']);
            
            $path = $urlParts['path'] ?? $_POST['path'];
            $query = $urlParts['query'] ?? '';
            $params = validateSearchParams($query);
            
            $res = Curl::get($path, $params, $headers, $cookies);
            break;
        
        case "DELETE":
            $urlParts = parse_url($_POST['path']);
            
            $path = $urlParts['path'];
            $query = $urlParts['query'] ?? '';
            $params = validateSearchParams($query);
            $res = Curl::delete($path, $params, $headers, $cookies);
            break;
            
        case "POST":
            $path = $_POST['path'];
            $params = validateSearchParams($_POST['body']);
            $res = Curl::post($path, $params, $headers, $cookies);
            break;
            
        case "PUT":
            $path = $_POST['path'];
            $params = validateSearchParams($_POST['body']);
            $res = Curl::put($path, $params, $headers, $cookies);
            break;
        
        default:
            $res = 'Method is not implemented yet';
    }
    
    print_r($res);

?>