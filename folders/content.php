<section id="fileManager" class="right-tab__tab-data tab-data active">
    <header class="tab__header">
        <ul class="header__nav-path text_color_grey">
            <li class="header__list-item"><a href="#" class="text_color_blue">Главная</a></li>
            <li class="header__list-item"><a href="#" class="text_color_blue">Мои папки</a></li>
        </ul>
        <h1 class="header__text text_size_header">Мои папки</h1>
    </header>
    <div class="tab-data__content tab-data__content_margin_top">
        <ul class="selection__list">
            <li class="font-regular button__associate tab__folders active">Управление папками</li>
            <li class="font-regular button__associate tab__access">Удаленный доступ</li>
            <li class="font-regular button__associate tab__scaners">Сканеры</li>
        </ul>
        <!--<section class="right-tab__tab-data tab-data active content" id="content">-->
            
    <!--</header>-->
    
        <section class="new-folder__background" id="popupFolder">
            <div class="popup new-folder">
                <h1 class="popup__header font-regular">Создать папку</h1>
                <button class="popup__btn-close"></button>
                <div class="new-folder__access">
                    <label class="properties__field font-regular">
                                Название папки
                    </label>
                    <input type="text" class="input input__newFolder">
                    <div class="tab-data__save save save_margin">
                        <button class="button button_theme_sky-dark save__button_size loader_relative" id=''> 
                            <span class="button_text button__text_color button__text_size_small font-regular">Сохранить</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="new-folder__background" style="display:none;">
            <div class="popup popup__remove-size new-folder">
                <h1 class="popup__header font-regular">Удалить?</h1>
                <button class="popup__btn-close"></button>
                <div class="new-folder__access">
                    <div class="tab-data__save save save_margin">
                        <button class="button button_theme_sky-dark save__button_size loader_relative" id=''> 
                            <span class="button_text button__text_color button__text_size_small font-regular">Да</span>
                        </button>
                        <button class="button__cancel save__button_size loader_relative" id=''> 
                            <span class="button_text button__text_size_small font-regular">Отмена</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    
        <section class="new-folder__background" id="popupScaner">
            <div class="popup new-folder">
                <h1 class="popup__header font-regular">Создать сканер</h1>
                <button class="popup__btn-close"></button>
                <div class="field__container">
                    <div class="tab-data__field field field_margin_bottom">
                        <label for="name" class="field__label">
                            <span class="text_size_small text_color_dark font-regular">Название</span>
                        </label> 
                        <input id="name" value="" type="text" class="field__input input input_height text_size_small text_color_dark font-regular">
                    </div>
                    <div class="tab-data__field field field_margin_bottom">
                        <label for="address" class="field__label">
                            <span class="text_size_small text_color_dark font-regular">Адрес</span>
                        </label> 
                        <input id="address" value="" type="text" class="field__input input input_height text_size_small text_color_dark font-regular">
                    </div>
                    <div class="tab-data__field field field_margin_bottom">
                        <label for="login" class="field__label">
                            <span class="text_size_small text_color_dark font-regular">Логин</span>
                        </label> 
                        <input id="login" value="" type="text" class="field__input input input_height text_size_small text_color_dark font-regular">
                    </div>
                    <div class="tab-data__field field field_margin_bottom">
                        <label for="password" class="field__label">
                            <span class="text_size_small text_color_dark font-regular">Пароль</span>
                        </label>
                        <input id="password" value="" @input="onInnChanged" type="text" required class="field__input input input_height text_size_small text_color_dark font       -regular">
                    </div>
                </div>
                <div class="tab-data__save save save_margin">
                    <button class="button button_theme_sky-dark save__button_size loader_relative" id=''> 
                        <span class="button_text button__text_color button__text_size_small font-regular">Сохранить</span>
                    </button>
                </div>
            </div>
        </section>
        
        <div class="folders__tab active">
            <button class="button button_theme_sky-dark save__button_size loader_relative folder__tab-btn" id="createFolder" @click="openCreatePopUpFolder">
                <span class="button_text button__text_color button__text_size_small font-regular">Создать папку</span>
            </button>
            <header class="foldes__header">
                <div class="header__col header__folders font-regular">Наименование папки</div>
                <div class="header__col header__button"></div>
            </header>
            <div class="folders__container" @click.stop="toggleFolderContent">
                
                <div class="folders__folder">
                    <p class="folder__title font-regular">Архивы сотрудников</p>
                    <div class="folder__btn">
                        <button class="folder__item button__folder-edit"></button>
                        <button class="folder__item button__folder-remove"></button>
                    </div>
                </div>
                <div class="folders__folder">
                    <p class="folder__title font-regular">Архивы сотрудников</p>
                    <div class="folder__btn">
                        <button class="folder__item button__folder-edit"></button>
                        <button class="folder__item button__folder-remove"></button>
                    </div>
                </div>
                
                <!--<tree-menu -->
                <!--    :nodes="tree.nodes" -->
                <!--    :depth="0"   -->
                <!--    :label="tree.label"-->
                <!--</tree-menu>-->
                
                <!--<div v-for="item in content" v-if="item.type == 1" :key="item.id" class="folder" :data-id="item.id">-->
                <!--    <div class="folder__item folder__header">-->
                <!--        <button class="button__open-folder"></button>-->
                <!--        <p class="folder__name font-regular img__folder">{{item.title}}</p>-->
                <!--    </div>-->
                <!--    <p class="folder__item folder__create">{{item.createdBy}}</p>-->
                <!--    <p class="folder__item folder__rights">{{item.rights}}</p>-->
                <!--    <p class="folder__item folder__edit">{{item.updated}}</p>-->
                <!--    <button class="folder__item button__folder-edit"></button>-->
                    
                <!--    <div class="folder__subfolders">-->
                        
                <!--        <div v-for="subitem in item.subfolders" v-if="subitem.type == 1" :key="subitem.id" class="folder" :data-id="subitem.id">-->
                <!--            <div class="folder__item folder__header">-->
                <!--                <button class="button__open-folder"></button>-->
                <!--                <p class="folder__name font-regular img__folder">{{subitem.title}}</p>-->
                <!--            </div>-->
                <!--            <p class="folder__item folder__create">{{subitem.createdBy}}</p>-->
                <!--            <p class="folder__item folder__rights">{{subitem.rights}}</p>-->
                <!--            <p class="folder__item folder__edit">{{subitem.updated}}</p>-->
                <!--            <button class="folder__item button__folder-edit"></button>-->
                            
                <!--            <div class="folder__subfolders">-->
                                
                <!--            </div>-->
                <!--        </div>-->
                        
                <!--        <div v-else :key="subitem.id" class="file" :data-id="subitem.id">-->
                <!--            <a href="#" class="folder__item folder__header">-->
                <!--                <p class="folder__name font-regular img__file">{{subitem.title}}</p>-->
                <!--            </a>-->
                <!--            <p class="folder__item folder__create">{{subitem.createdBy}}</p>-->
                <!--            <p class="folder__item folder__rights">{{subitem.rights}}</p>-->
                <!--            <p class="folder__item folder__edit">{{subitem.updated}}</p>-->
                <!--            <button class="folder__item button__folder-edit"></button>-->
                <!--        </div>-->
                        
                <!--    </div>-->
                <!--</div>-->
                
                <!--<div v-else :key="item.id" class="file" :data-id="item.id">-->
                <!--    <a href="#" class="folder__item folder__header">-->
                <!--        <p class="folder__name font-regular img__file">{{item.title}}</p>-->
                <!--    </a>-->
                <!--    <p class="folder__item folder__create">{{item.createdBy}}</p>-->
                <!--    <p class="folder__item folder__rights">{{item.rights}}</p>-->
                <!--    <p class="folder__item folder__edit">{{item.updated}}</p>-->
                <!--    <button class="folder__item button__folder-edit"></button>-->
                <!--</div>-->
                
                
                <!--               THIS IS A FOLDER TEMPLATE !!!!!!!!!!!!          -->
            
                    <!--<div class="folder">-->
                    <!--    <div class="folder__item folder__header">-->
                    <!--        <button class="button__open-folder"></button>-->
                    <!--        <p class="folder__name font-regular img__folder">Договоры</p>-->
                    <!--    </div>-->
                    <!--    <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--    <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--    <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--    <button class="folder__item button__folder-edit"></button>-->
                        
                    <!--    <div class="folder__subfolders">-->
                            
                    <!--    </div> -->
                        
                    <!--</div>-->
                    
                    
                    
                <!--               THIS IS A FILE TEMPLATE !!!!!!!!!!!!          -->
                    
                    
                    <!--<div class="file">-->
                    <!--    <a href="#" class="folder__item folder__header">-->
                    <!--        <p class="folder__name font-regular img__file">Пользователи.txt</p>-->
                    <!--    </a>-->
                    <!--    <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--    <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--    <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--    <button class="folder__item button__folder-edit"></button>-->
                    <!--</div>-->
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    <!--<div class="folder">-->
                    <!--    <div class="folder__item folder__header">-->
                    <!--        <button class="button__open-folder"></button>-->
                    <!--        <p class="folder__name font-regular img__folder">Договоры</p>-->
                    <!--    </div>-->
                    <!--    <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--    <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--    <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--    <button class="folder__item button__folder-edit"></button>-->
                        
                    <!--    <div class="folder__subfolders">-->
                            
                    <!--        <div class="folder">-->
                    <!--            <div class="folder__item folder__header">-->
                    <!--                <button class="button__open-folder"></button>-->
                    <!--                <p class="folder__name font-regular img__folder">Название папки</p>-->
                    <!--            </div>-->
                    <!--            <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--            <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--            <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--            <button class="folder__item button__folder-edit"></button>-->
                                
                    <!--            <div class="folder__subfolders">-->
                                    
                    <!--            </div> -->
                                
                    <!--        </div>-->
                    <!--        <div class="folder">-->
                    <!--            <div class="folder__item folder__header">-->
                    <!--                <button class="button__open-folder"></button>-->
                    <!--                <p class="folder__name font-regular img__folder">Договоры</p>-->
                    <!--            </div>-->
                    <!--            <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--            <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--            <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--            <button class="folder__item button__folder-edit"></button>-->
                                
                    <!--            <div class="folder__subfolders">-->
                                    
                    <!--                <div class="folder">-->
                    <!--                    <div class="folder__item folder__header">-->
                    <!--                        <button class="button__open-folder"></button>-->
                    <!--                        <p class="folder__name font-regular img__folder">Весь список</p>-->
                    <!--                    </div>-->
                    <!--                    <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--                    <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--                    <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--                    <button class="folder__item button__folder-edit"></button>-->
                                        
                    <!--                    <div class="folder__subfolders">-->
                                            
                                            
                    <!--                        <div class="file">-->
                    <!--                            <a href="#" class="folder__item folder__header">-->
                    <!--                                <p class="folder__name font-regular img__file">Список заказов.pdf</p>-->
                    <!--                            </a>-->
                    <!--                            <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--                            <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--                            <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--                            <button class="folder__item button__folder-edit"></button>-->
                    <!--                        </div>-->
                    <!--                        <div class="file">-->
                    <!--                            <a href="#" class="folder__item folder__header">-->
                    <!--                                <p class="folder__name font-regular img__file">Пользователи.txt</p>-->
                    <!--                            </a>-->
                    <!--                            <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--                            <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--                            <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--                            <button class="folder__item button__folder-edit"></button>-->
                    <!--                        </div>-->
                                            
                                            
                                            
                    <!--                    </div> -->
                                        
                    <!--                </div>-->
                                    
                    <!--            </div> -->
                                
                    <!--        </div>-->
                            
                    <!--    </div> -->
                        
                    <!--</div>-->
                    
                    <!--<div class="folder">-->
                    <!--    <div class="folder__item folder__header">-->
                    <!--        <button class="button__open-folder"></button>-->
                    <!--        <p class="folder__name font-regular img__folder">Договоры</p>-->
                    <!--    </div>-->
                    <!--    <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--    <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--    <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--    <button class="folder__item button__folder-edit"></button>-->
                        
                    <!--    <div class="folder__subfolders">-->
                            
                    <!--    </div> -->
                        
                    <!--</div>-->
                    
                    <!--<div class="folder">-->
                    <!--    <div class="folder__item folder__header">-->
                    <!--        <button class="button__open-folder"></button>-->
                    <!--        <p class="folder__name font-regular img__folder">Договоры</p>-->
                    <!--    </div>-->
                    <!--    <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--    <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--    <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--    <button class="folder__item button__folder-edit"></button>-->
                        
                    <!--    <div class="folder__subfolders">-->
                            
                    <!--    </div> -->
                        
                    <!--</div>-->
                    
                    <!--<div class="folder">-->
                    <!--    <div class="folder__item folder__header">-->
                    <!--        <button class="button__open-folder"></button>-->
                    <!--        <p class="folder__name font-regular img__folder">Договоры</p>-->
                    <!--    </div>-->
                    <!--    <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--    <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--    <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--    <button class="folder__item button__folder-edit"></button>-->
                        
                    <!--    <div class="folder__subfolders">-->
                            
                    <!--    </div> -->
                        
                    <!--</div>-->
                    
                    <!--<div class="folder">-->
                    <!--    <div class="folder__item folder__header">-->
                    <!--        <button class="button__open-folder"></button>-->
                    <!--        <p class="folder__name font-regular img__folder">Договоры</p>-->
                    <!--    </div>-->
                    <!--    <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--    <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--    <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--    <button class="folder__item button__folder-edit"></button>-->
                        
                    <!--    <div class="folder__subfolders">-->
                            
                    <!--    </div> -->
                        
                    <!--</div>-->
                    
                    <!--<div class="folder">-->
                    <!--    <div class="folder__item folder__header">-->
                    <!--        <button class="button__open-folder"></button>-->
                    <!--        <p class="folder__name font-regular img__folder">Договоры</p>-->
                    <!--    </div>-->
                    <!--    <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--    <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--    <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--    <button class="folder__item button__folder-edit"></button>-->
                        
                    <!--    <div class="folder__subfolders">-->
                            
                    <!--    </div> -->
                        
                    <!--</div>-->
                    
                    <!--<div class="folder">-->
                    <!--    <div class="folder__item folder__header">-->
                    <!--        <button class="button__open-folder"></button>-->
                    <!--        <p class="folder__name font-regular img__folder">Договоры</p>-->
                    <!--    </div>-->
                    <!--    <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--    <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--    <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--    <button class="folder__item button__folder-edit"></button>-->
                        
                    <!--    <div class="folder__subfolders">-->
                            
                    <!--    </div> -->
                        
                    <!--</div>-->
                    
                    <!--<div class="folder">-->
                    <!--    <div class="folder__item folder__header">-->
                    <!--        <button class="button__open-folder"></button>-->
                    <!--        <p class="folder__name font-regular img__folder">Договоры</p>-->
                    <!--    </div>-->
                    <!--    <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--    <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--    <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--    <button class="folder__item button__folder-edit"></button>-->
                        
                    <!--    <div class="folder__subfolders">-->
                            
                    <!--    </div> -->
                        
                    <!--</div>-->
                    
                    <!--<div class="folder">-->
                    <!--    <div class="folder__item folder__header">-->
                    <!--        <button class="button__open-folder"></button>-->
                    <!--        <p class="folder__name font-regular img__folder">Договоры</p>-->
                    <!--    </div>-->
                    <!--    <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--    <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--    <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--    <button class="folder__item button__folder-edit"></button>-->
                        
                    <!--    <div class="folder__subfolders">-->
                            
                    <!--    </div> -->
                        
                    <!--</div>-->
                    
                    <!--<div class="folder">-->
                    <!--    <div class="folder__item folder__header">-->
                    <!--        <button class="button__open-folder"></button>-->
                    <!--        <p class="folder__name font-regular img__folder">Договоры</p>-->
                    <!--    </div>-->
                    <!--    <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--    <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--    <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--    <button class="folder__item button__folder-edit"></button>-->
                        
                    <!--    <div class="folder__subfolders">-->
                            
                    <!--    </div> -->
                        
                    <!--</div>-->
                    
                    <!--<div class="folder">-->
                    <!--    <div class="folder__item folder__header">-->
                    <!--        <button class="button__open-folder"></button>-->
                    <!--        <p class="folder__name font-regular img__folder">Договоры</p>-->
                    <!--    </div>-->
                    <!--    <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--    <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--    <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--    <button class="folder__item button__folder-edit"></button>-->
                        
                    <!--    <div class="folder__subfolders">-->
                            
                    <!--    </div> -->
                        
                    <!--</div>-->
                    
                    <!--<div class="folder">-->
                    <!--    <div class="folder__item folder__header">-->
                    <!--        <button class="button__open-folder"></button>-->
                    <!--        <p class="folder__name font-regular img__folder">Договоры</p>-->
                    <!--    </div>-->
                    <!--    <p class="folder__item folder__create">createuser@mail.ru</p>-->
                    <!--    <p class="folder__item folder__rights">Только просмотр</p>-->
                    <!--    <p class="folder__item folder__edit">22.12.2018 23:21</p>-->
                    <!--    <button class="folder__item button__folder-edit"></button>-->
                        
                    <!--    <div class="folder__subfolders">-->
                            
                    <!--    </div> -->
                        
                    <!--</div>-->
                    
                </div>
                
            </div>
            
        <div class="access__tab">
            <button class="button button_theme_sky-dark save__button_size loader_relative folder__tab-btn" id="associateSendFolder" @click="openCreatePopUpFolder">
                <span class="button_text button__text_color button__text_size_small font-regular">Права</span>
            </button>
        </div>
            
        <div class="scaners__tab">
            <button class="button button_theme_sky-dark save__button_size loader_relative folder__tab-btn" id="createScaner" @click="openCreatePopUpFolder">
                <span class="button_text button__text_color button__text_size_small font-regular">Создать сканер</span>
            </button>
            <header class="foldes__header">
                <div class="header__col header__folders font-regular">Список сканеров</div>
                <div class="header__col header__button"></div>
            </header>
            <div class="folders__container" @click.stop="toggleFolderContent">
                
                <div class="folders__folder">
                    <p class="folder__title font-regular">Сканер</p>
                    <div class="folder__btn">
                        <button class="folder__item button__folder-edit"></button>
                        <button class="folder__item button__folder-remove"></button>
                    </div>
                </div>
                <div class="folders__folder">
                    <p class="folder__title font-regular">Архивы сотрудников</p>
                    <div class="folder__btn">
                        <button class="folder__item button__folder-edit"></button>
                        <button class="folder__item button__folder-remove"></button>
                    </div>
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

    