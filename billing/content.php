<section class="right-tab__tab-data tab-data active" id="content">
    <header class="tab__header">
        <h1 class="header__text text_size_header">Лицевой счет</h1>
        <ul class="header__nav-path text_color_grey">Вы здесь:
            <li class="header__list-item"><a href="#" class="text_color_blue">Мои платежи</a></li>
        </ul>
    </header>
    <div class="bills">
        <h1 class="bills__header font-regular">Ваши счета: </h1>
        <div class="bills__item">
            <h2 class="bills__who font-regular">Внесено от <span class="font-regular">ООО "СК Трейд"</span></h2>
            <div class="bills__payment">
                <p class="payment__count">0 Руб.</p>
                <div class="payment__description">
                    <p class="payment__for">3592/8 Разовый договор (участие в конференции)</p>
                    <p class="payment__lock">+ Еще 1000,00 руб. заблокированно на специальные услуги</p>
                </div>
            </div>
            <div class="bills__payment">
                <p class="payment__count">0 Руб.</p>
                <div class="payment__description">
                    <p class="payment__for">3592/7 Публичная оферта</p>
                    <p class="payment__lock">+ Еще 600,20 руб. заблокированно на специальные услуги</p>
                </div>
            </div>
        </div>
    </div>
    <ul class="selection__list">
        <li class="font-regular button__company active">История пополнения</li>
        <li class="font-regular button__associate">История расходов</li>
        <li class="font-regular button__associate">Заказные и оплаченные услуги</li>
    </ul>
    <div class="tab-data__content tab-data__content_margin_top">
        <table class="table__employees table_margin">
            <tr class="table__row" v-for="item in billings" :key="item.id">
                <td class="table__col col__date">{{ item.added.split(" ")[0] }}</td>
                <td class="table__col col__price">{{ item.sum }} Руб</td>
                <td class="table__col col__status">{{ item.status }}</td>
                <td class="table__col col__fileDOC">
                    <a :href="'/api/user/transactions/' ">Скачать DOC</a>
                </td>
                <td class="table__col col__filePDF">
                    <a href="#">Скачать PDF</a>
                </td>
            </tr>
        </table>
        
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
</section>