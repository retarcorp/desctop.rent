<section id="fileManager" class="right-tab__tab-data tab-data active">
    <header class="tab__header">
        <ul class="header__nav-path text_color_grey">
            <li class="header__list-item"><a href="#" class="text_color_blue">Главная</a></li>
            <li class="header__list-item"><a href="#" class="text_color_blue">Мои сотрудники</a></li>
        </ul>
        <h1 class="header__text text_size_header">Мои сотрудники</h1>
    </header>
    <div class="tab-data__content tab-data__content_margin_top">
        <!--<ul class="selection__list">-->
        <!--    <li class="font-regular button__associate tab__folders active">Управление папками</li>-->
        <!--    <li class="font-regular button__associate tab__access">Удаленный доступ</li>-->
        <!--    <li class="font-regular button__associate tab__scaners">Сканеры</li>-->
        <!--</ul>-->
        <!--<section class="right-tab__tab-data tab-data active content" id="content">-->
            
    <!--</header>-->
    
        
    

        
        <div class="folders__tab active employeer__tab">
            <p class="command__name font-regular">Команда: <span class="font-regular">“ОАО Корпарэйшн”</span> </p>
            <header class="foldes__header">
                <div class="header__col header__name font-regular">Имя</div>
                <div class="header__col header__surname font-regular">Фамилия</div>
                <div class="header__col header__patronymic font-regular">Отчество</div>
                <div class="header__col header__phone font-regular">Телефон</div>
                <div class="header__col header__rights font-regular">Права доступа</div>
                <div class="header__col header__button"></div>
                
            </header>
            <div class="folders__folder row__current-user">
                <p class="employee__name font-regular">Дмитрий</p>
                <p class="employee__surname font-regular">Марченко</p>
                <p class="employee__patronymic font-regular">Игоревич</p>
                <p class="employee__phone font-regular">+7 (926) 163-75-07</p>
                <p class="employee__rights font-regular">Мастер</p>
                <div class="folder__btn">
                    <!--<button class="folder__item button__folder-edit"></button>-->
                    <!--<button class="folder__item button__folder-remove"></button>-->
                    <!--<button class="folder__item button__folder-stop"></button>-->
                </div>
            </div>
            <div class="folders__container " @click.stop="toggleFolderContent">
                
                <div class="folders__folder">
                    <p class="employee__name font-regular">Дмитрий</p>
                    <p class="employee__surname font-regular">Марченко</p>
                    <p class="employee__patronymic font-regular">Игоревич</p>
                    <p class="employee__phone font-regular">+7 (926) 163-75-07</p>
                    <p class="employee__rights font-regular">
                        <select class="right-list font-regular">
                            <option>Мастер</option>
                            <option>Сотрудник</option>
                            <option>Другое лицо</option>
                        </select>
                    </p>
                    <div class="folder__btn">
                        <button class="folder__item button__folder-edit"></button>
                        <button class="folder__item button__folder-remove"></button>
                        <button class="folder__item button__folder-stop"></button>
                    </div>
                </div>
                <div class="folders__folder">
                    <p class="employee__name font-regular">Дмитрий</p>
                    <p class="employee__surname font-regular">Марченко</p>
                    <p class="employee__patronymic font-regular">Игоревич</p>
                    <p class="employee__phone font-regular">+7 (926) 163-75-07</p>
                    <p class="employee__rights font-regular">
                        <select class="right-list font-regular">
                            <option>Мастер</option>
                            <option>Сотрудник</option>
                            <option>Другое лицо</option>
                        </select>
                    </p>
                    <div class="folder__btn">
                        <button class="folder__item button__folder-edit"></button>
                        <button class="folder__item button__folder-remove"></button>
                        <button class="folder__item button__folder-stop"></button>
                    </div>
                </div>
                
            </div>
            
            <div class="table__page">
                <button class="page__btn-prev"></button>
                <ul class="page__list">
                    <li class="page__item">1</li>
                    <li class="page__item">2</li>
                    <li class="page__item">3</li>
                    <li class="page__item">4</li>
                    <li class="page__item disabled">...</li>
                    <li class="page__item">25</li>
                </ul>
                <button class="page__btn-next"></button>
            </div>
            
            
            
        </div>
        
        
        <section :class="{'active': isPopUpVisible}" id="popup">
            <p>Я попап, я попап, я попап</p>
            <p>Я попап, я попап, я попап</p>
            <p>Я попап, я попап, я попап</p>
            <p>Я попап, я попап, я попап</p>
            <p>Я попап, я попап, я попап</p>
            <p>Я попап, я попап, я попап</p>
            <p>Я попап, я попап, я попап</p>
        </section>
    
    </section>
    
    <section class="new-folder__background" style="display:none;">
        <div class="popup new-folder">
            <h1 class="popup__header font-regular">Добавление новой папки</h1>
            <button class="popup__btn-close"></button>
            <ul class="popup__tabs">
                <li class="popup__tabs-item font-regular">Свойства</li>
                <li class="popup__tabs-item font-regular">Доступ</li>
            </ul>
            <div class="new-folder__access">
                <input type="text" class="access__search font-regular" placeholder="Введите имя, или email сотрудника">
                <div class="access__content">
                    <div class=" all__users-list">
                        <div class="users-list__header font-regular">Все пользователи</div>
                        <div class="user-list ScrollBar">
                            <div class="user-list__item">
                                <img src="/img/icon-user.png" class="user-item__avatar">
                                <div class="user-item__info">
                                    <p class="user-item__fullname font-regular">Кобелев Эдуард Родионович</p>
                                    <p class="user-item__email font-regular">sampleemail@gmail.com</p>
                                </div>
                                <input class="style-ratio" type="checkbox" name="font_print">
                            </div>
                            <div class="user-list__item">
                                <img src="/img/icon-user.png" class="user-item__avatar">
                                <div class="user-item__info">
                                    <p class="user-item__fullname font-regular">Кобелев Эдуард Родионович</p>
                                    <p class="user-item__email font-regular">sampleemail@gmail.com</p>
                                </div>
                                <input class="style-ratio" type="checkbox" name="font_print">
                            </div>
                            <div class="user-list__item">
                                <img src="/img/icon-user.png" class="user-item__avatar">
                                <div class="user-item__info">
                                    <p class="user-item__fullname font-regular">Кобелев Эдуард Родионович</p>
                                    <p class="user-item__email font-regular">sampleemail@gmail.com</p>
                                </div>
                                <input class="style-ratio" type="checkbox" name="font_print">
                            </div>
                            <div class="user-list__item">
                                <img src="/img/icon-user.png" class="user-item__avatar">
                                <div class="user-item__info">
                                    <p class="user-item__fullname font-regular">Кобелев Эдуард Родионович</p>
                                    <p class="user-item__email font-regular">sampleemail@gmail.com</p>
                                </div>
                                <input class="style-ratio" type="checkbox" name="font_print">
                            </div>
                            <div class="user-list__item">
                                <img src="/img/icon-user.png" class="user-item__avatar">
                                <div class="user-item__info">
                                    <p class="user-item__fullname font-regular">Кобелев Эдуард Родионович</p>
                                    <p class="user-item__email font-regular">sampleemail@gmail.com</p>
                                </div>
                                <input class="style-ratio" type="checkbox" name="font_print">
                            </div>
                            <div class="user-list__item">
                                <img src="/img/icon-user.png" class="user-item__avatar">
                                <div class="user-item__info">
                                    <p class="user-item__fullname font-regular">Кобелев Эдуард Родионович</p>
                                    <p class="user-item__email font-regular">sampleemail@gmail.com</p>
                                </div>
                                <input class="style-ratio" type="checkbox" name="font_print">
                            </div>
                        </div>
                    </div>
                    <div class="selected__users-list">
                        <div class="users-list__header font-regular">Выбранные</div>
                        <div class="user-list ScrollBar">
                            <div class="user-list__item">
                                <img src="/img/icon-user.png" class="user-item__avatar">
                                <div class="user-item__info">
                                    <p class="user-item__fullname font-regular">Кобелев Эдуард Родионович</p>
                                    <p class="user-item__email font-regular">sampleemail@gmail.com</p>
                                    <select class="right-list font-regular">
                                        <option>Только просмотр</option>
                                        <option>Просмотр и редактирование</option>
                                        <option>Полный доступ</option>
                                    </select>
                                </div>
                                <input class="style-ratio" type="checkbox" name="font_print">
                            </div>
                            <div class="user-list__item">
                                <img src="/img/icon-user.png" class="user-item__avatar">
                                <div class="user-item__info">
                                    <p class="user-item__fullname font-regular">Кобелев Эдуард Родионович</p>
                                    <p class="user-item__email font-regular">sampleemail@gmail.com</p>
                                    <select class="right-list font-regular">
                                        <option>Только просмотр</option>
                                        <option>Просмотр и редактирование</option>
                                        <option>Полный доступ</option>
                                    </select>
                                </div>
                                <input class="style-ratio" type="checkbox" name="font_print">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="new-folder__properties">
                <label class="properties__field font-regular">
                    Название папки
                    <input type="text" class="input input__newFolder">
                </label>
            </div>
            <button class="button btn__save-newfolder">Сохранить</button>
        </div>
    </section>

    