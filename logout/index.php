<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once $_SERVER['DOCUMENT_ROOT']."/Classes/autoload.php";

use Classes\Models\Users\UsersActions;

(new UsersActions())->getCurrentUser()->logout();
