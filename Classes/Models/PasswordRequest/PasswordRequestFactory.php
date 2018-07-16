<?php
namespace Classes\Models\PasswordRequest;

use Classes\Utils\Sql;
use Classes\Models\PasswordRequest\PasswordRequest;

use Classes\Models\SharePoint\Licenses\Licenses;
use Classes\Models\SharePoint\Licenses\License;
use Classes\Models\Users\UsersFactory;

class PasswordRequestFactory {
    
    private $sql;
    
    public function __construct(){
        $this->sql = new Sql();
    }
    
    public function getEmail() {
        $u = new UsersFactory();
        $u->getCurrentUser();
    }
    
    /*public function createRequest($license ??){
        $this->sql->query("INSERT INTO ".PasswordRequest::TABLE_NAME." (created_at, license_id, email, new_pw, status, message) 
            VALUES (now(),".User::STATUS_JUST_CREATED.",'".."', ' ',".User::INDIVIDUAL_FACE.")");
        // 11111
    }*/
    
    public function getOpenedRequest(/*$license*/) {
        $data = $this->sql->getAssocArray("select * from ".PasswordRequest::TABLE_NAME." where status=".PasswordRequest::REQUEST_OPENED."");
        $arr = [];
        
        foreach ($data as $i=>$value) {
            //$arr[$i] = $data[$i];
            $arr[$i] = PasswordRequest::arrayToInstance($value);;
        }
        return $arr;
    }
}