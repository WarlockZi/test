<?php

namespace app\view;

use Illuminate\Database\Eloquent\Model;

class View
{

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

	public function render(array $vars = [])
	{
		extract($vars);

		$file_view = ROOT . "/app/view/{$this->route['controller']}/{$this->view}.php";
		ob_start();
		if (is_file($file_view)) {
			require $file_view;
		} else {
			echo "<main class='content'><br>Не найден файл вида {$this->view}</main>";
		}
		$content = ob_get_clean();

		ob_start();
		if ($this->layout !== false) {
			$file_layout = ROOT . "/app/view/layouts/{$this->layout}.php";
			if (is_file($file_layout)) {
				require $file_layout;
			} else {
				echo '<br> Не найден шаблон Layout' . $this->layout;
			}
		}
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

	public static function setCDNJs(string $src):void
	{
		$str = "<script src='{$src}'></script>";
		self::$jsCss['js'][] = $str;
	}

	public static function setCDNCss(string $src):void
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
