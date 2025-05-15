<?php

namespace app\action\admin;

use app\service\Breadcrumbs\NewBread;
use Exception;


class CategoryAction
{
    public function __construct() { }

    /**
     * @throws Exception
     */
    public function getBreadcrumbs(array $category, bool $lastItemIsLink): NewBread
    {
        if (!$category) throw new Exception('Breadcrumbs service has no category');
        $bs = new NewBread($lastItemIsLink);
        return $bs->getParents($category);

    }

}