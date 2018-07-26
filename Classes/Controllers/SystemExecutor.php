<?php

namespace Classes\Controllers;

use Classes\Utils\System;

class SystemExecutor {
    
    private const PROGRAMM_LAUNCHER_PATH = "C:\inetpub\desktop.rent\ConsoleApiWorker\Token.exe";
    
    private $executor = null;
    
    public function __construct(){
        $this->executor = new System();
    }
    
    public function getToken(){
        return $this->executor->getResult(self::PROGRAMM_LAUNCHER_PATH)[0];
    }
    
}