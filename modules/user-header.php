<header class="header header_theme_sky-dark header_text_align header_content">
    <div class="header__logo">
        <a class="header__link text_color_blue" href="/">
            <img class="logo" src="/img/logo.png">
        </a>
    </div>
    <button class="header__button-adaptive"></button>
    <div class="header__user-profile user-profile">
        <p class="user-profile__login">Клиент 001289</p>
        <button class="user-profile__button"></button>
        <div class="user-profile__avatar">
            <img class="user-profile__img" src="/img/img-profile.png" alt="avatar">
        </div>
    </div>
</header>
<section class="header__menu drop-down-menu">
    <div class="drop-down-list__block block block_shadow block_padding block_text-size active">
        <div class="block___balance">
            <h2 class="block__header header__text text-caption_menu font-regular">Баланс</h2>
            <div class="block__balance balance balance_margin">
                <div class="balance__links">
                    <a href="#" class="balance__link link-color text-balance font-regular">Оплатить услуги</a>
                    <a href="#" class="balance__link link-color text-balance font-regular">Привязать карту</a>
                </div>
                <div class="balance__money money money_text-size">
                    <p class="money__text money__text-position text-balance font-regular">доступно</p>
                    <p class="money__count money__count-color money__count-size font-regular">14 500 <span class="money__currency money__count-color font-regular">Р</span></p>
                </div>
            </div>
        </div>
        <div class="block___services">
            <h2 class="block__header header__text text-caption_menu font-regular">Поключенные услуги</h2>
            <div class="block__services services services_margin">
                <div class="services__item">
                    <a href="#" class="services__link link-color text-services font-regular">Доступ к порталу</a>
                    <p class="services__date text-services font-regular">до 31.07.2018</p>
                </div>
            </div>
        </div>
        <div class="block___resources">
            <h2 class="block__header header__text text-caption_menu font-regular">Ресурсы</h2>
            <div class="block__resources resources resources_margin">
                <p class="resources__info text-resourse font-regular">Используется: <span class="text-resourse font-regular">8,9 Гб из 15 ГБ (59%)</span></p>
                <!--<a href="#" class="resources__disk link-color font-regular text-balance"><span class="text-balance">+</span>Расширить диск</a>-->
            </div>
        </div>
    </div>
    <div class="block__notice block_padding">
        <h1 style="margin-bottom: 10px;">Уведомления</h1>
        <div class="notice__block">
            <div class="notice__picture">
                <img src="img/icon-test.png" alt="" class="notice__img">
                <a href="#" class="description__header description__header_margin">Заголовок уведомления</a>
            </div>
            <div class="notice__description">
                <p class="description__text">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
            </div>
            <div class="notice__btns">
                <button class="button__resource button button_theme_sky-light">Перейти</button>
                <button class="button__pin button button_theme_sky-light button__pin_margin">Прикрепить к доске</button>
            </div>
        </div>
        <div class="notice__block">
            <div class="notice__picture">
                <img src="img/icon-test.png" alt="" class="notice__img">
                <a href="#" class="description__header description__header_margin">Заголовок уведомления</a>
            </div>
            <div class="notice__description">
                <p class="description__text">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
            </div>
            <div class="notice__btns">
                <button class="button__resource button button_theme_sky-light">Перейти</button>
                <button class="button__pin button button_theme_sky-light button__pin_margin">Прикрепить к доске</button>
            </div>
        </div>
    </div>
    <div class="block__info block_padding">
        <h1>Настройки</h1>
        <div class="info__setting info__setting_margin">
            <label class="info__label" for="">Пароль</label>
            <input class="info__input" type="password">
        </div>
        <div class="info__setting info__setting_margin">
                <label class="info__label" for="">Поле</label>
                <input class="info__input" type="text">
            </div>
        <div class="info__setting info__setting_margin">
            <p>Какая-то плюшка</p>
            <div class="setting-btn">
                <label class="info__label">
                    <input type="radio" name="btn1" class="info__input" checked>
                    <button class="info__button button">Включить</button>
                </label>
                <label class="info__label">
                    <input type="radio" name="btn1" class="info__input">
                    <button class="info__button button">Отключить</button>
                </label>
            </div>                           
        </div>
        <div class="info__setting info__setting_margin">
            <p>Переключатель</p>
            <div class="setting-btn">
                <label class="info__label">
                    <input type="radio" name="btn2" class="info__input" checked>
                    <button class="info__button button">Тип 1</button>
                </label>
                <label class="info__label">
                    <input type="radio" name="btn2" class="info__input">
                    <button class="info__button button">Тип 2</button>
                </label>
                <label class="info__label">
                    <input type="radio" name="btn2" class="info__input">
                    <button class="info__button button">Тип 3</button>
                </label>
            </div>                           
        </div>
        <div class="info__setting info__setting_margin">
            <p>Выбор варианта</p>
            <label class="info__label">
                <select class="setting__select">
                    <option value="">1</option>
                    <option value="">2</option>
                    <option value="">3</option>
                    <option value="">4</option>
                    <option value="">5</option>
                </select>
            </label>
        </div>
        <div class="info__agreement">
            <button class="button__agree info__button button button_theme_sky-dark">Применить</button>
            <button class="button__cancel button__cancel_margin info__button button">Отмена</button>
        </div>
    </div>
    <ul class="drop-down-menu__drop-down-list drop-down-list">
        <li class="drop-down-list__item item">
            <a href="#" class="item__link">
                <button class="drop-down-list__button button__notice drop-down-list__button_background">
                    <span class="button__notification"></span>
                </button>
            </a>
        </li>
        <li class="drop-down-list__item">
            <a href="#" class="item__link">
                <button class="drop-down-list__button button__info drop-down-list__button_background"></button>
            </a>
        </li>
        <li class="drop-down-list__item">
            <a href="#" class="item__link">
                <button class="drop-down-list__button button__support drop-down-list__button_background"></button>
            </a>
            
        </li>
        <li class="drop-down-list__item">
            <a href="/logout/" class="item__link">
                <button class="drop-down-list__button button__exit drop-down-list__button_background"></button>
            </a>
        </li>
    </ul>
</section>