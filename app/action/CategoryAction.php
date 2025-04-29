<?php

namespace app\action;

use app\repository\CategoryRepository;

class CategoryAction
{
    private CategoryRepository $repository;
    public function __construct()
    {
        $this->repository = new CategoryRepository();
    }

}