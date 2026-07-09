<?php

namespace app\controller\Admin;

use app\action\admin\CategoryAction;
use app\model\Category;
use app\repository\CategoryRepository;
use app\service\Breadcrumbs\NewBreadArray;
use app\service\Router\IRequest;
use app\view\Category\CategoryFormView;
use JetBrains\PhpStorm\NoReturn;
use Throwable;

class CategoryController extends AdminscController
{
    public function __construct(
        private readonly CategoryAction $actions,
        public string                   $model = Category::class,
    )
    {
        parent::__construct();
    }

    #[NoReturn]
    public function actionIndex(): void
    {
        $categoryTree = CategoryFormView::list();
        view('admin.category.index', ['categoryTree' => $categoryTree]);
    }

    #[NoReturn]
    public function actionEdit(IRequest $route): void
    {
        $category    = CategoryRepository::edit($route->id);
        if (!$category) {
            view('category.notFound');
        }
        $catItem     = CategoryFormView::edit($category);
        $category = $category->toArray();
        $breadcrumbs = (new NewBreadArray(true))->getParents($category);
        view('admin.category.edit',
            compact(
                'breadcrumbs',
                'catItem'
            ));
    }


//    public function actionUpdateOrCreate(IRequest $request): void
//    {
//        try {
//            if ($request->body()['relation']['name'] === 'properties') {
////                $this->actions->changeProperty();
//                $this->actions->changeProperty($request);
//            }
//            response()->popup('Свойство категории обновлено');
//        } catch (Throwable $exception) {
//            $exc = $exception;
//        }
//    }
}