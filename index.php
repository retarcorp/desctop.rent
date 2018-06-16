<?php

    #$_SERVER['DOCUMENT_ROOT'] = 'C:\inetpub\wwwroot\desktop.rent';
    require_once $_SERVER['DOCUMENT_ROOT']."/Classes/autoload.php";
    use Classes\Utils\Safety;
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
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/drop-down-menu.js"></script>
    <title>Control panel</title>
</head>
<body>
    <div id="wrapper">
        <?= require $_SERVER['DOCUMENT_ROOT']."/modules/user-header.php"?>
        
        <main class="main main_padding_bottom">
            <header class="main__header">
                <h1 class="header__text text_size_header">Добро пожаловать!</h1>
                <ul class="header__nav-path text_color_grey">Вы здесь:
                    <li class="header__list-item"><a href="#" class="text_color_blue">Главная</a></li>
                </ul>
            </header>
            <section class="btn-menu main__btn-menu btn-menu_margin">
                <button class="btn-menu__entrance button button_theme_sky-light btn-menu__button_size">
                    <span class="button_text text_size_button button__text_color">Войти в рабочий стол</span>
                </button>
                <button class="btn-menu__set-password button button_theme_sky-dark btn-menu__set-password_margin btn-menu__button_size">
                    <span class="button_text text_size_button button__text_color">Установить пароль для первого входа</span>
                </button>
            </section>
            <section class="main__tools tools">
                <header class="tools__header main__header tools__header_margin_bottom">
                    <h1 class="header__text tools__header_border_bottom tools__header_padding text_size_caption">Доступные инструменты</h1>
                </header>
                <div class="tools__container container container_padding">
                    <a href="#" class="tools__link item_margin">
                        <div class="container__item item">
                            <!-- <a href="#" class="item__link"> -->
                                <div class="item__picture picture picture_theme_sky-dark">
                                    <img class="picture__img" src="img/icon-control-menu/employees.png" alt="picture">
                                </div>
                            <!-- </a> -->
                            <div class="item__text item__text_width">
                                <header class="item__header item__header_line-height item__text_head">
                                    <h3 class="header__text">Мои сотрудники</h3>
                                </header>
                                <p class="item__description description description_text_size description_padding text_color_grey item__text_desc">Добавляйте, удаляйте сотрудиков организации
                                        и управляйте их доступом к своим папкам.</p>
                            </div>   
                        </div>
                    </a>
                    <a href="#" class="tools__link item_margin">
                        <div class="container__item item">
                            <!-- <a href="#" class="item__link"> -->
                                <div class="item__picture picture picture_theme_disable">
                                    <img class="picture__img" src="img/icon-control-menu/folders.png" alt="picture">
                                </div>
                            <!-- </a> -->
                            <div class="item__text item__text_width">
                                <header class="item__header item__header_line-height item__text_head">
                                    <h3 class="header__text">Мои папки</h3>
                                </header>
                                <p class="item__description description description_text_size description_padding text_color_grey item__text_desc">Управляйте содержимым корпоративных папок
                                        и доступом сотрудников к ним.</p>
                            </div>   
                        </div>
                    </a>
                    <a href="#" class="tools__link item_margin">
                        <div class="container__item item">
                            <!-- <a href="#" class="item__link"> -->
                                <div class="item__picture picture picture_theme_sky-dark">
                                    <img class="picture__img" src="img/icon-control-menu/payments.png" alt="picture">
                                </div>
                            <!-- </a> -->
                            <div class="item__text item__text_width">
                                <header class="item__header item__header_line-height item__text_head">
                                    <h3 class="header__text">Мои платежи</h3>
                                </header>
                                <p class="item__description description description_text_size description_padding text_color_grey item__text_desc">Просматривайте историю платежных 
                                        транзакций, получайте счета и расчетные 
                                        документы.</p>
                            </div>   
                        </div>
                    </a>
                    <a href="#" class="tools__link item_margin">
                        <div class="container__item item">
                            <!-- <a href="#" class="item__link"> -->
                                <div class="item__picture picture picture_theme_sky-dark">
                                    <img class="picture__img" src="img/icon-control-menu/data.png" alt="picture">
                                </div>
                            <!-- </a> -->
                            <div class="item__text item__text_width">
                                <header class="item__header item__header_line-height item__text_head">
                                    <h3 class="header__text">Мои данные</h3>
                                </header>
                                <p class="item__description description description_text_size description_padding text_color_grey item__text_desc">Укажите учетные данные компании, требуемые
                                        для документооборота с Desktop.rent.</p>
                            </div>   
                        </div>
                    </a>
                    <a href="#" class="tools__link item_margin">
                        <div class="container__item item">
                            <!-- <a href="#" class="item__link"> -->
                                <div class="item__picture picture picture_theme_sky-dark">
                                    <img class="picture__img" src="img/icon-control-menu/support.png" alt="picture">
                                </div>
                            <!-- </a> -->
                            <div class="item__text item__text_width">
                                <header class="item__header item__header_line-height item__text_head">
                                    <h3 class="header__text">Техподдержка</h3>
                                </header>
                                <p class="item__description description description_text_size description_padding text_color_grey item__text_desc">Общайтесь с Вашим персональным менеджером
                                        по вопросам работы с платформой Desktop.rent.</p>
                            </div>   
                        </div>
                    </a>
                    <a href="#" class="tools__link item_margin">
                        <div class="container__item item">
                            <!-- <a href="#" class="item__link"> -->
                                <div class="item__picture picture picture_theme_disable">
                                    <img class="picture__img" src="img/icon-control-menu/services.png" alt="picture">
                                </div>
                            <!-- </a> -->
                            <div class="item__text item__text_width">
                                <header class="item__header item__header_line-height item__text_head">
                                    <h3 class="header__text">Мои сервисы</h3>
                                </header>
                                <p class="item__description description description_text_size description_padding text_color_grey item__text_desc">Просматривайте и управляйте списком
                                        подключенных услуг.</p>
                            </div>   
                        </div>
                    </a>
                </div>
            </section>
        </main>
        <?= include $_SERVER['DOCUMENT_ROOT']."/modules/footer.php";?>
    </div>    
</body>
</html>