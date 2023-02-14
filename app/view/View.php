<?php

namespace app\view;

use app\controller\FS;
use app\core\Error;
use app\core\Session;
use app\view\Header\Header;
use app\view\Interfaces\IErrors;
use app\view\Interfaces\IFooterable;
use app\view\Interfaces\IHeaderable;
use app\view\Interfaces\IRenderable;
use Illuminate\Database\Eloquent\Model;

abstract class View implements IFooterable, IHeaderable, IRenderable, IErrors
{

	public $route;
	public $errors;
	public $user;
	protected $defaultView = ROOT . '/app/view/default.php';
	protected $defaultLayout = 'vitex';
	public $layout;
	public $view;
	public static $meta = ['title' => '', 'desc' => '', 'keywords' => ''];
	public static $jsCss = ['js' => [], 'css' => []];

	protected $contentFile;


	function __construct($route, $layout = '', $view = 'index.php', $user = '')
	{
		$this->route = $route;
		$this->view = $view;
	}

	protected function setView()
	{
		if (Session::getUser()) {
			Header::getAdminHeader();
		} else {
			Header::getUserHeader();
		}
	}

	public function getContentFile()
	{
		return $this->contentFile;
	}

	public function setContentFile(array $route): void
	{
		if (!isset($route['action'])) $this->contentFile = $this->defaultView;
		if (!isset($route['controller'])) $this->contentFile = $this->defaultView;
		$path = '';
		if (isset($route['admin']))$path = 'Admin/';
		$file = ROOT . "/app/view/{$route['controller']}/{$path}{$route['action']}.php";
		if (is_readable($file)) {
			$this->contentFile = $file;
		}else{
			Error::setError("Нет файла вида - {$path}{$route['action']}.php");
			$this->contentFile = $this->defaultView;
		}
	}

//	protected function validateViewFile(View $view)
//	{
//
//		$v = $view->view ? $view->view : $view->route['action'];
//		$viewName = $v . '.php';
//		$file_view = ROOT . "/app/view/{$view->route['controller']}/{$viewName}";
//		if (!is_file($file_view)) {
//			Error::setError("Не найден файл вида - {$viewName}");
//			return $view->defaultView;
//		}
//		return $file_view;
//	}

	protected function validateLayoutFile(View $view)
	{
		$layout = $view->layout
			? $view->layout
			: $view->defaultLayout;
		$file = $layout . '.php';

		$layout = FS::getAbsoluteFilePath(ROOT . "/app/view/layouts/", $file);
		if (!is_file($layout)) {
			Error::setError("Не найден layout - {$layout}");
			return ROOT . "/app/view/layouts/{$view->defaultLayout}.php";
		}
		return $layout;
	}

	public function render(array $vars = [])
	{
		extract($vars);

		$this->setContentFile($this->route);
		$file_view = $this->getContentFile();
//		$file_view = $this->validateViewFile($this);

		ob_start();
		require $file_view;
		$content = ob_get_clean();

		$layout = $this->validateLayoutFile($this);
		ob_start();
		require $layout;
		$page_cache = ob_get_clean();
//		self::toFile($page_cache);
		echo $page_cache;
	}

	public static function toFile($page_cache)
	{
		$file = ROOT . '/public/src/template.html';
		if (is_readable($file)) {
			file_put_contents($file, $page_cache);
		}
	}

	public static function unsetJs($name = '')
	{
		if ($name) {
			$js = self::getJsStr($name);
			$k = array_search($js, self::$jsCss['js']);
			if ($k !== false) {
				unset(self::$jsCss['js'][$k]);
			}
		}
	}

	public static function unsetCss($name = '')
	{
		if ($name) {
			$css = self::getCssStr($name);
			$k = array_search($css, self::$jsCss['css']);
			if ($k !== false) {
				unset(self::$jsCss['css'][$k]);
			}
		}
	}

	public static function getHost()
	{
		return $_ENV['MODE'] === 'development'
			? 'http://localhost:4000/'
			: '/public/dist/';
	}

	public static function getCssStr($name)
	{
		$host = self::getHost();
		return
			"<link href='{$host}{$name}' rel='stylesheet' type='text/css'>";
	}

	public static function getJsStr($name)
	{
		$host = self::getHost();
		return "<script src='{$host}{$name}'></script>";
	}

	public static function setJs($file)
	{
		$cache = true;
		$host = self::getHost();

		$time = ($cache) ? '' : "?" . time();
		$str = "<script src='{$host}{$file}{$time}'></script>";
		self::$jsCss['js'][] = $str;
	}

	public static function setCDNJs(string $src): void
	{
		$str = "<script src='{$src}'></script>";
		self::$jsCss['js'][] = $str;
	}

	public static function setCDNCss(string $src): void
	{
		self::$jsCss['css'][] = "<link href='{$src}' rel='stylesheet' type='text/css'>";
	}

	public static function setCss($file)
	{
		$cache = true;
		$host = self::getHost();

		$time = ($cache) ? '' : "?" . time();
		self::$jsCss['css'][] = "<link href='{$host}{$file}{$time}' rel='stylesheet' type='text/css'>";
	}

	public function getCSS()
	{
		$css = '';
		$arr = self::$jsCss['css'];
		if (is_array($arr)) {
			foreach ($arr as $v) {
				$css .= $v;
			}
		}
		echo $css;
	}

	public function getJS()
	{
		$js = '';
		if (is_array(self::$jsCss['js'])) {
			foreach (self::$jsCss['js'] as $v) {
				$js .= $v;
			}
		}
		echo $js;
	}

	public static function getMeta()
	{
		echo '<title>' . self::$meta['title'] . '</title>
               <meta name = "description" content = "' . self::$meta['desc'] . '">
               <meta name = "keywords" content = "' . self::$meta['keywords'] . '">';
	}

	public static function setItemMeta(Model $item)
	{
		self::$meta['title'] = $item->title ?? $item->name;
		self::$meta['desc'] = $item->description ? $item->description : $item->name;
		self::$meta['keywords'] = $item->keywords ? $item->keywords : $item->name;
	}

	public static function setMeta(string $title, string $desc, string $keywords)
	{
		self::$meta['title'] = $title ? $title : 'Медицинкские перчатки';
		self::$meta['desc'] = $desc ? $desc : 'Медицинкские перчатки';
		self::$meta['keywords'] = $keywords ? $keywords : 'Медицинкские перчатки';
	}




//	public static function setAssets($route)
//	{
//		if (isset($route['admin'])) {
//			$user = Session::getUser();
//			if (!$user || !User::can($user)) {
//				self::setMainAssets();
//				Header::setUserHeader();
//				Footer::setUserFooter();
//			} else {
//				self::setAdminAssets();
//				Header::setAdninHeader();
//				Footer::setAdminFooter();
//			}
//		}
//	}


	function setHeader()
	{
	}

//	public function getErrors()
//	{
//	}

	function setFooter()
	{
	}
}
