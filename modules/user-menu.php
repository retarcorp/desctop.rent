<section class="main__left-menu left-menu left-menu_position left-menu_theme_dark">
    <button class="left-menu__entrance button button_theme_sky-light left-menu__button_size left-menu__button_margin">
        <span class="button_text button__text_size_small button__text_color">Войти в рабочий стол</span>
    </button>
    <nav class="left-menu__menu">
        <ul class="left-menu__list list">
            <li class="list__item item__employees text_size_min-small text_color_white <?= (strstr($_SERVER["REQUEST_URI"] , 'employees')) ? "active" : ""?>" ><a href='/employees/'>Мои сотрудники</a></li>
            <li class="list__item item__folders text_size_min-small text_color_white" <?= strstr($_SERVER["REQUEST_URI"], 'folders') ? "class='active'" : "" ?>><a href='/folders/'>Мои папки</a></li>
            <li class="list__item item__payments text_size_min-small text_color_white" <?= strstr($_SERVER["REQUEST_URI"], 'billing') ? "class='active'" : "" ?>><a href='/billing/'>Мои платежи</a></li>
            <li class="list__item item__data text_size_min-small text_color_white" <?= strstr($_SERVER["REQUEST_URI"], 'profile') ? "class='active'" : "" ?>><a href='/profile/'>Мои данные</a></li>
            <li class="list__item item__support text_size_min-small text_color_white" <?= strstr($_SERVER["REQUEST_URI"], 'support') ? "class='active'" : "" ?>><a href='/support/'>Моя поддержка</a></li>
            <li class="list__item item__services text_size_min-small text_color_white" <?= strstr($_SERVER["REQUEST_URI"], 'services') ? "class='active'" : "" ?>><a href='/services/'>Мои сервисы</a></li>
        </ul>
    </nav>
</section>


