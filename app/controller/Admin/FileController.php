<?php


namespace app\controller\Admin;


use app\controller\AppController;
use app\Storage\StorageImg;

class FileController extends AppController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function actionSave(){
		$req = $_POST;
		if ($req){
			$path = $req['path'];
			$storage = new StorageImg();
			$storage->save($path);
		}

	}


}