<?php

namespace Classes\Models\SharePoint\Licenses;

use Classes\Utils\Sql;
use Classes\Models\SharePoint\Rdp\Rdp;
use Classes\Models\SharePoint\Rdp\RdpConnections;
use Classes\Models\SharePoint\Rdp\RdpFactory;
use Classes\Models\Users\User;

class LicenseFactory{
    
    public function createLicense(int $uid, Rdp $rdp, string $login, string $password){
        $sql = Sql::getInstance();
        $q = "INSERT INTO " . License::TABLE_NAME . "
            (login, pw, rdp, uid)
            VALUES('?', '?', ?, ?)";
        
        # $hash = License::getHash($password);
        $sql->execPrepared($q, [$login, $password, $rdp->id, $uid]);
        
        if($e = $sql->getLastError()){
            # print_r($e);
        }
        
        $id = $sql->getInsertId();
        return new License($id);
    }

    public function deleteLicense(License $license){
        $sql = Sql::getInstance();
        $q = "DELETE FROM " . License::TABLE_NAME . "
            WHERE id = ?";
        $sql->execPrepared($q, [$license->getId()]);
        
    }

    public function getLicenses(): array{
        $sql = Sql::getInstance();
        $q = "SELECT id FROM " . License::TABLE_NAME;
        $ids = $sql->getAssocArray($q);
        $licenses = array_map(function($e){
            $id = +$e['id'];
            return new License($id);
        }, $ids);
        return $licenses;
    }
}

?>