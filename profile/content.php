<?php
    use Classes\Models\Users\UsersFactory;
    use Classes\Models\Users\User;

    $factory = new UsersFactory();
    $user = $factory->getCurrentUser();

    use Classes\Models\Users\ProfileData;
    
?>

<section class="right-tab__tab-data tab-data active" id='content'>
    <header class="tab__header">
        <h1 class="header__text text_size_header">Ваши учетные данные</h1>
        <ul class="header__nav-path text_color_grey">Вы здесь:
            <li class="header__list-item"><a href="#" class="text_color_blue">Мои данные</a></li>
        </ul>
    </header>
    <div class="tab-data__content tab-data__content_margin_top">
        
        <div class="tab-data__field field field_margin_bottom">
            <label for="inn" class="field__label">
                <span class="text_size_small text_color_dark font-regular">ИНН</span>
            </label>
            <input id="inn" value='<?=$user->inn ? $user->inn : ''?>' type="text" class="field__input input input_height text_size_small text_color_dark font-regular">
        </div>
        <div class="tab-data__field field field_margin_bottom">
            <label for="email" class="field__label">
                <span class="text_size_small text_color_dark font-regular">E-mail</span>
            </label>
            <input id="email" value='<?=$user->email ? $user->email : ''?> 'type="email" class="field__input input input_height text_size_small text_color_dark font-regular">
        </div>
        <div class="tab-data__field field field_margin_bottom">
            <label for="phone" class="field__label">
                <span class="text_size_small text_color_dark font-regular">Телефон</span>
            </label> 
            <input id="phone" value='<?=$user->phone?>' type="phone" readonly class="field__input input input_height text_size_small text_color_dark font-regular">
        </div>

        <?php
            $fields = ProfileData::$fields;
            $data = $user->getProfileData();
            foreach($fields as $i=>$field){
                $val = $data->getValueFor($i);
                echo '
                <div class="tab-data__field field field_margin_bottom">
                    <label for="name-company" class="field__label">
                        <span class="text_size_small text_color_dark font-regular">'.$field.'</span>
                    </label>
                    <input id="field-'.$i.'" value="'.$val.'" type="text" class="field__input input input_height text_size_small text_color_dark font-regular">
                </div>
                ';
            }
        ?>
        
        <!-- <div class="tab-data__field field field_margin_bottom">
            <label for="region" class="field__label">
                <span class="text_size_small text_color_dark font-regular">Регион</span>
            </label>
            <input id="region" type="text" class="field__input input input_height text_size_small text_color_dark font-regular">
        </div>
        <div class="tab-data__field field field_margin_bottom">
            <label for="bank-name" class="field__label">
                <span class="text_size_small text_color_dark font-regular">Название банка</span>
            </label>
            <input id="bank-name" type="text" class="field__input input input_height text_size_small text_color_dark font-regular">
        </div>
        <div class="tab-data__field field field_margin_bottom">
            <label for="kpp" class="field__label">
                <span class="text_size_small text_color_dark font-regular">КПП</span>
            </label>
            <input id="kpp" type="text" class="field__input input input_height text_size_small text_color_dark font-regular">
        </div>
        <div class="tab-data__field field field_margin_bottom">
            <label for="bik" class="field__label">
                <span class="text_size_small text_color_dark font-regular">БИК</span>
            </label>
            <input id="bik" type="text" class="field__input input input_height text_size_small text_color_dark font-regular">
        </div>
        <div class="tab-data__field field field_margin_bottom">
            <label for="account" class="field__label">
                <span class="text_size_small text_color_dark font-regular">Расчетный счет</span>
            </label>
            <input id="account" type="text" class="field__input input input_height text_size_small text_color_dark font-regular">
        </div>
    </div> -->
    <div class="tab-data__save save save_margin">
        <button class="button button_theme_sky-dark save__button_size" @click.prevent="onSave">
            <span class="button_text button__text_color button__text_size_small">Сохранить изменения</span>
        </button>
        <span v-if="saved" class="save__message save__message_margin text_size_14">Изменения сохраненны!</span>
    </div>
</section>