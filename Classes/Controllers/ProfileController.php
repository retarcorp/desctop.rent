<?php

namespace Classes\Controllers;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use Classes\Utils\Safety;
use Classes\Models\Users\UsersFactory;
use Classes\Models\Users\ProfileData; //\
use Classes\Models\Users\User;
use Classes\Models\SharePoint\Licenses\Licenses;

class ProfileController {
    
    # @http POST /profile/data/
    public function updateProfileData(){
        # @TODO implement updating user profile data
        Safety::declareProtectedZone();

        $factory = new UsersFactory();
        $user = $factory->getCurrentUser();

        $feature = intval($_POST['feature']);
        $user->feature = $feature;
        
        if( !isset($feature) ){
            throw new \Exception("Проверьте введенные данные");
        }elseif( $feature == User::LEGAL_ENTITY ){
            
            $connection = new \Classes\Vendor\Seldon\Connection();
            $data = $connection->findCompany(trim($_POST['inn']));
            
            if( !($data['companies_list']) || empty($data['companies_list']) ){
                throw new \Exception("Компания с таким ИНН не найдена в реестре индивидуальных предпринимателей и юридических лиц! Пожалуйста, проверьте введенную информацию.");
            }
            
        }elseif( $feature != User::INDIVIDUAL_FACE ){
            throw new \Exception("Тип пользователя не опознан.");
        }
        
        $user->inn = $_POST['inn'];
        $user->email = $_POST['email'];
        $user->update();
        
        $pd = $user->getProfileData();
            
        foreach($_POST as $name => $value){
            if(strpos($name,"field-") === 0){
                $n = explode("-",$name);
                $n = intval($n[1]);
                $pd->data[$n] = $value;
            }
        }
            
        $pd->update();
        $user->onCompanyDataApproved();
            
        if (!Licenses::getLicense($user)){
            Licenses::attachLicense($user);
        }
        
        return 'Выполнено успешно!';
    }
    
    # @http GET /profile/data/inn/
    public function getProfileDataByInn(){
        Safety::declareProtectedZone();
        $inn = $_GET['inn'];
        $connection = new \Classes\Vendor\Seldon\Connection();
        $data = $connection->findCompany($inn);
        if(isset($data['companies_list'])){
            if(count($data['companies_list'])){
                $r = $data['companies_list'][0];
                $res = [
                    "kpp" => $r['kpp']
                    ,"address" => $r['address']
                    ,"region" => $r['region_code']
                    ,"name" => $r['basic']['fullName']
                    ,"ogrn" => $r['basic']['ogrn']
                    ,"status" => $r['basic']['status']['code']
                    ];
                return $res;
            }
        }
        return [];
        
    }
}