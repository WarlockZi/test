<?php

namespace app\controller;


use app\model\Category;
use app\Repository\CategoryRepository;
use app\view\Category\CategoryFormView;
use app\view\components\Builders\SelectBuilder\optionBuilders\TreeABuilder;

class BrandsController extends AppController
{

    public function __construct(
        private readonly string $titleTail = " купить в интернет-магазине VITEX в Вологде. Большой ассортимент медицинской одежды, оборудования и расходников по выгодной цене. Звоните и заказывайте прямо сейчас онлайн на сайте",
    )
    {
        parent::__construct();
    }

    public function actionBenovy()
    {
        $this->assets->setMeta(
            'Benovy - Витекс',
            'Benovy ' . $this->titleTail,
            'Benovy');

        $brand = 'Benovy';
        $this->setVars(compact('brand'));
    }
    public function actionDispodent()
    {
        $this->assets->setMeta(
            'Dispodent - Витекс',
            'Dispodent ' . $this->titleTail,
            'Dispodent');

        $brand = 'Dispodent';
        $this->setVars(compact('brand'));
    }
        
    public function actionElegreen()
    {
        $this->assets->setMeta(
            'Elegreen - Витекс',
            'Elegreen ' . $this->titleTail,
            'Elegreen');

        $brand = 'Elegreen';
        $this->setVars(compact('brand'));
    }
        
    public function actionImsstore()
    {
        $this->assets->setMeta(
            'Imsstore - Витекс',
            'Imsstore ' . $this->titleTail,
            'Imsstore');

        $brand = 'Imsstore';
        $this->setVars(compact('brand'));
    }
        
    public function actionKlever()
    {
        $this->assets->setMeta(
            'Klever - Витекс',
            'Klever ' . $this->titleTail,
            'Klevervy');

        $brand = 'Klever';
        $this->setVars(compact('brand'));
    }
        
    public function actionMatrix()
    {
        $this->assets->setMeta(
            'Matrix - Витекс',
            'Matrix ' . $this->titleTail,
            'Matrixvy');

        $brand = 'Matrix';
        $this->setVars(compact('brand'));
    }
        
    public function actionMedenta()
    {
        $this->assets->setMeta(
            'Medenta - Витекс',
            'Medenta ' . $this->titleTail,
            'Medentay');

        $brand = 'Medenta';
        $this->setVars(compact('brand'));
    }
        
    public function actionMediok()
    {
        $this->assets->setMeta(
            'Mediok - Витекс',
            'Mediok ' . $this->titleTail,
            'Mediokvy');

        $brand = 'Mediok';
        $this->setVars(compact('brand'));
    }
        
    public function actionProtecodent()
    {
        $this->assets->setMeta(
            'Protecodent - Витекс',
            'Protecodent ' . $this->titleTail,
            'Protecodent');

        $brand = 'Protecodent';
        $this->setVars(compact('brand'));
    }
        
    public function actionSitekmed()
    {
        $this->assets->setMeta(
            'Sitekmed - Витекс',
            'Sitekmed ' . $this->titleTail,
            'Sitekmed');

        $brand = 'Sitekmed';
        $this->setVars(compact('brand'));
    }
        
    public function actionUnite()
    {
        $this->assets->setMeta(
            'Unite - Витекс',
            'Unite ' . $this->titleTail,
            'Uniteovy');

        $brand = 'Unite';
        $this->setVars(compact('brand'));
    }       
}