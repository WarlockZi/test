<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\Storage\StorageProd;
use Workerman\Protocols\Http;

class WishController Extends AppController
{
	public $model = Http::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex():void
	{
		$content = StorageProd::getFileContent('wish');
		$this->set(compact('content'));
	}
	public function actionSave()
	{
		if (isset($_POST['content'])){
			$content = $_POST['content'];
			StorageProd::putFileContent('wish',$content);
			header('Location:/adminsc/wish');
		}
	}
}
