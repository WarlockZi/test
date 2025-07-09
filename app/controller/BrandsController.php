<?php

namespace app\controller;


use app\action\BrandAction;

class BrandsController extends AppController
{
    public function __construct(
        private readonly BrandAction $actions,

    )
    {
        parent::__construct();
    }

    public function actionBenovy()
    {
        $brand = 'Benovy';
        $meta = $this->actions->setMeta('Benovy');

        view('brand.brand',compact('meta','brand'));
    }
    public function actionDispodent()
    {
        $meta = $this->actions->setMeta(
            'Dispodent - Витекс',
            'Dispodent ' . $this->titleTail,
            'Dispodent');

        $brand = 'Dispodent';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionElegreen()
    {
        $meta = $this->actions->setMeta(
            'Elegreen - Витекс',
            'Elegreen ' . $this->titleTail,
            'Elegreen');

        $brand = 'Elegreen';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionImsstore()
    {
        $meta = $this->actions->setMeta(
            'Imsstore - Витекс',
            'Imsstore ' . $this->titleTail,
            'Imsstore');

        $brand = 'Imsstore';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionKlever()
    {
        $meta = $this->actions->setMeta(
            'Klever - Витекс',
            'Klever ' . $this->titleTail,
            'Klevervy');

        $brand = 'Klever';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionMatrix()
    {
        $meta = $this->actions->setMeta(
            'Matrix - Витекс',
            'Matrix ' . $this->titleTail,
            'Matrixvy');

        $brand = 'Matrix';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionMedenta()
    {
        $meta = $this->actions->setMeta(
            'Medenta - Витекс',
            'Medenta ' . $this->titleTail,
            'Medentay');

        $brand = 'Medenta';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionMediok()
    {
        $meta = $this->actions->setMeta(
            'Mediok - Витекс',
            'Mediok ' . $this->titleTail,
            'Mediokvy');

        $brand = 'Mediok';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionProtecodent()
    {
        $meta = $this->actions->setMeta(
            'Protecodent - Витекс',
            'Protecodent ' . $this->titleTail,
            'Protecodent');

        $brand = 'Protecodent';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionSitekmed()
    {
        $meta = $this->actions->setMeta(
            'Sitekmed - Витекс',
            'Sitekmed ' . $this->titleTail,
            'Sitekmed');

        $brand = 'Sitekmed';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionUnite()
    {
        $meta = $this->actions->setMeta(
            'Unite - Витекс',
            'Unite ' . $this->titleTail,
            'Uniteovy');

        $brand = 'Unite';
        view('brand.brand',compact('meta','brand'));
    }       
}