<footer class="footer">
    <div class="menu">
        <div class="column">
            <a href="/main/contacts">Контакты</a>
            <a href="/main/requisites">Реквизиты</a>
        </div>
        <div class="column">
            <a href="/main/news">Новости</a>
        </div>
        <div class="column">
            <a href="/main/returnChange">Возврат и обмен</a>
            <a href="/main/politicaconf">Политика конфиденциальности</a>
            <a href="/main/oferta">Оферта</a>
        </div>

    </div>
    <div class="legal">
        <p>© <? echo date('Y') ?> Витекс. Цены, указанные на сайте, не являются публичной офертой, определяемой
            положением Статьи 437 (2) ГК РФ и зависят от объема заказа. ИНН:352507425251</p>
        <div class="creator">VORONIKLAB
            <img src="/pic/srvc/creator.jpg" class="creator-img">
        </div>
    </div>
    <? $path = dirname(__FILE__) . DIRECTORY_SEPARATOR.'ya_metrica.php'; ?>
    <? if ($_ENV['DEV']!=="1") {
        include $path;
    }?>
</footer>
