<?php

namespace app\controller;

use app\model\Category;
use app\model\Product;

class ShortController extends AppController
{
    protected string $model;

    public function actionIndex(): void
    {
        $shortLink = $this->route->slug;
        if (!$shortLink) header("Location:/catalog");

        $slug = Product::withWhereHas('ownProperties',
            fn($query) => $query->where('short_link', 'like', $shortLink)
        )->first()->slug;

        if ($slug) {
            header("Location:/product/{$slug}");
        } else {   //if product not found, looking for category
            $path = Category::withWhereHas('ownProperties',
                fn($query) => $query->where('short_link', 'like', $shortLink)
            )->first()->ownProperties->path;
            header("Location:/catalog/{$path}");
        }

    }
}

