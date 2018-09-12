<?php

namespace Classes\Models\Services;

use Classes\Utils\Sql;
use Classes\Utils\Log;
use Classes\Utils\DateUtil;
use Classes\Utils\Common;
use Classes\Exceptions\DesktopRentException;
use Classes\Exceptions\SqlErrorException;
use Classes\Models\Services\Service;

class ServiceFactory {
    
    use \Classes\Traits\ObjectOperations;
    
    public function getServices(int $amount = 0, int $step = 0): array{
        $class = 'Classes\Models\Services\Service';
        return $this->getObjects($class, $amount, $step);
    }
    
    public function createService(string $name, string $description, float $price, int $duration): Service{
        $columns = ['name', 'description', 'price', 'duration', 'created'];
        $values = [$name, $description, $price, $duration, DateUtil::toSqlFormat(time())];
        $class = 'Classes\Models\Services\Service';
        
        return $this->createObject($class, $columns, $values);
    }
    
    public function deleteService(Service $service){
        $this->deleteObject($service);
    }
    
}