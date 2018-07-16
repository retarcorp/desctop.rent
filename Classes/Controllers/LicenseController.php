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
        $password = $_POST['password'];
        $content = $_POST['content'];
        $created_at = $_POST['created_at'];
        $due_to = $_POST['due_to'];
        $ip = $_POST['ip'];
        
        $uf = new UsersFactory();
        $user = $uf->getCurrentUser();
        
        if (is_null($user)){
            return JSONResponse::error('Пользователь не авторизован');
        }
        
        $rdpFactory = new RdpFactory();
        $rdp = $rdpFactory->createRdp($ip, $content, $created_at, $due_to);
        
        $licenseFactory = new LicenseFactory();
        $license = $licenseFactory->createLicense($user, $rdp, $login, $password);
        
        return JSONResponse::ok($license->toArray());
    } 

    # @http GET /license/
    public function getLicense() {
        $id = +$_GET['id'];
        $license = new License($id);
        // $uf = new UsersFactory();
        // $user = $uf->getCurrentUser();

        // if ($license->uid != $user->id){
        //     return JSONResponse::error('У Вас недстаточно прав');
        // }

        //$rdp = new Rdp($license->rdp);
        $rdp = new Rdp($license->getRdp()); // спросить про геттер

        return JSONResponse::ok(['license' => $license->toArray(), 'rdp' => $rdp->toArray()]);
    }

    # @http POST /license/update/
    public function updateLicense(){
        $id = +$_POST['id'];
        $license = new License($id);

        $login = $_POST['login'];
        $password = $_POST['password'];
        $rdpId = $_POST['rdp']; //\
        $uid = $_POST['uid']; //\
        $content = $_POST['content'];
        $created_at = $_POST['created_at'];
        $due_to = $_POST['due_to'];
        $ip = $_POST['ip'];

        //$license->login = $login;
        $license->setLogin($login);
        $license->setPassword($password);
        $license->setRdp($rdpId);
        $license->setUid($uid);
        $license->updateLicense();
        
        $rdp = new Rdp($license->getRdp());
        $rdp->ip = $ip;
        $rdp->created_at = $created_at; //\
        $rdp->due_to = $due_to; //\
        $rdp->updateContent($content);
        $rdp->updateRdp();

        return JSONResponse::ok(['license' => $license->toArray(), 'rdp' => $rdp->toArray()]);

    }

    # @http DELETE /license/
    public function deleteLicense(){
        $id = +$_GET['id'];
        $license = new License($id);
        $rdp = new Rdp($license->getRdp());
        $rdpFactory = new RdpFactory(); //\
        $rdpFactory->deleteRdp($rdp); //\
        $lf = new LicenseFactory;
        $lf->deleteLicense($license);

        return JSONResponse::ok("Лицензия успешно удалена");


    }

}