<?php

namespace app\view;

use app\controller\Controller;
use app\core\Auth;
use app\core\FS;
use app\view\Interfaces\IErrors;
use app\view\Interfaces\IFooterable;
use app\view\Interfaces\IHeaderable;
use app\view\Interfaces\ILayout;
use app\view\Interfaces\IRenderable;

abstract class View implements IFooterable, IHeaderable, IRenderable, IErrors, ILayout
{

	public $controller;
	public $viewFile;
	public $errors;
	public $user;

	protected IHeaderable $header;
	protected $content;
	protected $footer;

	public static $meta = ['title' => '', 'desc' => '', 'keywords' => ''];
	public static $jsCss = ['js' => [], 'css' => []];

	function __construct(Controller $controller)
	{
		$this->controller = $controller;
		$this->user = Auth::getUser();
		$this->view = $this->getViewFile();
	}

	public function getContent()
	{
		return $this->content;
	}

	public function getFileContent(string $file, array $vars = [])
	{
		extract($vars);
		ob_start();
		require $file;
		return ob_get_clean();
	}


	public function render()
	{
		$this->setContent($this->controller,);
		echo self::getFileContent($this->layout);
	}

	public static function toFile($page_cache)
	{
		$file = ROOT . '/public/src/template.html';
		if (is_readable($file)) {
			file_put_contents($file, $page_cache);
		}
	}


}
