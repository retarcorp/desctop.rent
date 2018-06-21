<?php

namespace Classes\Controllers;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use Classes\Utils\Safety;
use Classes\Models\Users\UsersFactory;
use Classes\Models\Users\ProfileData; //\

class ProfileController {
    
    # @http POST /profile/data/
    public function updateProfileData(){
        # @TODO implement updating user profile data
        
        Safety::declareProtectedZone();

        $factory = new UsersFactory();
        $user = $factory->getCurrentUser();

        $pd = $user->getProfileData();

        $user->inn = $_POST['inn'];
        $user->email = $_POST['email'];
        
        foreach($_POST as $name => $value){
            if(strpos($name,"field-") === 0){
                $n = explode("-",$name);
                $n = intval($n[1]);
                $pd->data[$n] = $value;
            }
        }
        
        $pd->update();

        # @TODO here is launched Seldon company check system
    }
}