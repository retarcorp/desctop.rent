<?php

namespace Classes\Controllers;

use Classes\Utils\RegExp;
use Classes\Utils\Safety;
use Classes\Utils\Sms;
use Classes\Models\Users\UsersActions;
use Classes\Models\Users\User;
use Classes\Models\Users\UserData;
use Classes\Exceptions\DesktopRentException;

class AuthController {
    
    private function getValidatedPhoneOrThrowException(string $phone){
        $phone = UserData::getValidPhone($phone);
        Safety::checkPhone($phone);
        return $phone;
    }

    # @http GET /auth/phone/entered/
    public function onPhoneEntered(){
        $phone = $this->getValidatedPhoneOrThrowException($_GET['phone']);
        
        $actions = new UsersActions();
        $user = $actions->getUserByPhone($phone);
        
        if( is_null($user) ){
            $user = $actions->registerUser($phone);
        }
        
        $user->clearSmsCodes();
        $code = Sms::generateSmsCode();
        $user->addSmsCode($code);
        
        $user->setPropsFromDB();
        Sms::send($user->getPhone(), Sms::getMessage(Sms::LOGIN_CODE, $code));
        return 'Выполнено успешно';
    }
    
    # @http GET /auth/phone/sms/validate/
    public function validateSms(){
        $phone = $this->getValidatedPhoneOrThrowException($_GET['phone']);
        $code = $_GET['code'];
        Safety::protect($code);
        
        $actions = new UsersActions();
        $user = $actions->getUserByPhone($phone);
        Safety::checkExistance($user);
        
        if( !($user->checkSmsCode($code)) ){
            throw new DesktopRentException('Код неверный!');
        }
        
        $user->clearSmsCodes();
        $user->auth();
        return 'Выполнено успешно';
    }
    
    const APP_TOKEN = '0cc175b9c0f1b6a831c399e269772661';
    
    # @http POST /auth/full/
    public function setFullAuthorized(){
        $phone = $this->getValidatedPhoneOrThrowException($_POST['phone']);
        if( $_POST['token'] == self::APP_TOKEN ){
            throw new DesktopRentException('В доступе отказано');
        }
        
        $actions = new UsersActions();
        $user = $actions->getUserByPhone($phone);
        Safety::checkExistance($user);
        
        $user->authStatus = User::AUTH_STATUS_AUTHORIZED;
        $user->update();
        return 'Выполнено успешно';
    }
    
    # @http GET /logout/
    public function logout(){
        $actions = new UsersActions();
        $current = $actions->getCurrentUser();
        $current->logout();
        return 'Выполнено успешно';
    }
    
}