<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/Classes/autoload.php";
    use Classes\Utils\Safety;
    Safety::declareUnauthorizedOnlyZone(); 
    
    
?>

<html>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/drop-down-menu.css">
    <link rel="stylesheet" href="/css/authorization.css">
    <link rel="stylesheet" href="/css/adaptive.css">


    <script src="/js/retarcore.js"></script>
    <script src="/js/api.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="/js/index.js"></script>
    <title>Authorization</title>
    


    <div id="wrapper">
        <header class="header header_theme_sky-dark header_text_align header_content header_font-size_head">
            <div "header__logo">
                <a class="header__link text_color_blue" href="/">
                    <img class="logo" src="/img/logo.png">
                </a>
            </div>
        </header>
    
        <main class="main" id="app">
            <section class="main__section authorization" v-if="Tabs.phone">
                <header class="authorization__header header_text_align header_text-size_caption">Вход в систему</header>
                <input id="phone" class="input authorization__phone" type="tel" @input="refreshPhoneMessage" v-model="phone" placeholder="+ 7 (    ) ___-__-__">
                <button class="authorization__button button text_size_button loader_relative" @click.prevent="onPhoneEntered">
                    <span class="text_size_button button__text_color font-regular">Войти в кабинет</span>
                    <div class="loader hidden">
                        <div class="loader__item"></div>        
                    </div>
                </button>
                <span class="invalid-phone text_color_grey text_size_min-small invelid_margin" v-if="phoneIsInvalid">{{Messages.currentPhoneMessage}}</span>
            </section>
            <section class="main__section sms-confirmation" v-if="Tabs.sms">
                <header class="sms-confirmation__header header_text_align header_text-size_caption">Вход в систему</header>
                <label for="sms" class="sms-confirmation__help-info text_color_grey text_size_small">На указанный Вами номер было отправлено
                    СМС-сообщение с кодом подтверждения. Введите этот код в поле ниже:
                </label>
                <input id="sms" class="input sms-confirmation__number" type="text" @input="refreshSmsMessage" placeholder="Например: 003827" v-model="smsCode">
                <button class="sms-confirmation__button button loader_relative" @click.prevent="onSmsCodeEntered">
                    <span class="text_size_button button__text_color font-regular">Войти в кабинет</span>
                    <div class="loader hidden">
                        <div class="loader__item"></div>        
                    </div>
                </button>
                <p class="status invelid_margin text_color_grey text_size_min-small" v-if="smsIsInvalid">{{Messages.smsCodeMessage}}</p>
                <p class="sms-confirmation__agreement text_color_grey text_size_min-small font-italic">
                    Нажимая на кнопку Войти в кабинет, Вы выражаете
                    согласие с <a class="sms-confirmation__link" href="#">условиями предоставления услуг</a>
                    и <a class="sms-confirmation__link" href="#">политикой конфиденциальности</a>
                </p>
            </section>
        </main>
        <footer class="footer">
            <p class="footer__copyright text_color_white">Desktop.rent (c) 2018. Все права защищены.</p>
        </footer>
    </div>
</html>

