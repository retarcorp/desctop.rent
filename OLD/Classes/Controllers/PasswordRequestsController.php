<?php
namespace Classes\Controllers;

use Classes\Models\SharePoint\Licenses\Licenses;
use Classes\Models\SharePoint\Licenses\License;
use Classes\Models\SharePoint\Licenses\LicenseFactory;
use Classes\Models\SharePoint\Rdp\Rdp;
use Classes\Models\SharePoint\Rdp\RdpFactory;
use Classes\Models\Users\User;
use Classes\Models\Users\UsersFactory;
use Classes\Utils\JSONResponse;
use Classes\Models\PasswordRequest\PasswordRequest;
use Classes\Models\PasswordRequest\PasswordRequestFactory;
use Classes\Utils\Safety;

class PasswordRequestsController {

    private const APP_TOKEN = "0cc175b9c0f1b6a831c399e269772661";
    
    private const REQUEST_STATUS_CHECK_ITERATION_TIME = 5;
    private const SLEEP_TIME = 1;

    # @http POST /request/
    public function createPasswordRequest(){
        $prf = new PasswordRequestFactory();
        $password = Safety::getProtectedString($_POST['password']);
        
        Safety::declareProtectedZone();
        
        $user = (new UsersFactory)->getCurrentUser();
        $license = $user->getLicense();
        
        if( is_null($license) ){
            return 'У Вас нет лицензии!';
        }
        
        if( !($prf->isPasswordRequestCreatingAvailable($license)) ){
            return 'Ваш запрос сейчас обрабатывается подождите немного';
        }
        
        $request = $prf->createRequest($license, $password);
        $request->setPropsFromDB();
        
        while($request->status != PasswordRequest::STATUS_PROCESSED){
            sleep(self::REQUEST_STATUS_CHECK_ITERATION_TIME);
            $request->setCurrentStatus();
        }
        
        return $request->toArray();
    }
    
    # @http GET /request/
    public function getPasswordRequest(){
        sleep(self::SLEEP_TIME);
        
        $id = intval($_GET['id']);
        $request = new PasswordRequest($id);
        $request->setPropsFromDB();
        return $request->toArray();
    }

    # @http GET /requests/
    public function getOpenedRequests(){
        if( !isset($_GET['token']) || self::APP_TOKEN != $_GET['token']){
            return JSONResponse::error("Permission denied. You don't have enough rights to complete this action");
        }

        $prf = new PasswordRequestFactory();
        $requests = $prf->getOpenedRequest();
        
        $results = array_map(function($request){
            return $request->toArray();
        }, $requests);

        return JSONResponse::ok($results);
    }

    # @http POST /request/update/
    public function updateRequest(){
        if( !isset($_POST['token']) || self::APP_TOKEN != $_POST['token']){
            return JSONResponse::error("Permission denied. You don't have enough rights to complete this action");
        }

        $id = intval($_POST['id']);
        $request = new PasswordRequest($id);
        $request->setPropsFromDB();
        $status = intval($_POST['status']);
        $message = $_POST['message'];

        $request->status = $status;
        $request->message = $message;
        $request->update();
        
        if( $status == PasswordRequest::STATUS_OK ){
            $user = $request->getLicense()->getOwner();
            $user->status = User::STATUS_SET_UP;
            $user->update();
        }
        
        return JSONResponse::ok($request->toArray());
    }

    # @http GET /request/pending/
    public function getLastPendingRequest(){
        Safety::declareProtectedZone();
        
        $user = (new UsersFactory)->getCurrentUser();
        $license = $user->getLicense();
        
        $prf = new PasswordRequestFactory();
        $request = $prf->getPendingPasswordRequest($license);
        
        if( is_null($request) ){
            return JSONResponse::error('');
        }
        
        $result = $request->setPropsFromDB()->toArray();
        return $result;
    }

}