<?php

namespace app\controller;


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
            'Контактная информация',
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
//        $this->view= 'default';
//        $content = file_get_contents(ROOT.'/sitemap1.htm');
        $content = file_get_contents(ROOT.'/sitemap.html');
        $this->setVars(compact('content'));
    }
    public function actionYandexauth(): void
    {
        $f = 1;
    }

    public function actionArticles()
    {
    }

    public function actionPoliticaconf()
    {
    }

    public function actionRequisites()
    {
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
