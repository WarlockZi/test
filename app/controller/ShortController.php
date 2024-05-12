<?php

namespace app\controller;

use app\model\Product;

class ShortController extends AppController
{
    protected $model;

    public function actionIndex()
    {
        $shortLink = $this->route->slug;
        if ($shortLink) {
            $slug = Product::where(['short_link' => $shortLink])->select('slug')->first()->slug;
            header("Location:/product/{$slug}");
        } else {
            $this->route->setError('Короткая ссылка не найдена');
        }
    }
}
//bahily_p_e_gladkie_osobo_prochnye__up_50_par_kor_1500_par_vu
//bahily_p_e_gladkie_osobo_prochnye__up_50par_kor_1500par__vu
