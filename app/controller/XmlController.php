<?php

namespace app\controller;

use app\Storage\Storage;
use app\Storage\XmlStorage;

class XmlController extends AppController
{
	public $model = xml::class;

	protected $sess = 'sessid';
	protected $sessid = '7f8ec88162e001fdccabfdd202653fc6';

	protected $cookieName = 'inc';
	protected $cookieVal = '456456';

	protected $path = ROOT . '/pic/integration.txt';

	public function __construct()
	{
		parent::__construct();
	}

	public function actionInc()
	{
		if (isset($this->route->params['type'])) {

			if ($this->route->params['type'] === 'catalog'
				&& $this->route->params['mode'] === 'init') {
				$this->setZipSize();

			} elseif ($this->route->params['type'] === 'catalog'
				&& $this->route->params['mode'] === 'file') {
				$this->writeFile();

			} elseif ($this->route->params['type'] === 'catalog'
				&& $this->route->params['mode'] === 'import') {
				$this->progress();

			}
		} else {
			$this->setAuth();
		}
	}

	protected function writeFile()
	{
		$filename = $this->route->params['filename'];
		$this->base($filename, $filename);
		$text = $this->writeResp('setZipSize');
		$text .= $filename;
		move_uploaded_file($filename, ROOT . '/pic/' . $filename);
		file_put_contents($this->path, $text, FILE_APPEND);
		exit('success');
	}

	protected function base($tmp_name, $data_filename)
	{
		if (!is_uploaded_file($tmp_name)) {
			die('Ошибка при загрузке файла ');
		} else {
			$data = file_get_contents($tmp_name);
			$data = base64_decode($data);
			if (!empty($data) && ($fp = @fopen($data_filename, 'wb'))) {
				@fwrite($fp, $data);
				@fclose($fp);
			} else {
				die('Ошибка при записи файла ' . $data_filename);
			}
			@header('HTTP/1.1 200 Ok');
			@header('Content-type: text/html; charset=windows-1251');
			$answer = "\n" . 'Файл ' . $data_filename . ' успешно загружен. ' . "\n" . 'Переданное сообщение: ' . $message;
			print ($answer);
		}

	}

	protected function progress()
	{
		$text = $this->writeResp('progress');
		$filename = $this->route->params['filename'];
		$text .= $filename;
		move_uploaded_file($filename, ROOT . '/pic/' . $filename);
		file_put_contents($this->path, $text, FILE_APPEND);
		exit('success');
	}

	protected function setZipSize()
	{
		$text = $this->writeResp('setZipSize');
		$str = "zip=yes\nfile_limit=100000000";
		file_put_contents($this->path, $text, FILE_APPEND);
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
		$text = '--' . date("H:i:s") . "--{$func}<br>";

		if (isset($_POST)) {
			$text .= '$_POST - ' . json_encode($_POST) . '<br>';
		}
		if (isset($_FILES)) {
			$text .= '$_FILES - ' . json_encode($_FILES) . '<br>';
		}
		if (isset($_GET)) {
			$text .= '$_GET - ' . json_encode($_GET) . '<br>';
		}
//		if (isset($_COOKIE)) {
//			$text .= '$_COOKIE - ' . json_encode($_COOKIE) . '<br>';
//		}
		return $text;
	}

	protected function no()
	{
//		exit("f-{$ispath} - name {$path}");
		//		setcookie($this->cookieName, $this->cookieVal);
//		$date = date("D, d M Y H:i:s",strtotime('1 January 2024')) . 'GMT';
//		header("Set-Cookie: {$this->cookieName}={$this->cookieVal}; EXPIRES{$date};");
//		echo "success\ncatalog\ncheckauth";

	}

}


