<?php

namespace Classes\Models\PasswordRequest;
use Classes\Utils\Sql;

class PasswordRequest {
    
    const TABLE_NAME = "password_request";
    
    const REQUEST_OPENED = 0;
    const REQUEST_PROCESSED = 1;
    const REQUEST_OK = 2;
    const REQUEST_ERROR = 3;

    private $sql = null;

    public $id;
    public $created;
    public $licenseId;
    public $email;
    public $newPassword;
    public $status;
    public $message;
    
    public function __construct(int $id){
        $this->id = $id;
        $this->sql = Sql::getInstance();
    }

    public function setPropsFromDB(): self{
        $q = "SELECT * FROM " . self::TABLE_NAME . "
            WHERE id = $id";
        $data = $this->sql->getAssocArray($q);

        if( empty($data) ){
            throw new \Exception("There is no such request $id in DB");
        }

        $data = $data[0];
        $this->setProps($data);
        return $this;
    }

    private function setProps(array $data){
        $this->created = $data['created_at'];
        $this->licenseId = intval($data['license_id']);
        $this->email = $data['email'];
        $this->newPassword = $data['new_pw'];
        $this->status = intval($data['status']);
        $this->message = $data['message'];
    }

    public function update(){
        
    }

    public function toArray(): array{
        $arr = [];
        foreach($this as $prop => $value){
            if($prop != 'sql'){
                $arr[$prop] = $value;
            }
        }
        return $arr;
    }

    public static function arrayToInstance(array $data): PasswordRequest{
        $id = intval($data['id']);
        $request = new PasswordRequest($id);
        $request->setProps($data);
        return $request;
    }

}