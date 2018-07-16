<?php
ini_set('display_errors',1);
require_once $_SERVER['DOCUMENT_ROOT']."/Core/Global.php";

use Classes\Utils\Safety;

Safety::declareProtectedZone();

use Classes\Models\Users\UsersFactory;
use Classes\Models\Users\User;
use Classes\Models\SharePoint\Licenses\Licenses;
use Classes\Models\SharePoint\Licenses\License;
use Classes\Models\SharePoint\Rdp;



$factory = new UsersFactory();
$user = $factory->getCurrentUser();

$license = Licenses::getLicense($user);

if(is_null($license)){
    die('У Вас нет лицензии');
}

$rdp = $license->getRdp();
$content = $rdp->getContent();


header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($rdp->ip.".rdp").'"');
header('Content-Length: '.strlen($content));

$domain = $rdp->ip;

echo trim($content);
echo "\r\nusername:s:".$license->getLogin();