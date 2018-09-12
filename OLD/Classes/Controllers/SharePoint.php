<?php

namespace Classes\Controllers;
use Classes\Utils\Curl;
use Classes\Utils\Common;
use Classes\Utils\Safety;
use Classes\Models\SharePoint\Connection\Connector;

class SharePoint {
    
    public $connector;

    public function __construct() {
        $this->connector = new Connector();
    }

    # @http POST /sharepoint/folder/create/
    public function createFolder(){
        $parentFolder = Safety::getProtectedString($_POST['folder']);
        $name = Safety::getProtectedString($_POST['name']);
        $this->connector->createFolder($parentFolder, $name);
    }

    # @http POST /sharepoint/folder/getContent/
    public function getFolderContent(){
        $folder = Safety::getProtectedString($_POST['folder']);
        $this->connector->getFolderContent($parentFolder);
    }
    
    # @http POST /sharepoint/folder/delete/
    public function deleteFolder(){ //\
        $folder = Safety::getProtectedString($_POST['folder']);
        $this->connector->deleteFolder($folder);
    }

    # @http POST /sharepoint/folder/rename/
    public function renameFolder() {
        $folder = Safety::getProtectedString($_POST['folder']);
        $newName = Safety::getProtectedString($_POST['new_name']);
        $this->connector->renameFolder($folder, $name);
    }

    # @http POST /sharepoint/folder/rename/copy/
    public function copyFolder() {
        $from = Safety::getProtectedString($_POST['from']);  
        $to = Safety::getProtectedString($_POST['to']);  
        $this->connector->renameFolder($from, $to);
    }

    # @http POST /sharepoint/folder/replace/
    public function replaceFolder(){
        $from = Safety::getProtectedString($_POST['from']);  
        $to = Safety::getProtectedString($_POST['to']);  
        $this->connector->replaceFolder($from, $to);
     }

    # @http POST /sharepoint/file/upload/
    public function uploadFile(){
        $localPath = Safety::getProtectedString($_POST['local_path']);
        $folderPath = Safety::getProtectedString($_POST['folder_path']);
        $this->connector->uploadFile($localPath, $folderPath);
    }

    # @http DELETE /sharepoint/file/delete/
    public function deleteFile(){
        $file = Safety::getProtectedString($_POST['file']);
        $this->connector->deleteFile($file);
    }

    # @http POST /sharepoint/file/rename/
    public function renameFile(){
        $file = Safety::getProtectedString($_POST['file']);
        $newName = Safety::getProtectedString($_POST['new_name']);
        $this->connector->renameFile($file, $newName);
    }

    # @http POST /sharepoint/file/getContent/
    public function getFileContent() {
        $file = Safety::getProtectedString($_POST['file']);
        $this->connector->getFileContent($file);
    }

    # @http POST /sharepoint/file/copy/
    public function copyFile() {
        $file = Safety::getProtectedString($_POST['file']);
        $newFolder = Safety::getProtectedString($_POST['new_folder']);
        $this->connector->copyFile($file, $newFolder);
    }

    # @http POST /sharepoint/file/move/
    public function moveFile() {
        $file = Safety::getProtectedString($_POST['file']);
        $folder = Safety::getProtectedString($_POST['folder']);
        $this->connector->moveFile($file, $folder);
    }
}