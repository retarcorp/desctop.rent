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

class PasswordRequestsController {

    private const APP_TOKEN = "0cc175b9c0f1b6a831c399e269772661";

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
        return JSONResponse::ok($request->toArray());
    }

}