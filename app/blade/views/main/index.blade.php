@php
    use app\view\components\Icon\Icon;
@endphp

@section('title', $meta->title)
@section('description', $meta->description)
@section('keywords', $meta->keywords)

@extends('layouts.main.main')


@section('content')
    <a href="/catalog/perchatki_medicinskie" class="banner gloves">
        <div class="banner__text">
            <div class="banner__container right">
                <h1 class="h1">Медицинские перчатки оптом «Витекс»</h1>
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

    <div class="block_work">

        <div class="workflow__title typing-animation">Как мы работаем</div>

        <div class="workflow__wrap">
            <div class="block1">
                <p style="margin: auto; text-align: center;"><img
                            src="/storage/app/pic/icons/21288567_user-experience_12440970_7447763.svg" class="img_main"></p>
                <p style="margin: auto; text-align: center;">Вы звоните нам или оставляете заявку через форму на
                    сайте</p>
            </div>
            <p style="margin-top: 60px;"><img src="/storage/app/pic/icons/strelka.png" class="strelka"></p>
            <div class="block1">
                <p style="margin: auto; text-align: center;"><img
                            src="/storage/app/pic/icons/21288568_shopping-list_12441220_7447763.svg" class="img_main"></p>
                <p style="margin: auto; text-align: center;">Выставляем счет на оплату</p>
            </div>
            <p style="margin-top: 60px;"><img src="/storage/app/pic/icons/strelka.png" class="strelka"></p>
            <div class="block1">
                <p style="margin: auto; text-align: center;"><img src="/storage/app/pic/icons/21288566_payment_9341320_7447763.svg"
                                                                  class="img_main"></p>
                <p style="margin: auto; text-align: center;">Вы оплачиваете покупку</p>
            </div>
            <p style="margin-top: 60px;"><img src="/storage/app/pic/icons/strelka.png" class="strelka"></p>
            <div class="block1">
                <p style="margin: auto; text-align: center;"><img
                            src="/storage/app/pic/icons/21288569_delivery-truck_17264164_7447763.svg" class="img_main"></p>
                <p style="margin: auto; text-align: center;">Мы доставляем товар до клиента</p>
            </div>
        </div>

    </div>

    <div class="brands">
        <div class="brands__title typing-animation">Популярные бренды</div>
        <div class="brands__wrap">
            <a href="/brands/benovy"><img src="/pic/brands/benovy.svg"></a>
            <a href="/brands/dispodent"><img src="/pic/brands/dispodent.png"></a>
            <a href="/brands/elegreen"><img src="/pic/brands/EleGreen.png"></a>
            <a href="/brands/imsstore"><img src="/pic/brands/imsstore.gif"></a>
            <a href="/brands/klever"><img src="/pic/brands/klever.png"></a>
            <a href="/brands/matrix"><img src="/pic/brands/matrix.svg"></a>
            <a href="/brands/medenta"><img src="/pic/brands/medenta.jpg"></a>
            <a href="/brands/mediok"><img src="/pic/brands/mediok.svg"></a>
            <a href="/brands/protecodent"><img src="/pic/brands/protecodent.svg"></a>
            <a href="/brands/sitekmed"><img src="/pic/brands/sitekmed.png"></a>
            <a href="/brands/unite"><img src="/pic/brands/unite.svg"></a>

        </div>
    </div>

@endsection

