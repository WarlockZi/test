<?php

namespace app\Repository;

use app\model\Pages;

class PagesRepository
{
    private Pages $model;
    public function __construct()
    {
        $this->model=new Pages;
    }

    public function menu(): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->all();

    }

}