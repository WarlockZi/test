<?php

namespace app\controller;

use app\model\Product;

class ShortController extends AppController
{
    protected $model;

    public function actionIndex():void
    {
        $shortLink = $this->route->slug;
        if ($shortLink) {
            $slug = Product::with(['ownProperties'=> function ($query) use ($shortLink) {
                $query->where('short_link', $shortLink);
            }])->with('ownProperties')
                ->first()
                ->slug
            ;

            header("Location:/product/{$slug}");
        } else {
            $this->route->setError('Короткая ссылка не найдена');
        }
    }
}

