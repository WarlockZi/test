<?php

namespace app\repository;

use app\model\Pages;
use Illuminate\Database\Eloquent\Collection;

class PagesRepository
{
    private Pages $model;

    public function __construct()
    {
        $this->model = new Pages;
    }

    public function menu(): Collection|array
    {
        return $this->model->all();

    }

}