<?php

namespace Classes\Controllers;
use Classes\Utils\Curl;
use Classes\Utils\Common;
use Classes\Controllers\SystemExecutor;

class SharePoint{
    
    private const SITE_URL = 'desktoprent.sharepoint.com/sites/Test';
    
    private const APP_CLIENT_ID = '1f8268a8-70dd-491e-90cb-2db9dd6f47d5'; // expires in one year
    private const APP_CLIENT_SECRET_KEY = 'C08blgukiUPV0reXEMKutSGRqT3g07/quteQmg5JjiM=';
    private const APP_NAME = 'test';
    private const APP_URI = '137.117.138.150';
    private const APP_REDIRECT_URI = 'https://137.117.138.150/sharepoint.php';
    
    private const CREATE_FOLDER_URL = 'https://{{url}}/_api/web/folders';
    
    # @http GET /sharepoint/folder/create/
    public function createFolder(){
        header("Content-Type: text/plain");
        
        $url = Common::replace(self::CREATE_FOLDER_URL, ['url' => self::SITE_URL]);
        $system = new SystemExecutor();
        $accessToken = $system->getToken();
        
        $data = [
            '__metadata' => [
                'type' => 'SP.Folder'
            ],
            'ServerRelativeUrl' => '/document library relative url/folder name'
        ];
        
        $body = ['body' => json_encode($data, true)];
        
        $headers = [
            'Authorization' => "Bearer " . $accessToken,
            'X-RequestDigest' => 'form digest value',
            'Accept' => 'application/json;odata=verbose',
            'Content-type' => 'application/json;odata=verbose',
            "Content-length" => "90"

        ];
        
        // print_r($body);
        // die();
        
        $res = Curl::post($url, $body, $headers);
        print_r(json_decode($res['data'], true));
        print_r($res['headers']);
        die();
    }
    
}