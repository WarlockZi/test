<?php

namespace app\controller;


use app\model\Category;
use app\Repository\CategoryRepository;
use app\view\Category\CategoryFormView;
use app\view\components\Builders\SelectBuilder\optionBuilders\TreeABuilder;

class BlogController extends AppController
{
    public function __construct(
        private readonly string $titleTail = " купить в интернет-магазине VITEX в Вологде. Большой ассортимент медицинской одежды, оборудования и расходников по выгодной цене. Звоните и заказывайте прямо сейчас онлайн на сайте",
    )
    {
        parent::__construct();
    }

    public function actionBlog1(): void
    {   
        $this->assets->setMeta(
            'Как выбрать качественные медицинские перчатки для различных сфер деятельности?',
            'Узнайте, как выбрать идеальные медицинские перчатки для различных отраслей, включая медицину, лаборатории, пищевую промышленность и клининг. Рассмотрим преимущества латексных, нитриловых и виниловых перчаток, их особенности и лучшие сферы применения для каждого типа.',
            'Как выбрать качественные медицинские перчатки для различных сфер деятельности?');
        
    }

}
