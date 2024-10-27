<?php

namespace app\controller;


class MainController extends AppController
{
    public function __construct(
        private readonly string $titleTail = " - интернет-магазин медицинских перчаток и расходников в Вологде - VITEX",
    )
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
//        echo $_SESSION['yandex_id'];
        $this->assets->setMeta('Нитриловые перчатки оптом',
            'Доставим нитриловые перчатки, бахилы, маски по России. Оптом.',
            'нитриловые перчатки, бахилы, маски, расходные материалы, доставка, производство, по России');
    }

    public function actionContacts()
    {
        $this->assets->setMeta(
            'Контактная информация' . $this->titleTail,
            'Контакты',
            'Контакты');
    }

    public function actionOferta()
    {
        $this->assets->setMeta('Оферта' . $this->titleTail,
            'Оферта',
            'Оферта');
    }

    public function actionAbout()
    {
        $this->assets->setMeta('О нас' . $this->titleTail,
            'О нас',
            'О нас');
    }

    public function actionReturnChange()
    {
        $this->assets->setMeta('Возврат и обмен' . $this->titleTail,
            'Возврат и обмен',
            'Возврат и обмен');
    }

    public function actionNews()
    {
        $content = 'Следите за новостями)';
        $this->setVars(compact('content'));
        $this->assets->setMeta('Новости' . $this->titleTail,
            'Новости',
            'Новости');
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
