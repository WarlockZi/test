<footer class="footer">
    <nav class="menu">

        <div class="column">

            <h4>Категории</h4>

            <? if (!empty($rootCategories)): ?>
                <ul>
                    <? foreach ($rootCategories as $category): ?>
                        <li>
                            <a href="/catalog/<?= $category->ownProperties->path; ?>"><?= mb_strtolower($category->name); ?></a>
                        </li>

                    <? endforeach ?>
                </ul>
            <? endif; ?>
        </div>

        <div class="column">

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
            </ul>
        </div>
        <div class="column">
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

    </nav>
    <div class="legal">
        <p>© <? echo date('Y') ?> Витекс. Цены, указанные на сайте, не являются публичной офертой, определяемой
            положением Статьи 437 (2) ГК РФ и зависят от объема заказа. ИНН:352507425251</p>
        <!--        <div class="creator">VORONIKLAB-->
        <!--            <img src="/pic/srvc/creator.jpg" class="creator-img">-->
        <!--        </div>-->
    </div>
    <? $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ya_metrica.php'; ?>
    <? if (!DEV) {
        include $path;
    } ?>
</footer>
