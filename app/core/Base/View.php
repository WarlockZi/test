<?php

namespace app\core\Base;

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
			echo "<br>Не найден файл вида {$this->view} ";
		}
		$content = ob_get_clean();
		ob_start();
		if ($this->layout !== FALSE) {
			$file_layout = ROOT . "/app/view/layouts/{$this->layout}.php";
			if (is_file($file_layout)) {
				require $file_layout;
			} else {
				'<br> Не найден шаблон Layout' . $this->layout;
			}
		}
		$page_cache = ob_get_clean();
		echo $page_cache;
	}


	public static function setJs($data, $cache = false)
	{
		$time = (!$cache) ? "?" . time() : '';
		self::$jsCss['js'][] = "<script src='{$data['js']}{$time}'></script>";
	}
	public static function setCss($data)
	{
		$cache = true;
		$time = (!$cache) ? "?" . time() : '';
		self::$jsCss['css'][] = "<link href='{$data['css']}{$time}' type='text/css' rel='stylesheet'>";
	}

	public static function getLogo()
	{
		return require_once(ROOT . '/app/view/components/Logo.php');
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
// если передали route. значит хотим подключить индивид.
// скрипт, если не передали, то тот который передали
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
