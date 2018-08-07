<?php

namespace Classes\Controllers;

use Classes\Models\Users\User;
use Classes\Models\Users\UsersFactory;
use Classes\Models\Services\Service;
use Classes\Models\Services\ServiceFactory;
use Classes\Utils\Safety;

class ServiceController {
    
    use \Classes\Traits\ControllerActions;
    
    # @http GET /service/
    public function getService(){
        $id = intval($_GET['id']);
        $service = new Service($id);
        $service->setPropsFromDB();
        return $service->toArray();
    }
    
    # @http GET /services/
    public function getServices(){
        $amount = isset($_GET['amount']) ? intval($_GET['amount']) : 0;
        $step = isset($_GET['step']) ? intval($_GET['step']) : 0;
        
        $sf = new ServiceFactory();
        $services = $sf->getServices($amount, $step);
        return $this->serializeObjects($services, true);
    }
    
    # @http POST /service/
    public function createService(){
        Safety::declareAdminZone();
        $sf = new ServiceFactory();
        
        $name = Safety::protect($_POST['name']);
        $description = Safety::protect($_POST['description']);
        $price = floatval($_POST['price']);
        $duration = intval($_POST['duration']);
        
        $service = $sf->createService($name, $description, $price, $duration);
        $service->setPropsFromDB();
        return $service->toArray();
    }
    
    # @http POST /service/edit/
    public function updateService(){
        $id = intval($_POST['id']);
        $service = new Service($id);
        $service->setPropsFromDB();
        
        if( isset($_POST['name']) ){
            $name = Safety::protect($_POST['name']);
            $service->setName($name);
        }
        
        if( isset($_POST['description']) ){
            $description = Safety::protect($_POST['description']);
            $service->setDescription($description);
        }
        
        if( isset($_POST['price']) ){
            $price = floatval($_POST['price']);
            $service->setPrice($price);
        }
        
        if( isset($_POST['price']) ){
            $duration = intval($_POST['duration']);
            $service->setDuration($duration);
        }
        
        $service->update();
        return $service->toArray();
    }
    
    # @http DELETE /service/
    public function deleteService(){
        Safety::declareAdminZone();
        $sf = new ServiceFactory();
        
        $id = intval($_GET['id']);
        $service = new Service($id);
        $sf->deleteService($service);
        return 'Выполнено успешно';
    }
    
    # @http GET /user/services/
    public function getUserServices(){
        Safety::declareProtectedZone();
        $uf = new UsersFactory();
        $user = $uf->getCurrentUser();
        $services = $user->getServices();
        return $this->serializeObjects($services, true);
    }
    
    # @http POST /user/service/
    public function addService(){
        Safety::declareProtectedZone();
        $uf = new UsersFactory();
        $user = $uf->getCurrentUser();
        
        $id = intval($_POST['id']);
        $service = new Service($id);
        $user->addService($service);
        return 'Выполнено успешно';
    }
    
}