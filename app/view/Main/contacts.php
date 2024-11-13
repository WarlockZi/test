<?

use app\controller\Address; ?>
<main class="contacts">


    <h1>Контактная информация</h1>

    <div itemscope itemtype="http://schema.org/Organization">
        <div class="column">
            <h3>Компания</h3>
            <p itemprop="name">Витекс</p>
        </div>

        <div itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
            <div class="column">
                <h3>Юридический / Почтовый адрес:</h3>
                <p><?= Address::postCodeDecorator(Address::$factAddress); ?></p>
            </div>
        </div>

        <div class="column">
            <h3>Email:</h3>
            <a href="mailto:10@vitexopt.ru"><span itemprop="email">10@vitexopt.ru</span></a>
        </div>

        <div class="column">
            <h3>телeфоны :</h3>
            <a href="tel:+79217131767"><span itemprop="telephone">8-921-713-17-67</span></a>
        </div>
    </div>


    <iframe class='map'
            src="https://yandex.ru/map-widget/v1/?um=constructor%3Af2e10dc8e6d98680280adec8d6b42c62ac41e279d695ac3d091059b5f407a8a7&amp;source=constructor"
            width="100%" height="400" frameborder="0"></iframe>
</main>