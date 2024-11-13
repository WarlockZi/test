<?php

use app\core\Icon;

?>
<a href="/catalog/perchatki_medicinskie" class="banner gloves">
    <div class="banner__text">
        <div class="banner__container right">
            <h3 class="h3">Медицинские перчатки</h3>
            <p class="p">Нитриловые перчатки добавят комфорта
                в работе. Плотно облегает руку. Минимально
                сокращают чувствительность.
            </p>
        </div>
    </div>
</a>

<a href="/catalog/odnorazovaya_odezhda" class="banner boot-cover">
    <div class="banner__text">
        <div class="banner__container left">
            <h3 class="h3">Одноразовая одежда</h3>
            <p class="p">Обеспечьте чистоту ваших помещений.
                Бахилы с двойным дном обладают
                повышенной износоустойчивостью
            </p>
        </div>
    </div>
</a>


<a href="/catalog/stomatologicheskiy_instrument_" class="banner endosirynge">
    <div class="banner__text">
        <div class="banner__container right">
            <h3 class="h3">Одноразовый инструмент</h3>
            <p class="p">Поможет быстро и эффективно промыть
                зубные каналы. Прост в использовании.
            </p>
        </div>
    </div>
</a>


<div class="advantages">
    <div class="advantages__wrap">
        <div class="advantages__title typing-animation">Почему выбирают нас</div>
        <div class="advantage__cards-wrap">

            <div class="advantage__card assortiment">
                <?= Icon::checkSquare('feather'); ?>
                <h3 class="h3">Ассортимент</h3>
                <p class="p">Легко сориентироваться. Ничего лишнего.</p>
            </div>

            <div class="advantage__card delivery">
                <?= Icon::truck('feather'); ?>
                <h3 class="h3">Доставка</h3>
                <p class="p">Согласуем с Вами сроки поставки.</p>

            </div>

            <div class="advantage__card result">
                <?= Icon::package('feather'); ?>
                <h3 class="h3">Наличие</h3>
                <p class="p">Обеспечиваем достаточное количество товара на складе.</p>
            </div>

            <div class="advantage__card certificates">
                <?= Icon::layers('feather'); ?>
                <h3 class="h3">Сертификаты</h3>
                <p class="p">Предоставляем сертификаты по запросу.</p>
            </div>
        </div>
    </div>
</div>

<div class="workflow">
    <div class="workflow__title typing-animation">Как мы работаем</div>
    <div class="workflow__wrap">
        <div class="static-container">
            <div class="step">Делаете заказ на сайте или звоните менеджеру</div>
        </div>
        <div class="static-container">
            <div class="step">Мы отправляем Вам счет</div>
        </div>
        <div class="static-container">
            <div class="step">Вы его оплачиваете</div>
        </div>
        <div class="static-container">
            <div class="step">Мы оформляем документы</div>
        </div>
        <div class="static-container">
            <div class="step">Отправляем на транспортную компанию товар</div>
        </div>
        <div class="static-container">
            <div class="step">Транспортная компания доставляет</div>
        </div>
        <div class="static-container">
            <div class="step last">Вы принимаете товар. Подписываете документы. Отправляете их нам</div>
        </div>
    </div>
</div>

