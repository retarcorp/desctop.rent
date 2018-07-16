<?php
    
    #$_SERVER['DOCUMENT_ROOT'] = 'C:\inetpub\wwwroot\desktop.rent';
    require_once $_SERVER['DOCUMENT_ROOT']."/Classes/autoload.php";
    use Classes\Utils\Safety;
    Safety::declareProtectedZone();    

    use Classes\Models\Users\UsersFactory;
    use Classes\Models\Users\User;
    
    $factory = new UsersFactory();
    $user = $factory->getCurrentUser();

    $currentPath = trim($_SERVER["REQUEST_URI"], "/");
    
    $employeesClass = $currentPath == "employees" ? "active" : "";
    $foldersClass = $currentPath == "folders" ? "active" : "";
    $billingClass = $currentPath == "billing" ? "active" : "";
    $profileClass = $currentPath == "profile" ? "active" : "";
    $supportClass = $currentPath == "support" ? "active" : "";
    $servicesClass = $currentPath == "services" ? "active" : "";

?>
<section class="main__left-menu left-menu left-menu_position">
    <!--<a href='/connection/rdp/' class="left-menu__entrance button button_theme_sky-light left-menu__button_size left-menu__button_margin">-->
    <!--    <span class="button_text button__text_size_small button__text_color" style="line-height: 36px;">Войти в рабочий стол</span>-->
    <!--</a>-->
    <nav class="left-menu__menu">
        <ul class="left-menu__list list">
            <?php if($user->status == User::STATUS_SET_UP){ ?>
            <li class="list__item item__employees <?= $employeesClass?>" ><a href='/employees/'>Мои сотрудники</a></li>
            <li class="list__item item__folders <?= $foldersClass ?>"><a href='/folders/'>Мои папки</a></li>
            
            <?php } ?>
            <li class="list__item item__payments <?= $billingClass ?>"><a href='/billing/'>Мои платежи</a></li>
            <li class="list__item item__data <?= $profileClass ?>"><a href='/profile/'>Мои данные</a></li>
            <li class="list__item item__support <?= $supportClass ?>"><a href='/support/'>Моя поддержка</a></li>
            <?php if($user->status == User::STATUS_SET_UP){ ?>
            <li class="list__item item__services <?= $servicesClass ?>"><a href='/services/'>Мои сервисы</a></li>
            <?php } ?>
        </ul>
    </nav>
</section>