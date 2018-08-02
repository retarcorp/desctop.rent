<?php

namespace Classes\Models\SharePoint\Connection;
use Classes\Utils\Sql;
use Classes\Utils\System;
use Classes\Exceptions\DesktopRentException;
use Classes\Exceptions\AlreadyExistsException;
use Classes\Exceptions\NotFoundException;
use Classes\Exceptions\UnknownActionException;
use Classes\Models\SharePoint\Connection\Actions;
use Classes\Models\SharePoint\Connection\Credentials;
use Classes\Models\SharePoint\Connection\JSONResults;

/** Class for connecting with C# library to complete basic operations with files and folders */
class Connector{
    
    private $executor = null;
    
    public function __construct(){
        $this->executor = new System();
    }
    
    public function setProgramCredentials(){
        
    }
    
    public function launchProgram(){
        $args = func_get_args();
        print_r($args);
        return $this->executor->getResult(Credentials::PROGRAMM_LAUNCHER_PATH . " " . implode(" ", $args));
    }
    
    /**
     * @param string $response JSON, which was obtained from C# program.
     * @throws AlreadyExistsException Exception is occured when requested fileName or folderName are alredy exist.
     * @throws NotFoundException Exception is occured when requested fileName or folderName are not found.
     * @throws UnknownActionException Exception is occured when was requested unknown action or was an error in C# program.
     * @throws DesktopRentException Exception is occured when was an error in C# program.
     * @return string Result's data.
     */
    public function handleProgramResult(string $response){
        $results = json_decode($resposne, true);
        
        if( $results['status'] == JSONResults::STATUS_ERROR ){
            
            switch($results['code']){
                case JSONResults::ALREADY_EXISTS_ERROR:
                    throw new AlreadyExistsException($resulsts['message']);
                    
                case JSONResults::NOT_FOUND_ERROR:
                    throw new NotFoundException($resulsts['message']);
                    
                case JSONResults::UNKNOWN_ACTION_ERROR:
                    throw new UnknownActionException($results['message']);
                    
                case JSONResults::UNRECOGNIZED_ERROR:
                    throw new DesktopRentException($resulsts['message']);
                    
                default:
                    throw new DesktopRentException("Произошла внутрення непредвиденная ошибка в C# программе.");
            }
            
        }else{
            return $results['data'];
        }
    }
    
    /**
     * @param string $folderPath This is absolute path to parent folder, in which you want to create a new folder.
     * @param string $folderName This is name of a new fodler.
     * @throws AlreadyExistsException Exception is occured when folder with such name is already exists in a parent folder.
     * @return void
     */
    public function createFolder(string $folderPath, string $folderName){
        $response = $this->launchProgram(Actions::CREATE_FOLDER, $folderPath, $folderName);
        print_r($response);
        return $this->handleProgramResult($response);
    }
    
    /**
     * @param string $folderPath This is absolute path to a folder.
     * @throws NotFoundException Exception is occured when folder for such path is not found.
     * @return void
     */
    public function deleteFolder(string $folderPath){
        $response = $this->launchProgram(Actions::DELETE_FOLDER, $folderPath);
        return $this->handleProgramResult($response);
    }
    
    /**
     * @param string $folderPath This is absolute path to a folder.
     * @param string $name New name of a folder.
     * @throws NotFoundException Exception is occured when folder for such path is not found.
     * @throws AlreadyExistsException Exception is occured when folder with such name are already exists.
     * @return void
     */
    public function renameFolder(string $folderPath, string $name){
        $response = $this->launchProgram(Actions::RENAME_FOLDER, $folderPath, $name);
        return $this->handleProgramResult($response);
    }
    
    /**
     * @param string $folderPath This is absolute path to a folder.
     * @throws NotFoundException Exception is occured when folder for such path is not found.
     * @return array Array of names of folders and files from this folder.
     */
    public function getFolderContent(string $folderPath): array{
        $response = $this->launchProgram(Actions::GET_CONTENT_FROM_FOLDER, $folderPath);
        return $this->handleProgramResult($response);
    }
    
    /**
     * @param string $from This is absolute path to a folder, which you want to be copied.
     * @param string $to This is absolute path to a folder, in which you want copy a folder.
     * @throws NotFoundException Exception is occured when folder for any path is not found.
     * @throws AlreadyExistsException Exception is occured when folder with such name are already exists.
     * @return void
     */
    public function copyFolder(string $from, string $to){
        $response = $this->launchProgram(Actions::COPY_FOLDER, $from, $to);
        return $this->handleProgramResult($response);
    }
    
    /**
     * @param string $from This is absolute path to a folder, which you want to be moved.
     * @param string $to This is absolute path to a folder, in which you want move a folder.
     * @throws NotFoundException Exception is occured when folder for any path is not found.
     * @throws AlreadyExistsException Exception is occured when folder with such name are already exists.
     * @return void
     */
    public function replaceFolder(string $from, string $to){
        $response = $this->launchProgram(Actions::REPLACE_FOLDER, $from, $to);
        return $this->handleProgramResult($response);
    }
    
    /**
     * @param string $localPath This is absolute path to a file from which this file can be uploaded.
     * @param string $folderPath This is absolute path to a folder, in which you want to upload a file.
     * @throws NotFoundException Exception is occured when file or folder are not found.
     * @throws AlreadyExistsException Exception is occured when file with such name is already exists.
     * @return void
     */
    public function uploadFile(string $localPath, string $folderPath){
        $response = $this->launchProgram(Actions::UPLOAD_FILE, $localPath, $folderPath);
        return $this->handleProgramResult($response);
    }
    
    /**
     * @param string $path This is absolute path to a file.
     * @throws NotFoundException Exception is occured when is are not found.
     * @return void
     */
    public function deleteFile(string $path){
        $response = $this->launchProgram(Actions::DELETE_FILE, $path);
        return $this->handleProgramResult($response);
    }
    
    /**
     * @param string $path This is absolute path to a file.
     * @param string $name This is name of a file.
     * @throws NotFoundException Exception is occured when file is not found.
     * @return void
     */
    public function renameFile(string $path, string $name){
        $response = $this->launchProgram(Actions::RENAME_FILE, $path, $name);
        return $this->handleProgramResult($response);
    }
    
    /**
     * @param string $path This is absolute path to a file.
     * @throws NotFoundException Exception is occured when file is not found.
     * @throws AlreadyExistsException Exception is occured when file with such name are already exists.
     * @return string Content of a file.
     */
    public function getFileContent(string $path): string{
        $response = $this->launchProgram(Actions::GET_CONTENT_FROM_FILE, $path);
        return $this->handleProgramResult($response);
    }
    
    /**
     * @param string $from This is absolute path to a file.
     * @param string $to This is absolute path of a folder.
     * @throws NotFoundException Exception is occured when file is not found.
     * @throws AlreadyExistsException Exception is occured when file with such name are already exists in this folder.
     * @return void
     */
    public function copyFile(string $from, string $to){
        $response = $this->launchProgram(Actions::COPY_FILE, $from, $to);
        return $this->handleProgramResult($response);
    }
    
    /**
     * @param string $from This is absolute path to a file.
     * @param string $to This is absolute path of a folder.
     * @throws NotFoundException Exception is occured when file is not found
     * @throws AlreadyExistsException Exception is occured when file with such name is already exists in this folder.
     * @return void
     */
    public function moveFile(string $from, strign $to){
        $response = $this->launchProgram(Actions::MOVE_FILE, $from, $to);
        return $this->handleProgramResult($response);
    }
    
}