<?php
    use Classes\Models\Users\UsersFactory;
    use Classes\Models\Users\User;
    use Classes\Models\Users\ProfileData;
    
    $factory = new UsersFactory();
    $user = $factory->getCurrentUser();
    var_dump($user->feature);
    function printFormFields($fields) { //\
        global $user;
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
        
    }
?>

<section class="right-tab__tab-data tab-data active" id='content'>

    <header class="tab__header">
        <h1 class="header__text text_size_header">Ваши учетные данные</h1>
        <ul class="header__nav-path text_color_grey font-regular">Вы здесь:
            <li class="header__list-item"><a href="#" class="text_color_blue">Мои данные</a></li>
        </ul>
        <p class="text_size_min-small text-margin">Введите ИНН организации. Необходимые данные об организации будут вставлены автоматически; недостающие данные укажите вручную.</p>
    </header>
    <div class="right-tab__selection">
        <ul class="selection__list">
            <li class="font-regular button__company active">Юридическое лицо</li>
            <li class="font-regular button__associate">Физическое лицо</li>
        </ul>  
    </div>
    
    <div class="tab-data__content tab-data__content_margin_top form__company active" data-form='form__company'>
        
        <div class="tab-data__field field field_margin_bottom">
            <label for="inn" class="field__label">
                <span class="text_size_small text_color_dark font-regular">ИНН</span>
            </label>
            <input id="inn" value='<?=$user->feature==User::LEGAL_ENTITY && $user->inn ? $user->inn : ''?>' @input="onInnChanged" type="text" class="field__input input input_height text_size_small text_color_dark font-regular">
        </div>
        <div class="tab-data__field field field_margin_bottom">
            <label for="email" class="field__label">
                <span class="text_size_small text_color_dark font-regular">E-mail</span>
            </label>
            <input id="email" value='<?=$user->feature==User::LEGAL_ENTITY && $user->email ? $user->email : ''?> 'type="email" class="field__input input input_height text_size_small text_color_dark font-regular">
        </div>
        <div class="tab-data__field field field_margin_bottom">
            <label for="phone" class="field__label">
                <span class="text_size_small text_color_dark font-regular">Телефон</span>
            </label> 
            <input id="phone" value='<?=$user->feature==User::LEGAL_ENTITY ? $user->phone : ''?>' type="phone" readonly class="field__input input input_height text_size_small text_color_dark font-regular">
        </div>

        <?php
            $legalEntityFields = ProfileData::$legalEntityFields;
            printFormFields($legalEntityFields);
            
        ?>

        <div class="tab-data__save save save_margin">
            <!--<button class="button button_theme_sky-dark save__button_size loader_relative" @click.prevent="onSave" id="companySend">-->
            <button class="button button_theme_sky-dark save__button_size loader_relative" id="companySend"> 
                <span class="button_text button__text_color button__text_size_small font-regular">Сохранить изменения</span>
                <div class="loader hidden">
                    <div class="loader__item"></div>        
                </div>
            </button>
            <span v-if="saved" class="save__message save__message_margin text_size_14">Изменения сохранены!</span>
        </div>
    </div>
    
    <div class="tab-data__content tab-data__content_margin_top form__associate" data-form='form__associate'>
        
        <div class="tab-data__field field field_margin_bottom">
            <label for="innAssociate" class="field__label">
                <span class="text_size_small text_color_dark font-regular">ИНН</span>
            </label>
            <input id="innAssociate" value='<?=$user->feature==User::INDIVIDUAL_FACE && $user->inn ? $user->inn : ''?>' @input="onInnChanged" type="text" class="field__input input input_height text_size_small text_color_dark font-regular">
        </div>
        <div class="tab-data__field field field_margin_bottom">
            <label for="phoneAssociate" class="field__label">
                <span class="text_size_small text_color_dark font-regular">Телефон</span>
            </label> 
            <input id="phoneAssociate" value='<?=$user->feature==User::INDIVIDUAL_FACE ? $user->phone : ''?>' type="phone" readonly class="field__input input input_height text_size_small text_color_dark font-regular">
        </div>
        <div class="tab-data__field field field_margin_bottom">
            <label for="emailAssociate" class="field__label">
                <span class="text_size_small text_color_dark font-regular">E-mail</span>
            </label>
            <input id="emailAssociate" value='<?=$user->feature==User::INDIVIDUAL_FACE && $user->email ? $user->email : ''?> 'type="email" class="field__input input input_height text_size_small text_color_dark font-regular">
        </div>

        <?php
            $fieldsForIndividualFace = ProfileData::$fieldsForIndividualFace;
            printFormFields($fieldsForIndividualFace);
            
        ?>

        <div class="tab-data__save save save_margin">
            <button class="button button_theme_sky-dark save__button_size loader_relative" id="associateSend">
                <span class="button_text button__text_color button__text_size_small font-regular">Сохранить изменения</span>
                <div class="loader hidden">
                    <div class="loader__item"></div>        
                </div>
            </button>
            <span v-if="saved" class="save__message save__message_margin text_size_14">Изменения сохранены!</span>
        </div>
    </div>
</section>





