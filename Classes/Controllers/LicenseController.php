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

class LicenseController {

    # @http POST /license/create/
    public function createLicense(){
        $login = $_POST['login'];
        $uid = intval($_POST['uid']);
        $password = $_POST['password'];
        $content = $_POST['rdpContent'];
        $due_to = $_POST['rdpDueTo']." 12:00:00";
        $ip = $_POST['rdpIp'];
        
        $rdpFactory = new RdpFactory();
        $rdp = $rdpFactory->createRdp($ip, $content, date("Y-m-d H:i:s"), $due_to);
        
        $licenseFactory = new LicenseFactory();
        $license = $licenseFactory->createLicense($uid, $rdp, $login, $password);
        
        return $license->toArray();
    } 

    # @http GET /license/
    public function getLicense() {
        $id = +$_GET['id'];
        $license = new License($id);
        
        $rdp = $license->getRdp()->toArray(); 
        $rdp['content'] = $license->getRdp()->getContent();
        
        return ['license' => $license->toArray(), 'rdp' => $rdp];
    }

    # @http GET /licenses/
    public function getLicenses(){
        $lf = new LicenseFactory;
        $licenses = $lf->getLicenses();
        
        $results = array_map(function($license){
            $rdp = $license->getRdp()->toArray();
            $rdp['content'] = $license->getRdp()->getContent();
            return [
                'license' => $license->toArray(),
                'rdp' => $rdp
            ];
        }, $licenses);
        
        return $results;
    }

    # @http POST /license/update/
    public function updateLicense(){
        $id = +$_POST['id'];
        $license = new License($id);

        $login = $_POST['login'];
        $password = $_POST['password'];
        $uid = $_POST['uid'];
        $prevUserId = $uid ? $uid : $license->getUid();
        $content = $_POST['rdpContent'];
        $due_to = $_POST['rdpDueTo'];
        $ip = $_POST['rdpIp'];

        $license->setLogin($login);
        
        if( trim($password) ){
            $hash = License::getHash($password);
            $license->setPassword($hash);
        }
        
        $license->setUid($uid);
        $license->updateLicense();
        
        $rdp = $license->getRdp();
        $rdp->ip = $ip;
        $rdp->due_to = $due_to;
        $rdp->updateContent($content);
        $rdp->updateRdp();
        
        $user = new User($prevUserId);
        if( $uid ){
            $user->onLicenseAttached();
        }else{
           $user->onLicenseDettached();
        }

        return ['license' => $license->toArray(), 'rdp' => $rdp->toArray()];

    }

    # @http POST /license/delete/
    public function deleteLicense(){
        $id = +$_POST['id'];
        $license = new License($id);
        $rdp = $license->getRdp();
        $rdpFactory = new RdpFactory(); //\
        $rdpFactory->deleteRdp($rdp); //\
        $lf = new LicenseFactory;
        $lf->deleteLicense($license);

        return "Лицензия успешно удалена";


    }

}