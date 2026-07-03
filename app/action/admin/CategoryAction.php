<?php

namespace app\action\admin;

use app\model\Category;
use app\repository\PropertyRepository;
use app\service\Breadcrumbs\NewBread;
use app\service\Router\IRequest;
use JetBrains\PhpStorm\NoReturn;


class CategoryAction
{
    public function __construct(
        private NewBread $breadcrumbs,
    )
    {
    }

    public function getBreadcrumbs(Category $category, bool $lastItemIsLink): array
    {
        return $this->breadcrumbs->getParents($category, $lastItemIsLink);
    }

    #[NoReturn]
    public function changeProperty(IRequest $req): void
    {
        $req = $req->body();
        $property = PropertyRepository::updateOrcreate($req);
        $cat      = Category::find($req['id']);
        $cat->properties()->syncWithoutDetaching($property);
    }

}