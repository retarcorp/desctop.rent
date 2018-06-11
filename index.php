<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/Classes/autoload.php";
    use Classes\Utils\JSONResponse;
    use Classes\Utils\Sms;

    $res = Sms::send("375447386402","Hello from Desktop.rent!");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/drop-down-menu.css">
    <link rel="stylesheet" href="/css/authorization.css">
    <script src="/js/drop-down-menu.js"></script>

    <script src="/js/retarcore.js"></script>
    <script src="/js/api.js"></script>

    <script src="/js/index.js"></script>
    <title>Authorization</title>
</head>
<body>
    <div id="wrapper">
        <header class="header header_theme_sky-dark header_text_align header_content">
            <div "header__logo">
                <a class="header__link" href="#"><h1 class="header__text">Desktop.rent</h1></a>
            </div>
            <div class="header__user-profile user-profile">
                <p class="user-profile__login">Клиент 001289</p>
                <div class="user-profile__avatar">
                    <img class="user-profile__img" src="img/img-profile.png" alt="avatar">
                </div>
                <button class="user-profile__button"></button>
            </div>
        </header>
        <section class="header__menu drop-down-menu">
            <ul class="drop-down-menu__drop-down-list drop-down-list">
                <li class="drop-down-list__item item">
                    <button class="drop-down-list__button button button__notice drop-down-list__button_background"></button>
                    <div class="drop-down-list__block block block_shadow block_padding block_text-size"></div>
                </li>
                <li class="drop-down-list__item">
                    <button class="drop-down-list__button button button__info drop-down-list__button_background active"></button>
                    <div class="drop-down-list__block block block_shadow block_padding block_text-size active">
                        <div class="block___balance">
                            <h2 class="block__header block__header-border">Баланс</h2>
                            <div class="block__balance balance balance_margin">
                                <div class="balance__links">
                                    <a href="" class="balance__link link-color">Оплатить услуги</a>
                                    <a href="" class="balance__link link-color">Привязать карту</a>
                                </div>
                                <div class="balance__money money money_text-size">
                                    <p class="money__text money__text-position">доступно</p>
                                    <p class="money__count money__count-color money__count-size">14 500 <span class="money__currency">Р</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="block___services">
                            <h2 class="block__header block__header-border">Поключенные услуги</h2>
                            <div class="block__services services services_margin">
                                <div class="services__item">
                                    <a href="#" class="services__link link-color">Доступ к порталу</a>
                                    <p class="services__date">до 31.07.2018</p>
                                </div>
                            </div>
                        </div>
                        <div class="block___resources">
                            <h2 class="block__header block__header-border">Русурсы</h2>
                            <div class="block__resources resources resources_margin">
                                <p class="resources__info">Используется 8,9 Гб из 15 ГБ (59%)</p>
                                <a href="#" class="resources__disk"><span>&plus;</span>Расширить диск</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="drop-down-list__item">
                    <button class="drop-down-list__button button button__support drop-down-list__button_background"></button>
                    <div class="drop-down-list__block block block_shadow block_padding block_text-size"></div>
                </li>
                <li class="drop-down-list__item">
                    <button class="drop-down-list__button button button__exit drop-down-list__button_background"></button>
                    <div class="drop-down-list__block block block_shadow block_padding block_text-size"></div>
                </li>
            </ul>
        </section>
        <main class="main">
            <section class="main__section authorization">
                <header class="authorization__header header_text">Вход в систему</header>
                <input id="phone" class="input authorization__phone" type="text" placeholder="+ 7 (    ) ___-__-__">
                <button class="authorization__button button button_theme_sky-light">
                    <span class="button_text">Войти в кабинет</span>
                </button>
            </section>
            <section class="main__section sms-confirmation">
                <header class="sms-confirmation__header header_text">Вход в систему</header>
                <label for="sms" class="sms-confirmation__help-info text_color_grey">На указанный Вами номер было отправлено
                    СМС-сообщение с кодом подтверждения. Введите этот код в поле ниже:
                </label>
                <input id="sms" class="input sms-confirmation__number" type="text" placeholder="Например: 003827">
                <button class="sms-confirmation__button button button_theme_sky-light">
                    <span class="button_text">Войти в кабинет</span>
                </button>
                <p class="sms-confirmation__agreement text_color_grey">
                    Нажимая на кнопку Войти в кабинет, Вы выражаете
                    согласие с <a class="sms-confirmation__link" href="#">условиями предоставления услуг</a>
                    и <a class="sms-confirmation__link" href="#">политикой конфиденциальности</a>
                </p>
            </section>
        </main>
        <footer class="footer">
            <p class="footer__copyright">Desktop.rent (c) 2018. Все права защищены.</p>
        </footer>
    </div>    
</body>
</html>