<?php

namespace app\controller;

use app\action\CategoryAction;
use app\repository\CategoryRepository;
use app\repository\OrderRepository;
use app\service\Router\IRequest;
use JetBrains\PhpStorm\NoReturn;

class CategoryController extends AppController
{
    public function __construct(
        protected CategoryRepository    $repo,
        private readonly CategoryAction $actions,
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(IRequest $request): void
    {
        if ($request->slug) {

            $category = $this->repo->indexInstore($request->slug);

            if (!$category) {
                $similarCategories = $this->actions->similarCategories($request->slug);
                $meta              =
                    ['title' => 'Категория не найдена',
                        'keywords'=>'',
                        'description' => 'К сожалению, такой категории не найдено. Возможно, она была перемещена или удалена. Воспользуйтесь поиском или перейдите на главную, чтобы найти нужный товар. | VITEX.ru'];
               view('category.notFound',
                    compact('category', 'similarCategories', 'meta'),
                    404);
            }

            $order = OrderRepository::usersOrder()?->toArray() ?: [];

            $category = $category?->toArray() ?: [];
            view('category.category',
                compact(
                    'category',
                    'order',
                )
            );

        } else {
            $categories = APP->get('rootCategories');
            $meta       = $this->actions->setCategoriesMeta();
            view('category.categories', compact('meta', 'categories'));
        }
    }
//    #[NoReturn] public function actionShort(IRequest $request): void
//    {
//        if ($request->slug) {
//            $category = $this->repo->indexInstore($request->slug);
//
//            if (!$category) {
//                $similarCategories = $this->actions.js->similarCategories($request->slug);
//                view('category.notFound',
//                    compact('category', 'similarCategories'),
//                    404);
//            }
////            $order          = OrderRepository::usersOrder()->toArray();
//            $category = $category->toArray();
//
//            view('category.category',
//                compact(
//                    'category',
//                    'order',
//                )
//            );
//        } else {
//            $categories = APP->get('rootCategories');
//            $meta = $this->actions.js->setCategoriesMeta();
//            view('category.categories', compact('meta', 'categories'));
//        }
//    }
}
