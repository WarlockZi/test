<?php

namespace app\controller;


class MainController extends AppController
{

    public function __construct(
        private string $titleTail = " - интернет-магазин медицинских перчаток и расходников в Вологде - VITEX",
    )
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
//        Helpers::copyUnits();
//        Helpers::makeUnitsShippable();
        $this->assets->setMeta('Нитриловые перчатки оптом',
            'Доставим нитриловые перчатки, бахилы, маски по России. Оптом.',
            'нитриловые перчатки, бахилы, маски, расходные материалы, доставка, производство, по России');
    }


    public function actionPoliticaconf()
    {
    }

    public function actionRequisites()
    {
//		$this->view = '';
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

    public function actionContacts()
    {
        $this->assets->setMeta(
            'Контактная информация'.$this->titleTail,
            'Контакты',
            'Контакты');
    }

    public function actionOferta()
    {
        $this->assets->setMeta('Оферта'.$this->titleTail,
            'Оферта',
            'Оферта');
    }

    public function actionAbout()
    {
        $this->assets->setMeta('О нас'.$this->titleTail,
            'О нас',
            'О нас');
    }

    public function actionReturnChange()
    {
        $this->assets->setMeta('Возврат и обмен'.$this->titleTail,
            'Возврат и обмен',
            'Возврат и обмен');
//		$this->setView();
    }

    public function actionArticles()
    {
    }

    public function actionNews()
    {
        $content = 'Следите за новостями)';
        $this->setVars(compact('content'));
        $this->assets->setMeta('Новости'.$this->titleTail,
            'Новости',
            'Новости');
    }

}
