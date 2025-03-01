<?php

namespace app\controller\Admin;

use app\model\Like;

class LikeController extends AdminscController
{
    public string $model = Like::class;

    public function __construct()
    {
        parent::__construct();
    }
}


