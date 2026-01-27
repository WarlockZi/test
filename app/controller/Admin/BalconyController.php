<?php

namespace app\controller\Admin;


class BalconyController extends AdminscController
{
    public function __construct()
    {
        parent::__construct();
    }

	public function actionIndex(): void
    {
        $data=[
            'slider'=>'/public/src/balcony/images/slider/',
        ];
        view('admin.balcony.index',compact('data'));
	}

}
