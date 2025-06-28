<?php

namespace app\action\admin;

use app\model\Category;
use app\service\Breadcrumbs\NewBread;
use app\service\Router\IRequest;
use Exception;


class CategoryAction
{
    public function __construct(
        private NewBread $breadcrumbs,
    ) { }

    /**
     * @throws Exception
     */
    public function getBreadcrumbs(Category $category, bool $lastItemIsLink): NewBread
    {
        if (!$category) throw new Exception('Breadcrumbs service has no category');
        return $this->breadcrumbs->getParents($category, $lastItemIsLink);
    }

    public function changeProperty(IRequest $req): void
    {
        $category = Category::find($req['category_id']);
        $newVal   = $req['morphed']['new_id'];
        $oldVal   = $req['morphed']['old_id'];

        if (!$oldVal) {
            $category->properties()->attach($newVal);
            exit(json_encode(['popup' => 'Добавлен']));

        } else if (!$newVal) {
            $category->properties()->detach($oldVal);
            exit(json_encode(['ok' => 'ok', 'popup' => 'Удален']));

        } else {
            if ($newVal === $oldVal) exit(json_encode(['popup' => 'Одинаковые значения']));
            $category->properties()->detach($oldVal);
            $category->properties()->attach($newVal);
            exit(json_encode(['popup' => 'Поменян']));
        }
    }

}