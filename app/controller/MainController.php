<?php

namespace app\controller;


use app\action\MainAction;
use app\repository\PromotionRepository;
use JetBrains\PhpStorm\NoReturn;

class MainController extends AppController
{
    public function __construct(
        private readonly MainAction $actions,
        private readonly string      $titleTail = " купить в интернет-магазине VITEX в Вологде. Большой ассортимент медицинской одежды, оборудования и расходников по выгодной цене. Звоните и заказывайте прямо сейчас онлайн на сайте",
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(): void
    {
        $meta = $this->actions->setMeta(
            'Нитриловые перчатки оптом',
            'Доставим нитриловые перчатки, бахилы, маски по России. Оптом.',
            'нитриловые перчатки, бахилы, маски, расходные материалы, доставка, производство, по России'
        );

         view('main.index', compact('meta'));
    }

    #[NoReturn] public function actionContacts(): void
    {
        $meta = $this->actions->setMeta(
            'Контакты - Витекс',
            'Контакты' . $this->titleTail,
            'Контакты');
        view('main.contacts', compact('meta'));
    }
    #[NoReturn] public function actionNews(): void
    {
        $content = 'Следите за новостями)';

        $meta = $this->actions->setMeta(
            'Новости',
            'Новости' . $this->titleTail,
            'Новости');
        view('main.news', compact('content', 'meta'));
    }
    #[NoReturn] public function actionAbout(): void
    {
        $meta = $this->actions->setMeta(
            'О нас',
            'О нас' . $this->titleTail,
            'О нас');
        view('main.about', compact('meta'));
    }
    #[NoReturn] public function actionPromotions(): void
    {
        $meta = $this->actions->setMeta(
            'Акции',
            'Акции' . $this->titleTail,
            'Акции');

        $activePromotions = PromotionRepository::active()->toArray();
        $inactivePromotions = PromotionRepository::inactive()->toArray();
        view('promotion.promotions',
            compact(
                'meta',
                'activePromotions',
                'inactivePromotions'));

    }
    #[NoReturn] public function actionStatii(): void
    {
        $meta = $this->actions->setMeta(
            'Статьи - Витекс',
            'Статьи ' . $this->titleTail,
            'Статьи');
        view('main.statii', compact('meta'));
    }

    #[NoReturn] public function actionGarantii(): void
    {
        $meta = $this->actions->setMeta(
            'Гарантии - Витекс',
            'Гарантии ' . $this->titleTail,
            'Гарантии');
        view('main.garantii', compact('meta'));
    }

    #[NoReturn] public function actionReturnChange(): void
    {
        $meta = $this->actions->setMeta(
            'Возврат и обмен',
            'Возврат и обмен' . $this->titleTail,
            'Возврат и обмен');
        view('main.returnchange', compact('meta'));
    }
    #[NoReturn] public function actionPoliticaconf()
    {
        $meta = $this->actions->setMeta(
            'Политика конфиденциальности - Витекс',
            'Политика конфиденциальности ' . $this->titleTail,
            'Политика конфиденциальности');
        view('main.politicaconf', compact('meta'));
    }

    #[NoReturn] public function actionOferta(): void
    {
        $meta = $this->actions->setMeta(
            'Оферта',
            'Оферта' . $this->titleTail,
            'Оферта');
        view('main.oferta', compact('meta'));
    }
    #[NoReturn] public function actionSitemap(): void
    {
        $categories = "<ul class='category-tree'>" . "</ul>";
        $content    = file_get_contents(ROOT . '/sitemap.html');

        $meta = $this->actions->setMeta(
            'Карта сайта - Витекс',
            'Карта сайта ' . $this->titleTail,
            'Карта сайта');
        view('main.sitemap', compact('meta','content'));
    }

    #[NoReturn] public function actionRequisites(): void
    {
        $meta = $this->actions->setMeta(
            'Реквизиты - Витекс',
            'Реквизиты ' . $this->titleTail,
            'Реквизиты');
        view('main.requisites', compact('meta'));
    }

    #[NoReturn] public function actionDiscount(): void
    {
        $meta = $this->actions->setMeta(
            'Скидки - Витекс',
            'Скидки ' . $this->titleTail,
            'Скидки от обьема.');
        view('main.discount', compact('meta'));
    }

    #[NoReturn] public function actionDelivery(): void
    {
        $meta = $this->actions->setMeta(
            'Доставка - Витекс',
            'Доставка ' . $this->titleTail,
            'Доставка по Росссии.');
        view('main.delivery', compact('meta'));
    }

    #[NoReturn] public function actionPayment(): void
    {
        $meta = $this->actions->setMeta(
            'Оплата - Витекс',
            'Оплата ' . $this->titleTail,
            'Оплата.');
        view('main.payment', compact('meta'));
    }

    public function actionOtzyvy()
    {
        $this->assets->setMeta('Отзывы',
            'Отзывы' . $this->titleTail,
            'Отзывы');
    }

    public function actionFaq()
    {
        $this->assets->setMeta('FAQ',
            'FAQ' . $this->titleTail,
            'FAQ');
    }


}
