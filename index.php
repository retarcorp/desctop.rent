<?php
    
    #$_SERVER['DOCUMENT_ROOT'] = 'C:\inetpub\wwwroot\desktop.rent';
    require_once $_SERVER['DOCUMENT_ROOT']."/Classes/autoload.php";
    use Classes\Utils\Safety;
    Safety::declareProtectedZone();

    use Classes\Models\Users\UsersFactory;
    use Classes\Models\Users\User;
    
    use Classes\Models\PasswordRequest\PasswordRequest;
    use Classes\Models\PasswordRequest\PasswordRequestFactory;
    
    $factory = new UsersFactory();
    $user = $factory->getCurrentUser();
    
    $prf = new PasswordRequestFactory();
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
    <link rel="stylesheet" href="/css/adaptive.css">
    
    <script src="/js/vue.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <script src="js/drop-down-menu.js"></script>
    <script src="/js/retarcore.js"></script>
    <script src="/js/api.js"></script>
    
    <title>Control panel</title>
</head>
<body>
    <div id="wrapper">
        <?php require $_SERVER['DOCUMENT_ROOT']."/modules/user-header.php"?>
        
        <main id='control-panel' class="main main_padding_bottom">
            <header class="main__header">
                <h1 class="header__text text_size_header">Добро пожаловать!</h1>
                <ul class="header__nav-path text_color_grey text_size_small font-regular">Вы здесь:
                    <li class="header__list-item"><a href="#" class="text_color_blue">Главная</a></li>
                </ul>
            </header>
            <section class="btn-menu main__btn-menu btn-menu_margin">
                
                <?php 
                    if( $user->status == User::STATUS_JUST_CREATED ) { 
                        echo "<p style='margin-bottom: 20px;'>Для начала работы с порталом Вам необходимо ввести реквизиты Вашей компании.</p>
                        <a href='/profile/'>
                            <button class='btn-menu__entrance button btn-menu__button_size'>
                                <span class='button_text text_size_button font-regular'>Заполнить данные профиля</span>  
                            </button>
                        </a>";
                    } 
                ?>
                
                <?php 
                    if( $user->status == User::STATUS_FILLED_PROFILE_DATA ) { 
                        echo "<p style='margin-bottom: 20px;'>Извините, пока еще нет доступных лицензий. Подождите, пока администратор выдаст Вам ее.</p>";
                    } 
                ?>
                
                <?php 
                    if( $user->status == User::STATUS_ASSIGNED_LICENSE ) {
                        echo "
                            <p style='margin: 1rem 0;'>Для безопасной работы с рабочим столом основные возможности будут отключены, пока Вы не получите пароль доступа к рабочему столу.</p>
                            <a href=''>
                                <button @click.prevent='showModal = true' class='btn-menu__set-password button button_theme_sky-dark btn-menu__button_size'>
                                    <span class='button_text text_size_button button__text_color font-regular'>Установить пароль для первого входа</span>    
                                </button>    
                            </a>";
                    } 
                ?>
                
                <?php 
                    if( $user->status == User::STATUS_SET_UP ) {
                        echo "
                            <a href='/connection/rdp/'>
                                <button class='btn-menu__entrance button button_theme_sky-light btn-menu__button_size'>
                                    <span class='button_text text_size_button button__text_color font-regular'>Войти в рабочий стол</span>  
                                </button>
                            </a>";
                    } 
                ?>
                
                <!-- Setup Password Modal -->
                <div v-if="showModal" class="setup-password" style="display: none">
                    <div class="setup-password__container">
                       <div v-if="ui.status == null">
                          <div class="setup-password__header">
                              Введите новый пароль: <div class="setup-password__close" @click.prevent="onResetSetupPassword"></div>
                          </div>
                
                          <div class="setup-password__body">
                              <form @submit.prevent="onSetupPassword" class="setup-password__form" autocomplete="off">
                                  <div class="setup-password__input-box">
                                      <div class="setup-password__form__control">
                                        <label class="setup-password__label">Пароль</label>
                                        <input class="setup-password__input" v-model="user.password" type="password" :class="{'setup-password__input_error': !isPasswordsCorrect && user.password.length > 0}">
                                      </div>
                                      
                                      <div class="setup-password__form__control">
                                         <label class="setup-password__label">Повторите пароль</label>
                                         <input class="setup-password__input" v-model="user.passwordConfirm" type="password" :class="{'setup-password__input_error': !isPasswordsCorrect && user.password.length > 0}">
                                      </div>
                                  </div>
                                  
                                  <div class="setup-password__alert-box">
                                        <small class="setup-password__alert">{{ !isPasswordsEqual ? 'Пароли не совпадают' : '' }}</small>
                                        <small class="setup-password__alert">{{ !isPasswordsCorrect ? 'Вам нужно создать сильный пароль длиной 8-16 символов, который включает как минимум три элемента из следующего перечисления: заглавные буквы, строчные буквы, символы и цифры' : '' }}</small>
                                  </div>
                                  
                                  
                                  <button class="setup-password__button-submit" type="submit" :disabled='!isPasswordsCorrect'>Сохранить изменения</button>
                                  
                              </form>
                          </div>
                       </div>
                       <div v-if="ui.status == 1" class="setup-password__status-box">
                           <div class="loader-wrapper">
                                <div class="loader">
                                    <div class="loader__item loader__item_cp"></div>        
                                </div>
                           </div>
                           <div class="setup-password__status-box_loader-text">
                               <h2>Пожалуйста, подождите</h2>
                               <small>Проводится процедура установки первого пароля, это может занять несколько минут...</small>
                           </div>
                       </div>
                       <div v-if="ui.status == 2" class="setup-password__status-box_no-loader">
                           <div class="setup-password__response-ok">
                               Выполнено успешно
                           </div>
                           <div class="setup-password__close" @click.prevent="onResetSetupPassword"></div>
                       </div>
                       <div v-if="ui.status == 3" class="setup-password__status-box_no-loader">
                           <div class="setup-password__response-error">
                               {{ ui.response }}
                           </div>
                           <div class="setup-password__close" @click.prevent="onResetSetupPassword"></div>
                       </div>
                    </div>
                </div>
                
            </section>
            
            <section class="main__tools tools">
                <header class="tools__header main__header tools__header_margin_bottom">
                    <h1 class="header__text tools__header_border_bottom tools__header_padding text_size_caption font-regular">Доступные инструменты</h1>
                </header>
                <div class="tools__container container container_padding">
                
                <a href="/employees/" class="tools__link item_margin 
                    <?php echo ($user->hasRightsAtLeast(User::STATUS_SET_UP)) ? "" :"tools__disable"; ?>
                ">
                        <div class="container__item item">
                                <div class="item__picture picture" style='backgroundImage: url(/img/icon-control-menu/employees.png)'>
                                    <!--<img class="picture__img" src="img/icon-control-menu/employees.png" alt="picture">-->
                                </div>
                            <div class="item__text item__text_width">
                                <header class="item__header item__header_line-height item__text_head">
                                    <h3 class="header__text font-regular">Мои сотрудники</h3>
                                </header>
                                <p class="item__description description description_text_size description_padding text_color_grey item__text_desc">Добавляйте, удаляйте сотрудиков организации
                                        и управляйте их доступом к своим папкам.</p>
                            </div>   
                        </div>
                    </a>
                    
                    <a href="/folders/" class="tools__link item_margin <?php echo ($user->hasRightsAtLeast(User::STATUS_SET_UP)) ? "" :"tools__disable"; ?>">
                        <div class="container__item item">
                                <div class="item__picture picture" style='backgroundImage: url(/img/icon-control-menu/folders.png)'>
                                    <!--<img class="picture__img" src="img/icon-control-menu/folders.png" alt="picture">-->
                                </div>
                            <div class="item__text item__text_width">
                                <header class="item__header item__header_line-height item__text_head">
                                    <h3 class="header__text font-regular">Мои папки</h3>
                                </header>
                                <p class="item__description description description_text_size description_padding text_color_grey item__text_desc">Управляйте содержимым корпоративных папок
                                        и доступом сотрудников к ним.</p>
                            </div>   
                        </div>
                    </a>
                    <a href="/billing/" class="tools__link item_margin <?php echo ($user->hasRightsAtLeast(User::STATUS_ASSIGNED_LICENSE)) ? "" :"tools__disable"; ?>">
                        <div class="container__item item">
                                <div class="item__picture picture" style='backgroundImage: url(/img/icon-control-menu/payments.png)'>
                                    <!--<img class="picture__img" src="img/icon-control-menu/payments.png" alt="picture">-->
                                </div>
                            <div class="item__text item__text_width">
                                <header class="item__header item__header_line-height item__text_head">
                                    <h3 class="header__text font-regular">Мои платежи</h3>
                                </header>
                                <p class="item__description description description_text_size description_padding text_color_grey item__text_desc">Просматривайте историю платежных 
                                        транзакций, получайте счета и расчетные 
                                        документы.</p>
                            </div>   
                        </div>
                    </a>
                    <a href="/profile/" class="tools__link item_margin <?php echo ($user->hasRightsAtLeast(User::STATUS_JUST_CREATED)) ? "" :"tools__disable"; ?>">
                        <div class="container__item item">
                                <div class="item__picture picture" style='backgroundImage: url(/img/icon-control-menu/data.png)'>
                                    <!--<img class="picture__img" src="img/icon-control-menu/data.png" alt="picture">-->
                                </div>
                            <div class="item__text item__text_width">
                                <header class="item__header item__header_line-height item__text_head">
                                    <h3 class="header__text font-regular">Мои данные</h3>
                                </header>
                                <p class="item__description description description_text_size description_padding text_color_grey item__text_desc">Укажите учетные данные компании, требуемые
                                        для документооборота с Desktop.rent.</p>
                            </div>   
                        </div>
                    </a>
                    <a href="/support/" class="tools__link item_margin <?php echo ($user->hasRightsAtLeast(User::STATUS_ASSIGNED_LICENSE)) ? "" :"tools__disable"; ?>">
                        <div class="container__item item">
                                <div class="item__picture picture" style='backgroundImage: url(/img/icon-control-menu/support.png)'>
                                    <!--<img class="picture__img" src="img/icon-control-menu/support.png" alt="picture">-->
                                </div>
                            <div class="item__text item__text_width">
                                <header class="item__header item__header_line-height item__text_head">
                                    <h3 class="header__text font-regular">Техподдержка</h3>
                                </header>
                                <p class="item__description description description_text_size description_padding text_color_grey item__text_desc">Общайтесь с Вашим персональным менеджером
                                        по вопросам работы с платформой Desktop.rent.</p>
                            </div>   
                        </div>
                    </a>
                    <a href="/services/" class="tools__link item_margin <?php echo ($user->hasRightsAtLeast(User::STATUS_ASSIGNED_LICENSE)) ? "" :"tools__disable"; ?>">
                        <div class="container__item item">
                                <div class="item__picture picture" style='backgroundImage: url(/img/icon-control-menu/atomic-bond.png)'>
                                    <!--<img class="picture__img" src="img/icon-control-menu/services.png" alt="picture">-->
                                </div>
                            <div class="item__text item__text_width">
                                <header class="item__header item__header_line-height item__text_head">
                                    <h3 class="header__text font-regular">Мои сервисы</h3>
                                </header>
                                <p class="item__description description description_text_size description_padding text_color_grey item__text_desc">Просматривайте и управляйте списком
                                        подключенных услуг.</p>
                            </div>   
                        </div>
                    </a>
                </div>
            </section>
        </main>
        <?php include $_SERVER['DOCUMENT_ROOT']."/modules/footer.php";?>
    </div>
    
    <script src="/js/control-panel.js"></script>
    
</body>
</html>