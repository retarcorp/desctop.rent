<?php

namespace Classes\Controllers;
use Classes\Utils\Curl;
use Classes\Utils\Common;
use Classes\Utils\Safety;
use Classes\Models\SharePoint\Connection\Connector;

class SharePoint{
    
    # @http POST /sharepoint/folder/create/
    public function createFolder(){
        $parentFolder = Safety::getProtectedString($_POST['folder']);
        $name = Safety::getProtectedString($_POST['name']);
        $connector = new Connector();
        $connector->createFolder($parentFolder, $name);
    }
    
}