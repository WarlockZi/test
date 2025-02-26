<?php

namespace app\controller;


use app\model\Category;
use app\Repository\CategoryRepository;
use app\view\Category\CategoryFormView;
use app\view\components\Builders\SelectBuilder\optionBuilders\TreeABuilder;

class MainController extends AppController
{
    public function __construct(
        private readonly string $titleTail = " купить в интернет-магазине VITEX в Вологде. Большой ассортимент медицинской одежды, оборудования и расходников по выгодной цене. Звоните и заказывайте прямо сейчас онлайн на сайте",
    )
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
        $this->assets->setMeta('Нитриловые перчатки оптом',
            'Доставим нитриловые перчатки, бахилы, маски по России. Оптом.',
            'нитриловые перчатки, бахилы, маски, расходные материалы, доставка, производство, по России');
    }

    public function actionContacts()
    {
        $this->assets->setMeta(
            'Контакты - Витекс',
            'Контакты' . $this->titleTail,
            'Контакты');
    }

    public function actionOferta()
    {
        $this->assets->setMeta('Оферта',
            'Оферта' . $this->titleTail,
            'Оферта');
    }

    public function actionAbout()
    {
        $this->assets->setMeta('О нас',
            'О нас' . $this->titleTail,
            'О нас');
    }

    public function actionReturnChange()
    {
        $this->assets->setMeta('Возврат и обмен',
            'Возврат и обмен' . $this->titleTail,
            'Возврат и обмен');
    }

    public function actionNews()
    {
        $content = 'Следите за новостями)';
        $this->setVars(compact('content'));
        $this->assets->setMeta('Новости',
            'Новости' . $this->titleTail,
            'Новости');
    }
    public function actionSitemap(): void
    {
//        $tree = CategoryFormView::sitemap();
        $categories = "<ul class='category-tree'>" .  "</ul>";
        $content = file_get_contents(ROOT.'/sitemap.html');
        $this->setVars(compact('content', 'categories'));
        $this->assets->setMeta(
            'Карта сайта - Витекс',
            'Карта сайта ' . $this->titleTail,
            'Карта сайта');
    }
    public function actionYandexauth(): void
    {
        $f = 1;
    }

    public function actionStatii()
    {
        $this->assets->setMeta(
            'Статьи - Витекс',
            'Статьи ' . $this->titleTail,
            'Статьи');
    }
    public function actionGarantii()
    {
        $this->assets->setMeta(
            'Гарантии - Витекс',
            'Гарантии ' . $this->titleTail,
            'Гарантии');
    }
    public function actionPoliticaconf()
    {
        $this->assets->setMeta(
            'Политика конфиденциальности - Витекс',
            'Политика конфиденциальности ' . $this->titleTail,
            'Политика конфиденциальности');
    }

    public function actionRequisites()
    {
        $this->assets->setMeta(
            'Реквизиты - Витекс',
            'Реквизиты ' . $this->titleTail,
            'Реквизиты');
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
