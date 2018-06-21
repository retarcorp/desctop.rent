<?php

    #$_SERVER['DOCUMENT_ROOT'] = 'C:\inetpub\wwwroot\desktop.rent';
    require_once $_SERVER['DOCUMENT_ROOT']."/Classes/autoload.php";
    use Classes\Utils\Safety;
    use Classes\Models\Users\User;
    Safety::declareProtectedZone();    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/drop-down-menu.css">
    <link rel="stylesheet" href="/css/control-panel.css">
    <link rel="stylesheet" href="/css/user-control-panel.css">
    
    <link rel="stylesheet" href="/css/adaptive.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <script src="/js/drop-down-menu.js"></script>
    <script src="/js/menu-user-control-panel.js"></script>

    <script src="/js/retarcore.js"></script>
    <script src="/js/api.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="index.js"></script>
    <title>My profile</title>
</head>
<body>
    <div id="wrapper">
        <?php require $_SERVER['DOCUMENT_ROOT']."/modules/user-header.php"?>
        <main class="main main_padding_bottom">
            <?php include $_SERVER['DOCUMENT_ROOT']."/modules/user-menu.php" ?>

            <section class="main__right-tab right-tab right-tab_margin">
                <?php include "content.php"; # Main content of the tab ?>
            </section>
        </main>
        <?php include $_SERVER['DOCUMENT_ROOT']."/modules/footer.php";?>
    </div>    
</body>
</html>