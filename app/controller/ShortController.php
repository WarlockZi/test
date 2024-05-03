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
