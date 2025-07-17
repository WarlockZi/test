<?php

namespace app\repository;

class MobileMenuRepository
{
    public static function items(): array
    {
        return [
            [
                'title' => 'Контакты',
                'path' => 'contacts',
            ], [
                'title' => 'Новости',
                'path' => 'news',
            ], [
                'title' => 'Акции',
                'path' => 'promotions',
            ], [
                'title' => 'О нас',
                'path' => 'about',
            ], [
                'title' => 'Блог',
                'path' => 'blog/index',

            ], [
                'title' => 'Статьи',
                'path' => 'statii',
            ], [
                'title' => 'Гарантии',
                'path' => 'garantii',
            ], [
                'title' => 'Доставка',
                'path' => 'delivery',
            ], [
                'title' => 'Скидки',
                'path' => 'discount',
            ], [
                'title' => 'Отзывы',
                'path' => 'otzyvy',
            ], [
                'title' => 'Вопросы',
                'path' => 'faq',
            ],

        ];
    }

}