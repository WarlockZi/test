<?php

namespace app\controller;

use app\model\Promotion;
use app\repository\PromotionRepository;
use app\service\Meta\MetaService;
use JetBrains\PhpStorm\NoReturn;

class PromotionController extends AppController
{

    public function __construct(
        private readonly MetaService $meta,
        public string                $model = Promotion::class,
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(): void
    {
        $this->meta->setMeta("Акции", "Акции", "Акции");

        $promotions = PromotionRepository::product();
        view('promotion.promotions', ['data' => $promotions]);
    }
}
