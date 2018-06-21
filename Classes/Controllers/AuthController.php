<?php

namespace Classes\Controllers;

use Classes\Models\Users\UsersFactory;

class AuthController{

    # @http GET /test/
    public function testMethod(){
        return ["Hello" => "World"];
    }

    # @http GET /test/error/
    public function testError(){
        throw new \Exception("Test error has occured!");
    }

    # @http GET /auth/phone/entered/
    public function onPhoneEntered(){
        $phone = trim($_GET['phone']);
        $factory = new UsersFactory();
        # Check if phone is valid
        if(!$factory->isPhoneValid($phone)){
            throw new \Exception("Номер телефона введен в неверном формате!");
        }

        # Insert or update user with sms code and set pending status
        $factory -> insertOrUpdate($phone);
        return ["result" => "OK"];
    }
    
    # @http GET /auth/phone/sms/validate/
    public function validateSms(){
        $code = $_GET['code'];
        $factory = new UsersFactory();
        $user = $factory->getUserBySmsCode($code);

        if(!$user){
            throw new \Exception("Неверный СМС-код!");
        }

        $factory->auth($user);
        return $user->id;
    }
}