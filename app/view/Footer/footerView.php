<footer class="footer">
    <nav class="menu">

        <div class="column flex-2">

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


        <div class="column feedback flex-4">
            <h4 class="feedback-title">Напишите свой вопрос</h4>

            <div class="success-checkmark">
                <div class="check-icon none">
                    <span class="icon-line line-tip"></span>
                    <span class="icon-line line-long"></span>
                    <div class="icon-circle"></div>
                    <div class="icon-fix"></div>
                </div>
            </div>

            <form class="form" method="POST" action="/feedback/message">

                <div class="input-container">
                    <input type="text" placeholder=" " required="" name="name" id="name" autocomplete="false">
                    <div class="badge"></div>
                    <label for="name">ваше имя</label>
                    <div id="nameError"></div>
                </div>

                <div class="input-container">
                    <input type="text" placeholder=" " required="" name="email" id="email" autocomplete="false">
                    <div class="badge"></div>
                    <label for="email">эл. почта</label>
                    <div id="emailError"></div>
                </div>

                <div class="input-container">
                    <input type="text" placeholder=" " required="" name="phone" id="phone" autocomplete="false">
                    <div class="badge"></div>
                    <label for="phone">телефон</label>
                    <div id="phoneError"></div>
                </div>

                <div class="input-container textarea">
                    <textarea name="message" placeholder=" " id="message" rows="6" class="textarea"></textarea>
                    <div class="badge"></div>
                    <label for="message">Сообщение</label>
                    <div id="messageError"></div>
                </div>

                <button type="submit" class="button button-filled feedback-submit" id="feedback-submit">Отправить</button>
            </form>
        </div>

    </nav>
    <div class="legal">
        <p>© <?php echo date('Y') ?> Витекс. Цены, указанные на сайте, не являются публичной офертой, определяемой
            положением Статьи 437 (2) ГК РФ и зависят от объема заказа. ИНН:352507425251</p>
        <!--        <div class="creator">VORONIKLAB-->
        <!--            <img src="/pic/srvc/creator.jpg" class="creator-img">-->
        <!--        </div>-->
    </div>
    <?php
    $metrica = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ya_metrica.php';
    if (!DEV) include $metrica;
    ?>
</footer>
