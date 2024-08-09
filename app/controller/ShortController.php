<?php

namespace app\controller;

use app\model\Product;

class ShortController extends AppController
{
    protected $model;

    public function actionIndex(): void
    {
        $shortLink = $this->route->slug;
        if ($shortLink) {
            $slug = Product::withWhereHas('ownProperties', fn($query) =>
            $query->where('short_link', 'like', $shortLink)
            )->first()
            ->slug;

            header("Location:/product/{$slug}");
        } else {
            $this->route->setError('Короткая ссылка не найдена');
        }
    }
}

