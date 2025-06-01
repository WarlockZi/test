<?php

namespace app\controller;


use app\service\Meta\MetaService;
use app\service\Response;

class MainController extends AppController
{
    public function __construct(
        private MetaService $meta,
        private readonly string $titleTail = " купить в интернет-магазине VITEX в Вологде. Большой ассортимент медицинской одежды, оборудования и расходников по выгодной цене. Звоните и заказывайте прямо сейчас онлайн на сайте",
    )
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
        $this->meta->setMeta('Нитриловые перчатки оптом',
            'Доставим нитриловые перчатки, бахилы, маски по России. Оптом.',
            'нитриловые перчатки, бахилы, маски, расходные материалы, доставка, производство, по России');
         Response::view('main.index', [],200);
    }

    public function actionContacts()
    {
        $this->meta->setMeta(
            'Контакты - Витекс',
            'Контакты' . $this->titleTail,
            'Контакты');
        Response::view('main.contacts');
    }
    public function actionNews()
    {
        $content = 'Следите за новостями)';
        $this->setVars(compact('content'));
        $this->meta->setMeta('Новости',
            'Новости' . $this->titleTail,
            'Новости');
        Response::view('main.news', compact('content'));
    }
    public function actionAbout()
    {
        $this->meta->setMeta('О нас',
            'О нас' . $this->titleTail,
            'О нас');
        Response::view('main.about');
    }
    public function actionPromotions()
    {
        $this->meta->setMeta('Акции',
            'Акции' . $this->titleTail,
            'Акции');
        Response::view('main.promotions');
    }
    public function actionStatii()
    {
        $this->meta->setMeta(
            'Статьи - Витекс',
            'Статьи ' . $this->titleTail,
            'Статьи');
        Response::view('main.statii');
    }

    public function actionGarantii()
    {
        $this->meta->setMeta(
            'Гарантии - Витекс',
            'Гарантии ' . $this->titleTail,
            'Гарантии');
        Response::view('main.garantii');
    }

    public function actionReturnChange()
    {
        $this->meta->setMeta('Возврат и обмен',
            'Возврат и обмен' . $this->titleTail,
            'Возврат и обмен');
        Response::view('main.returnchange');
    }
    public function actionPoliticaconf()
    {
        $this->meta->setMeta(
            'Политика конфиденциальности - Витекс',
            'Политика конфиденциальности ' . $this->titleTail,
            'Политика конфиденциальности');
        Response::view('main.politicaconf');
    }

    public function actionOferta()
    {
        $this->meta->setMeta('Оферта',
            'Оферта' . $this->titleTail,
            'Оферта');
        Response::view('main.oferta');
    }
    public function actionSitemap(): void
    {
        $categories = "<ul class='category-tree'>" . "</ul>";
        $content    = file_get_contents(ROOT . '/sitemap.html');
        $this->setVars(compact('content', 'categories'));
        $this->meta->setMeta(
            'Карта сайта - Витекс',
            'Карта сайта ' . $this->titleTail,
            'Карта сайта');
        Response::view('main.sitemap', compact('content'));
    }

    public function actionRequisites()
    {
        $this->meta->setMeta(
            'Реквизиты - Витекс',
            'Реквизиты ' . $this->titleTail,
            'Реквизиты');
        Response::view('main.requisites');
    }

    public function actionDiscount()
    {
        $this->meta->setMeta(
            'Скидки - Витекс',
            'Скидки ' . $this->titleTail,
            'Скидки от обьема.');
        view('main.discount');
    }

    public function actionDelivery()
    {
        $this->meta->setMeta(
            'Доставка - Витекс',
            'Доставка ' . $this->titleTail,
            'Доставка по Росссии.');
        view('main.delivery');
    }

    public function actionPayment()
    {
        $this->meta->setMeta(
            'Оплата - Витекс',
            'Оплата ' . $this->titleTail,
            'Оплата.');
        view('main.payment');
    }

}
