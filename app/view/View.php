<?php

namespace app\view;

use http\Env;

class View
{

	public $route;
	public $layout;
	public $view;
	public static $meta = ['title' => '', 'desc' => '', 'keywords' => ''];
	public static $jsCss = ['js' => [], 'css' => []];

	function __construct($route, $layout = '', $view = '')
	{
		$this->route = $route;
		if ($layout === false) {
			$this->layout = false;
		} else {

			$this->layout = $layout ?: ''; //LAYOUT;
		}
		$this->view = $view;
	}

	public function render($vars)
	{
		if (is_array($vars)) {
			extract($vars);
		}
		$file_view = ROOT . "/app/view/{$this->route['controller']}/{$this->view}.php";
		ob_start();
		if (is_file($file_view)) {
			require $file_view;
		} else {
			echo "<div class='content'><br>Не найден файл вида {$this->view}</div>";
		}
		$content = ob_get_clean();
		ob_start();
		if ($this->layout !== FALSE) {
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

	public static function setJs($file)
	{
		$cache = true;
		$host = $_ENV['MODE']==='development'
			?'http://localhost:4000/'
			:'/public/dist/';
//		$hostHot = 'http://localhost:4000/';
//		$hostStatic = '/public/dist/';
		$time = ($cache) ? '' : "?" . time();
		$str = "<script src='{$host}{$file}{$time}'></script>";
		self::$jsCss['js'][] = $str;
	}

	public static function setCss($file)
	{
//		$hostHot = '/public/dist/';
		$hostHot = 'http://localhost:4000/';
		$hostStatic = '/public/dist/';
		$cache = true;

		$host = $_ENV['MODE']==='development'
			?$hostHot
			:$hostStatic;

		$time = ($cache) ? '' : "?" . time();
		self::$jsCss['css'][] = "<link href='{$host}{$file}{$time}' rel='stylesheet' type='text/css'>";
	}

	public static function getSearch()
	{

		return include(ROOT . '/app/view/components/header/logo_squared.php');

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

	public static function setMeta($title = '', $description = '', $keywords = '')
	{
		self::$meta['title'] = $title;
		self::$meta['desc'] = $description;
		self::$meta['keywords'] = $keywords;
	}

	public static function e($str)
	{
		return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
	}

}
