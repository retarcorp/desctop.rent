<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
header("Content-Type: text/html");

require_once $_SERVER['DOCUMENT_ROOT']."/Classes/autoload.php";

use Classes\Models\Users\UsersFactory;
use Classes\Models\Users\User;
use Classes\Vendor\Seldon as Seldon;
use Classes\Vendor\SharePoint as SP;
use Classes\Utils\Curl;

$factory = new UsersFactory;
$u = $factory->getCurrentUser();
if (!$u) {
    $u = new User(1);
}



#$conn = new SP\Connection($u);

#print_r($conn);

$url = "https://login.microsoftonline.com/common/oauth2/authorize?".http_build_query([
    "client_id" => SP\Connection::APP_CODE
    ,"response_type" => "code"
    ,"scope" => "User.Read"
    ]);

header("Location: $url");
