<footer class="footer">
    <nav class="menu">

        <? if (isset($rootCategories)): ?>

            <ul class="column">
                <? foreach ($rootCategories as $category): ?>
                    <li>
                        <a href="/catalog/<?= $category->ownProperties->path; ?>"><?= mb_strtolower($category->name); ?></a>
                    </li>

                <? endforeach ?>
            </ul>
        <? endif; ?>

        <ul class="column">
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
        <ul class="column">
            <li>
                <a href="/main/returnChange">Возврат и обмен</a>
            </li>
            <li>
                <a href="/main/politicaconf">Политика конфиденциальности</a>
            </li>
            <li>
                <a href="/main/oferta">Оферта</a>
            </li>
        </ul>

    </nav>
    <div class="legal">
        <p>© <? echo date('Y') ?> Витекс. Цены, указанные на сайте, не являются публичной офертой, определяемой
            положением Статьи 437 (2) ГК РФ и зависят от объема заказа. ИНН:352507425251</p>
        <!--        <div class="creator">VORONIKLAB-->
        <!--            <img src="/pic/srvc/creator.jpg" class="creator-img">-->
        <!--        </div>-->
    </div>
    <? $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ya_metrica.php'; ?>
    <? if ($_ENV['DEV'] !== "1") {
        include $path;
    } ?>
</footer>
