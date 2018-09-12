<?php

namespace Classes\Controllers;
use Classes\Utils\Curl;
use Classes\Utils\Common;
use Classes\Utils\Safety;
use Classes\Exceptions\RequiredPropertyException;

class FileManagerController {
    
    # @http POST /filemanager/folder/create/
    public function createFolder(){
        $parentFolder = Safety::protect($_POST['parentFolder']);
        $name = Safety::protect($_POST['name']);
        //$model->createFolder($parentFolder, $name);
        return 'Выполнено успешно!';
    }

    # @http GET /filemanager/folder/content/
    public function getFolderContent(){        
        $folder = Safety::protect($_GET['folder']);
        //$model->getFolderContent($folder);
        $content = [];
        if($folder == "/") $content = [
            [
                'id' => 1,
                'title' => 'Новая папка',
                'type' => 1,
                'updated' => '23.09.2019 13:22',
                'rights' => 'Только просмотр',
                'createdBy' => 'user@mail.com',
                'subfolders' => []
            ],
            [
                'id' => 2,
                'title' => 'Фото',
                'type' => 1,
                'updated' => '13.09.2018 23:55',
                'rights' => 'Полный доступ',
                'createdBy' => 'user2@example.com',
                'subfolders' => []
            ],
            [
                'id' => 3,
                'title' => 'Cool Music',
                'type' => 1,
                'updated' => '01.09.2018 03:55',
                'rights' => 'Просмотр и редактирование',
                'createdBy' => 'mnoy@example.com',
                'subfolders' => []
            ],
            [
                'id' => 4,
                'title' => 'document.doc',
                'type' => 2,
                'updated' => '21.07.2016 14:21',
                'rights' => 'Просмотр и редактирование',
                'createdBy' => 'admin@admin.ru'
            ],
            [
                'id' => 5,
                'title' => 'cat.png',
                'type' => 2,
                'updated' => '31.02.2018 20:00',
                'rights' => 'Только просмотр',
                'createdBy' => 'mnoy@example.com'
            ],
            [
                'id' => 6,
                'title' => 'Хард Басс.mp3',
                'type' => 2,
                'updated' => '31.12.2018 23:59',
                'rights' => 'Полный доступ',
                'createdBy' => 'cool@guy.eu'
            ]
        ];
        if($folder == "/Новая папка") $content = [
            [
                'id' => 11,
                'title' => 'Новая новая папка',
                'type' => 1,
                'updated' => '21.09.2009 13:22',
                'rights' => 'Только просмотр',
                'createdBy' => 'useruser@mail.com',
                'subfolders' => []
            ],
            [
                'id' => 211,
                'title' => 'Папка папка',
                'type' => 1,
                'updated' => '01.01.2009 13:22',
                'rights' => 'Полный доступ',
                'createdBy' => 'mail@com.com',
                'subfolders' => []
            ],
            [
                'id' => 456,
                'title' => 'doc1.doc',
                'type' => 2,
                'updated' => '21.07.2016 14:21',
                'rights' => 'Полный доступ',
                'createdBy' => 'admin211@gmail.ru'
            ]
        ];
        if($folder == "/Новая папка/Папка папка") $content = [
            [
                'id' => 1001,
                'title' => 'Очень длинное название для папки',
                'type' => 1,
                'updated' => '21.09.2009 13:22',
                'rights' => 'Только просмотр',
                'createdBy' => 'useruser@mail.com',
                'subfolders' => []
            ],
            [
                'id' => 4561233,
                'title' => 'dogge.jpeg',
                'type' => 2,
                'updated' => '21.07.2016 14:21',
                'rights' => 'Полный доступ',
                'createdBy' => 'admin211@gmail.ru'
            ]
        ];
        
        return $content;
    }
    
    # @http DELETE /filemanager/folder/delete/
    public function deleteFolder(){
        $folder = Safety::protect($_GET['folder']);
        //$model->deleteFolder($folder);
        return 'Выполнено успешно';
    }

    # @http POST /filemanager/folder/rename/
    public function renameFolder() {
        $folder = Safety::protect($_POST['folder']);
        $newName = Safety::protect($_POST['newName']);
        //$model->renameFolder($folder, $newName);
        return 'Выполнено успешно';
    }

    # @http POST /filemanager/folder/copy/
    public function copyFolder() {
        $from = Safety::protect($_POST['from']);  
        $to = Safety::protect($_POST['to']);  
        //$model->copyFolder($from, $to);
        return 'Выполнено успешно';
    }

    # @http POST /filemanager/folder/move/
    public function replaceFolder(){
        $from = Safety::protect($_POST['from']);
        $to = Safety::protect($_POST['to']);
        //$model->moveFolder($from, $to);
        return 'Выполнено успешно';
     }

    # @http POST /filemanager/file/upload/
    public function uploadFile(){
        $localPath = Safety::protect($_POST['localPath']);
        $folderPath = Safety::protect($_POST['folderPath']);
        //$model->uploadFile($localPath, $folderPath);
        return 'Выполнено успешно';
    }

    # @http DELETE /filemanager/file/delete/
    public function deleteFile(){
        $file = Safety::protect($_GET['file']);
        //$model->deleteFile($file);
        return 'Выполнено успешно';
    }

    # @http POST /filemanager/file/rename/
    public function filemanager(){
        $file = Safety::protect($_POST['file']);
        $newName = Safety::protect($_POST['newName']);
        //$model->renameFile($file, $newName);
        return 'Выполнено успешно';
    }

    # @http POST /filemanager/file/getContent/
    public function getFileContent() {
        $file = Safety::protect($_POST['file']);
        //$model->getFileContent($file);
        return '...","acsUrl":"https://test.paymentgate.ru/acs/auth/start.do","paReq":"eJx
            VUdtugkAQ/RXCOy7LRdQMa2ixKU28pGrfyTICqSzKpcW/765AbR8mOWcyOWfmDCy74qx9YVXn\
            npfB1OjF1DQUvk1ykvn48vBgzfcngkFWI4R55WyGDNdZ1nKKWJ74+TVz05tPE8NyZbThOfDJmF
            jcN\ni55Mz+MJzu25zmAXvOOVwWDEpM/EAjJSqVjxLBYNg5hfn6INcyxvappABgoFVlHIPCA9A
            BEXyPb4\nhWKVp1mzyQUCuTeBl61oqhubOjaQkUBbnVnWNJcFId5sPuFlAUT1gDy8d61CtdTo8
            oStw+C7r5W5\nCVNZx9v6ENmyfCBqApK4QWaZ1KXUcjVqLVx7Ycu77n2IC2XOqDqjh3BRDsGj/
            5eDDLeS2Y+bjwyw\nu5QC5YRU/sVAHts+v6rceCODyfbb7m3bfmzD22dnlycaFHF+DGl0y6hK8
            z6kFHMZity7l1QEiJIh\nw6PI8GOJ/v3+BweMtyE=","termUrl":"https://test.payment
            gate.ru:443/testpayment/rest/finish3ds.do","errorCode":0}';
    }

    # @http POST /filemanager/file/copy/
    public function copyFile() {
        $file = Safety::protect($_POST['file']);
        $newFolder = Safety::protect($_POST['newFolder']);
        //$model->copyFile($file, $newFolder);
        return 'Выполнено успешно';
    }

    # @http POST /filemanager/file/move/
    public function moveFile() {
        $file = Safety::protect($_POST['file']);
        $folder = Safety::protect($_POST['folder']);
        //$model->moveFile($file, $folder);
        return 'Выполнено успешно';
    }
    
}