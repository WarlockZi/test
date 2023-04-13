<?php

namespace app\controller;

class XmlController extends AppController
{
	public $model = xml::class;


	protected $cookieName = 'inc';
	protected $cookieVal = '456456';

	protected $path = ROOT . '/pic/integration.txt';
	protected $import = __DIR__ . '/';

	public function __construct()
	{
		parent::__construct();
	}

	public function actionInc()
	{
		if (isset($this->route->params['type'])) {

			if ($this->route->params['type'] === 'catalog') {

				if ($this->route->params['mode'] === 'checkauth') {
					$this->setAuth();

				} elseif ($this->route->params['mode'] === 'init') {
					$this->setZipSize();

				} elseif ($this->route->params['mode'] === 'file') {
					$this->writeFile();

				} elseif ($this->route->params['mode'] === 'import') {
					$this->progress();
				}
			}
		}
	}

	protected function writeFile()
	{
		$filename = $this->route->params['filename'];

		$rawPost = file_get_contents('php://input');
//		copy($rawPost,__DIR__);
		$text = $this->writeResp('setZipSize');
		$text .= $filename . "<br>";
		file_put_contents($this->import . $filename, $rawPost);
		move_uploaded_file($filename, ROOT . '/pic/' . $filename);
		file_put_contents($this->path, $text, FILE_APPEND);
		exit('progress');
	}


	protected function progress()
	{
		$text = $this->writeResp('progress');
		$filename = $this->route->params['filename'];
		$text .= $filename . "<br>";
		move_uploaded_file($filename, ROOT . '/pic/' . $filename);
		file_put_contents($this->path, $text, FILE_APPEND);
		exit('success');
	}

	protected function setZipSize()
	{
		$text = $this->writeResp('setZipSize');
		file_put_contents($this->path, $text, FILE_APPEND);
		$str = "zip=no\nfile_limit=100000000";
		exit($str);
	}

	protected function setAuth()
	{
		$text = $this->writeResp('setAuth');

		file_put_contents($this->path, $text, FILE_APPEND);
		exit("success\ninc\n777777\n55fdsa55");
	}

	protected function writeResp($func)
	{
		$text = '<br>--' . date("H:i:s") . "--{$func}<br>";

		if (isset($_POST)) {
			$text .= '$_POST - ' . json_encode($_POST) . '<br>';
		}
		if (isset($_FILES)) {
			$text .= '$_FILES - ' . json_encode($_FILES) . '<br>';
		}
		if (isset($_GET)) {
			$text .= '$_GET - ' . json_encode($_GET) . '<br>';
		}
		$text .= 'headers -' . $this->getHeaders();
		return $text;
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


