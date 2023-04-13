<?php

namespace app\controller;

use app\Storage\XmlStorage;

class XmlController extends AppController
{
	public $model = xml::class;


	protected $cookieName = 'inc';
	protected $cookieVal = '456456';

	protected $path = ROOT . '/pic/integration.txt';
	protected $importPath;

	public function __construct()
	{
		parent::__construct();
		$this->importPath = __DIR__.'/';
//		$this->importPath = XmlStorage::get1cPath();
	}

	public function actionInc()
	{
		if (isset($this->route->params['type'])) {

			if ($this->route->params['type'] === 'catalog') {

				if ($this->route->params['mode'] === 'checkauth') {
					$this->checkauth();

				} elseif ($this->route->params['mode'] === 'init') {
					$this->init();

				} elseif ($this->route->params['mode'] === 'file') {
					$this->file();

				} elseif ($this->route->params['mode'] === 'import') {
					$this->import();
				}
			}
		}
	}

	protected function checkauth()
	{
		$this->logReqest('checkauth');
		exit("success\ninc\n777777\n55fdsa55");
	}

	protected function init()
	{
		$this->logReqest('init');
		exit("zip=no\nfile_limit=10000000");
	}

	protected function file()
	{
		$filename = $this->route->params['filename'];
		$rawPost = file_get_contents('php://input');
		file_put_contents($this->importPath . $filename, $rawPost);

		$this->logReqest('file');
		exit('success');
	}

	protected function import()
	{
		exit('success');
	}

	protected function logReqest($func)
	{
		$text = '<br>--' . date("H:i:s") . "--{$func}<br>";
		if (isset($_GET)) {
			$text .= '$_GET - ' . json_encode($_GET) . '<br>';
		}
		if (isset($this->route->params['filename'])) {
			$text .= 'filename - ' . $filename = $this->route->params['filename'] . '<br>';
		}
//		if (isset($_POST)) {
//			$text .= '$_POST - ' . json_encode($_POST) . '<br>';
//		}
//		if (isset($_FILES)) {
//			$text .= '$_FILES - ' . json_encode($_FILES) . '<br>';
//		}
//		$text .= 'headers -' . $this->getHeaders();
		file_put_contents($this->path, $text, FILE_APPEND);
	}


	protected function getHeaders($str = '')
	{
		$headers = apache_request_headers();
		foreach ($headers as $header => $value) {
			$str .= "$header: $value <br />\n";
		}
		return $str;
	}


}


