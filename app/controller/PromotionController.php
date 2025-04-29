<?php

namespace app\controller;

use app\model\Promotion;
use app\repository\PromotionRepository;

class PromotionController extends AppController
{
    public string $model = Promotion::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
        $promotions = PromotionRepository::product();

        $this->setVars(compact('promotions'));
        $this->assets->setMeta("Акции", "Акции", "Акции");
    }

}
