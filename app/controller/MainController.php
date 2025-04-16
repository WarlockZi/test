<?php

namespace app\controller;


use app\Services\Response;

class MainController extends AppController
{
    public function __construct(
        private readonly string $titleTail = " купить в интернет-магазине VITEX в Вологде. Большой ассортимент медицинской одежды, оборудования и расходников по выгодной цене. Звоните и заказывайте прямо сейчас онлайн на сайте",
    )
    {parent::__construct();}

    public function actionIndex(): void
    {
        $this->assets->setMeta('Нитриловые перчатки оптом',
            'Доставим нитриловые перчатки, бахилы, маски по России. Оптом.',
            'нитриловые перчатки, бахилы, маски, расходные материалы, доставка, производство, по России');
         Response::view('main.index', [],200);
    }

    public function actionContacts()
    {
        $this->assets->setMeta(
            'Контакты - Витекс',
            'Контакты' . $this->titleTail,
            'Контакты');
        Response::view('main.contacts');
    }
    public function actionNews()
    {
        $content = 'Следите за новостями)';
        $this->setVars(compact('content'));
        $this->assets->setMeta('Новости',
            'Новости' . $this->titleTail,
            'Новости');
        Response::view('main.news', compact('content'));
    }
    public function actionAbout()
    {
        $this->assets->setMeta('О нас',
            'О нас' . $this->titleTail,
            'О нас');
        Response::view('main.about');
    }
    public function actionPromotions()
    {
        $this->assets->setMeta('Акции',
            'Акции' . $this->titleTail,
            'Акции');
        Response::view('main.promotions');
    }
    public function actionStatii()
    {
        $this->assets->setMeta(
            'Статьи - Витекс',
            'Статьи ' . $this->titleTail,
            'Статьи');
        Response::view('main.statii');
    }

    public function actionGarantii()
    {
        $this->assets->setMeta(
            'Гарантии - Витекс',
            'Гарантии ' . $this->titleTail,
            'Гарантии');
        Response::view('main.garantii');
    }

    public function actionReturnChange()
    {
        $this->assets->setMeta('Возврат и обмен',
            'Возврат и обмен' . $this->titleTail,
            'Возврат и обмен');
        Response::view('main.returnchange');
    }
    public function actionPoliticaconf()
    {
        $this->assets->setMeta(
            'Политика конфиденциальности - Витекс',
            'Политика конфиденциальности ' . $this->titleTail,
            'Политика конфиденциальности');
        Response::view('main.politicaconf');
    }

    public function actionOferta()
    {
        $this->assets->setMeta('Оферта',
            'Оферта' . $this->titleTail,
            'Оферта');
        Response::view('main.oferta');
    }
    public function actionSitemap(): void
    {
        $categories = "<ul class='category-tree'>" . "</ul>";
        $content    = file_get_contents(ROOT . '/sitemap.html');
        $this->setVars(compact('content', 'categories'));
        $this->assets->setMeta(
            'Карта сайта - Витекс',
            'Карта сайта ' . $this->titleTail,
            'Карта сайта');
        Response::view('main.sitemap', compact('content'));
    }

    public function actionRequisites()
    {
        $this->assets->setMeta(
            'Реквизиты - Витекс',
            'Реквизиты ' . $this->titleTail,
            'Реквизиты');
        Response::view('main.requisites');
    }




    public function actionYandexauth(): void
    {
        $f = 1;
    }

    public function actionDiscount()
    {
    }

    public function actionDelivery()
    {
    }

    public function actionPayment()
    {
    }

}
