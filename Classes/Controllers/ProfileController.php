<?php

namespace Classes\Controllers;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use Classes\Models\Users\UsersFactory;
use Classes\Models\Users\ProfileData; //\

class ProfileController {
    
    # @http POST /profile/data/
    public function updateProfileData(){
        # @TODO implement updating user profile data
        $uid = $_POST['uid']; //\
        $profileData = new ProfileData($uid); //\
        $profileData->item = $_POST['item'];  //\
        $profileData->value = $_POST['value']; //\
        
        $profileData->update();//\
    }
}