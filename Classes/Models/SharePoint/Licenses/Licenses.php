<?php

namespace Classes\Models\SharePoint\Licenses;

use Classes\Utils\Sql;
use Classes\Models\Users\User;
use Classes\Models\SharePoint\Licenses\License;

use Classes\Utils\Log;

class Licenses{

    public static function getLicense(User $u): ?License {
        $sql = Sql::getInstance();
        $id = $u->id;

        $r = $sql->getAssocArray("SELECT id FROM ".License::TABLE_NAME." WHERE uid=$id");
        if(!count($r)){
            return null;
        }
        return new License(intval($r[0]['id']));
    }
    
    public static function attachLicense(User $u): ?License {
        $sql = Sql::getInstance();
        $r = $sql->getAssocArray("SELECT id FROM ".License::TABLE_NAME." WHERE uid=0 OR uid={$u->id}");
        
        if(!count($r)){
            Log::error("No free license found for user ".($u->id));
            return null;
        }
        
        $license = $r[0]['id']*1;
        $sql->query("UPDATE ".License::TABLE_NAME." SET uid={$u->id} WHERE id=$license");
        $u->onLicenseAttached();
        return new License($license);
        
    }
}