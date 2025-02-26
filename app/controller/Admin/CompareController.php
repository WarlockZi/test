<?php

namespace app\controller\Admin;

use app\model\Compare;

class CompareController extends AdminscController
{
    public string $model = Compare::class;

    public function __construct()
    {
        parent::__construct();
    }
}


