<footer class="footer">
    <nav class="menu">

        <div class="column flex-2 colpay">

            <div>

                <h4>Категории</h4>

                <?php if (!empty($rootCategories)): ?>
                <ul>
                        <?php foreach ($rootCategories as $category): ?>
                    <li>
                        <a href="/catalog/<?= $category->ownProperties->path; ?>"><?= mb_strtolower($category->name); ?></a>
                    </li>

                    <?php endforeach ?>
                </ul>
                <?php endif; ?>

            </div>

            <div class="foot-cont">
                <div>
                    <span>Телефон:</span> <a href="tel:+79217131767">8-921-713-17-67</a>
                </div>
                <div>
                    <span>Почта:</span> <a href="mailto:10@vitexopt.ru">10@vitexopt.ru</a>
                </div>
                <div>
                    <span>Адрес:</span>
                    @deb
                    {!!env('STREET_ZIP')!!},
                    {!!env('STREET_CITY')!!},
                    {!!env('STREET_STREET')!!},
                    {!!env('STREET_HOUSE')!!},
                </div>
            </div>

            <div class="pay-icons">
                <img src="/storage/app/svg/mir.svg">
                <img src="/storage/app/svg/sbp.svg">
            </div>
        </div>

        <div class="column flex-1">

            <h4>Информация</h4>

            <ul>
                <li>
                    <a href="/main/contacts">Контакты</a>
                </li>
                <li>
                    <a href="/main/requisites">Реквизиты</a>
                </li>
                <li>
                    <a href="/main/news">Новости</a>
                </li>

                <li>
                    <a href="/promotion">Акции</a>
                </li>
                <li>
                    <a href="/main/about">О Компании</a>
                </li>
                <li>
                    <a href="/main/statii">Статьи</a>
                </li>
                <li>
                    <a href="/main/garantii">Гарантии</a>
                </li>
                <li>
                    <a href="/main/delivery">Доставка</a>
                </li>
                <li>
                    <a href="/main/discount">Скидки</a>
                </li>
            </ul>
        </div>


        <div class="column flex-2">
            <h4>Для клиентов</h4>
            <ul>
                <li>
                    <a href="/main/returnChange">Возврат и обмен</a>
                </li>
                <li>
                    <a href="/main/politicaconf">Политика конфиденциальности</a>
                </li>
                <li>
                    <a href="/main/oferta">Оферта</a>
                </li>
                <li>
                    <a href="/main/sitemap">Карта сайта</a>
                </li>
            </ul>
        </div>


        @include('layouts.share.footer.feedback')

    </nav>
    <div class="legal">
        <p>© <?php echo date('Y') ?> Витекс. Цены, указанные на сайте, не являются публичной офертой, определяемой
            положением Статьи 437 (2) ГК РФ и зависят от объема заказа. ИНН:352507425251
        </p>
    </div>

</footer>
