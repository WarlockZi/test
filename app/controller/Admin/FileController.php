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

	public function actionSave()
	{
		if (!$_POST) $this->exitWithPopup('Ошибка - не установлена папка');
		if (!$_FILES) $this->exitWithPopup('Ошибка - не передан файл');

		$storage = new StorageImg();
		$srcs = $storage->save($_POST['path'], $_FILES);
		$this->exitJson(['srcs'=>$srcs]);
	}
}