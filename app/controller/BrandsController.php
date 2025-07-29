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
            'Dispodent',
            'Dispodent');

        $brand = 'Dispodent';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionElegreen()
    {
        $meta = $this->actions->setMeta(
            'Elegreen - Витекс',
            'Elegreen',
            'Elegreen');

        $brand = 'Elegreen';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionImsstore()
    {
        $meta = $this->actions->setMeta(
            'Imsstore - Витекс',
            'Imsstore',
            'Imsstore');

        $brand = 'Imsstore';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionKlever()
    {
        $meta = $this->actions->setMeta(
            'Klever - Витекс',
            'Klever',
            'Klevervy');

        $brand = 'Klever';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionMatrix()
    {
        $meta = $this->actions->setMeta(
            'Matrix - Витекс',
            'Matrix',
            'Matrixvy');

        $brand = 'Matrix';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionMedenta()
    {
        $meta = $this->actions->setMeta(
            'Medenta - Витекс',
            'Medenta',
            'Medentay');

        $brand = 'Medenta';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionMediok()
    {
        $meta = $this->actions->setMeta(
            'Mediok - Витекс',
            'Mediok',
            'Mediokvy');

        $brand = 'Mediok';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionProtecodent()
    {
        $meta = $this->actions->setMeta(
            'Protecodent - Витекс',
            'Protecodent',
            'Protecodent');

        $brand = 'Protecodent';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionSitekmed()
    {
        $meta = $this->actions->setMeta(
            'Sitekmed - Витекс',
            'Sitekmed',
            'Sitekmed');

        $brand = 'Sitekmed';
        view('brand.brand',compact('meta','brand'));
    }
        
    public function actionUnite()
    {
        $meta = $this->actions->setMeta(
            'Unite - Витекс',
            'Unite',
            'Uniteovy');

        $brand = 'Unite';
        view('brand.brand',compact('meta','brand'));
    }       
}