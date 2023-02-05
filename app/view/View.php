<?php

namespace app\view;

use app\core\Error;
use Illuminate\Database\Eloquent\Model;

class View
{

	protected $defaultView = ROOT . '/app/view/default.php';
	protected $defaultLayout = 'vitex';
	public $route;
	public $layout;
	public $view;
	public $user;
	public static $meta = ['title' => '', 'desc' => '', 'keywords' => ''];
	public static $jsCss = ['js' => [], 'css' => []];

	function __construct($route, $layout = '', $view = '', $user = '')
	{
		$this->user = $user;
		$this->route = $route;
		if ($layout === false) {
			$this->layout = false;
		} else {
			$this->layout = $layout ?: ''; //LAYOUT;
		}
		$this->view = $view;
	}

	protected function validateViewFile(View $view)
	{
		$viewName = $view->view.'.php';
		$file_view = ROOT . "/app/view/{$view->route['controller']}/{$viewName}";
		if (!is_file($file_view)) {
			Error::setError("Не найден файл вида - {$viewName}");
			return $view->defaultView;
		}
		return $file_view;
	}

	protected function validateLayoutFile(View $view)
	{
		$layout = ROOT . "/app/view/layouts/{$view->layout}.php";
		if (!is_file($layout)) {
			Error::setError("Не найден layout - {$layout}");
			return $view->defaultLayout;
		}
		return $layout;
	}

	public function render(array $vars = [])
	{
		extract($vars);

		$file_view = $this->validateViewFile($this);

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

	public static function getCSS()
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

	public static function getJS()
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
}
