<?php

namespace app\controller;


use app\repository\PromotionRepository;
use app\service\Meta\MetaService;
use JetBrains\PhpStorm\NoReturn;

class MainController extends AppController
{
    public function __construct(
        private readonly MetaService $meta,
        private readonly string      $titleTail = " купить в интернет-магазине VITEX в Вологде. Большой ассортимент медицинской одежды, оборудования и расходников по выгодной цене. Звоните и заказывайте прямо сейчас онлайн на сайте",
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(): void
    {
        $this->meta->setMeta('Нитриловые перчатки оптом',
            'Доставим нитриловые перчатки, бахилы, маски по России. Оптом.',
            'нитриловые перчатки, бахилы, маски, расходные материалы, доставка, производство, по России');
         view('main.index', [],200);
    }

    #[NoReturn] public function actionContacts(): void
    {
        $this->meta->setMeta(
            'Контакты - Витекс',
            'Контакты' . $this->titleTail,
            'Контакты');
        view('main.contacts');
    }
    #[NoReturn] public function actionNews(): void
    {
        $content = 'Следите за новостями)';

        $this->meta->setMeta('Новости',
            'Новости' . $this->titleTail,
            'Новости');
        view('main.news', compact('content'));
    }
    #[NoReturn] public function actionAbout(): void
    {
        $this->meta->setMeta('О нас',
            'О нас' . $this->titleTail,
            'О нас');
        view('main.about');
    }
    #[NoReturn] public function actionPromotions(): void
    {
        $this->meta->setMeta('Акции',
            'Акции' . $this->titleTail,
            'Акции');

        $activePromotions = PromotionRepository::active()->toArray();
        $inactivePromotions = PromotionRepository::inactive()->toArray();
        view('promotion.promotions',
            compact('activePromotions', 'inactivePromotions'));
//        view('main.promotions');
    }
    #[NoReturn] public function actionStatii(): void
    {
        $this->meta->setMeta(
            'Статьи - Витекс',
            'Статьи ' . $this->titleTail,
            'Статьи');
        view('main.statii');
    }

    #[NoReturn] public function actionGarantii(): void
    {
        $this->meta->setMeta(
            'Гарантии - Витекс',
            'Гарантии ' . $this->titleTail,
            'Гарантии');
        view('main.garantii');
    }

    #[NoReturn] public function actionReturnChange(): void
    {
        $this->meta->setMeta('Возврат и обмен',
            'Возврат и обмен' . $this->titleTail,
            'Возврат и обмен');
        view('main.returnchange');
    }
    #[NoReturn] public function actionPoliticaconf()
    {
        $this->meta->setMeta(
            'Политика конфиденциальности - Витекс',
            'Политика конфиденциальности ' . $this->titleTail,
            'Политика конфиденциальности');
        view('main.politicaconf');
    }

    #[NoReturn] public function actionOferta(): void
    {
        $this->meta->setMeta('Оферта',
            'Оферта' . $this->titleTail,
            'Оферта');
        view('main.oferta');
    }
    #[NoReturn] public function actionSitemap(): void
    {
        $categories = "<ul class='category-tree'>" . "</ul>";
        $content    = file_get_contents(ROOT . '/sitemap.html');

        $this->meta->setMeta(
            'Карта сайта - Витекс',
            'Карта сайта ' . $this->titleTail,
            'Карта сайта');
        view('main.sitemap', compact('content'));
    }

    #[NoReturn] public function actionRequisites(): void
    {
        $this->meta->setMeta(
            'Реквизиты - Витекс',
            'Реквизиты ' . $this->titleTail,
            'Реквизиты');
        view('main.requisites');
    }

    #[NoReturn] public function actionDiscount(): void
    {
        $this->meta->setMeta(
            'Скидки - Витекс',
            'Скидки ' . $this->titleTail,
            'Скидки от обьема.');
        view('main.discount');
    }

    #[NoReturn] public function actionDelivery(): void
    {
        $this->meta->setMeta(
            'Доставка - Витекс',
            'Доставка ' . $this->titleTail,
            'Доставка по Росссии.');
        view('main.delivery');
    }

    #[NoReturn] public function actionPayment(): void
    {
        $this->meta->setMeta(
            'Оплата - Витекс',
            'Оплата ' . $this->titleTail,
            'Оплата.');
        view('main.payment');
    }

}
