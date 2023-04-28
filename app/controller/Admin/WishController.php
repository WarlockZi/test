<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\Storage\StorageTxt;
use Workerman\Protocols\Http;

class WishController Extends AppController
{
	public $model = Http::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
		$content = StorageTxt::getFileContent('wish');
		$this->set(compact('content'));
	}
	public function actionSave()
	{
		if (isset($_POST['content'])){
			$content = $_POST['content'];
			StorageTxt::putFileContent('wish',$content);
//			$this->exitWithPopup('Сохранено');
			header('Location:/adminsc/wish');
		}
	}
}
