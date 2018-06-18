<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

namespace Classes\Controllers;

use Classes\Models\Users\UsersFactory;

class ProfileController {
    
    # @http POST /profile/data/
    public function updateProfileData(/*to read id*/){
        # @TODO implement updating user profile data
        $userData = new User();//\
        var_dump($userData);//\
        $userData->update();//\
    }
}
$profCtrlr = new ProfileController();//\
$profCtrlr->updateProfileData();//\
