<?php


namespace app\view\Assets;


use Illuminate\Database\Eloquent\Model;

class Assets
{
	protected $host;
	protected $cache;

	protected $js = [];
	protected $css = [];
	protected $CDNjs = [];
	protected $CDNcss = [];

	protected $title;
	protected $desc;
	protected $keywords;

	public function __construct()
	{
		$this->setCache(false);
		$this->setHost();
	}

	public function getMeta()
	{
		return "<title>{$this->title}</title>" .
			"<meta name = 'description' content = '{$this->desc}'>" .
			"<meta name = 'keywords' content = '{$this->keywords}'>";
	}

	public function setItemMeta(Model $item)
	{
		$this->title = $item->title ?? $item->name;
		$this->desc = $item->description ? $item->description : $item->name;
		$this->keywords = $item->keywords ? $item->keywords : $item->name;
	}

	public function setMeta(string $title, string $desc, string $keywords)
	{
		$this->title = $title ? $title : 'Медицинкские перчатки';
		$this->desc = $desc ? $desc : 'Медицинкские перчатки';
		$this->keywords = $keywords ? $keywords : 'Медицинкские перчатки';
	}


	public function setJs(string $name)
	{
		$this->js[] = $name;
	}

	public function getJS(): string
	{
		$time = ($this->cache) ? "?" . time() : '';
		$str = '';
		foreach ($this->js as $name) {
			$str .= "<script src='{$this->host}{$name}{$time}.js'></script>";
		}
		return $str;
	}

	public function setCss(string $name)
	{
		$this->css[] = $name;
	}

	public function getCss()
	{
		$time = ($this->cache) ? "?" . time() : '';
		$str = '';
		foreach ($this->js as $name) {
			$str .= "<link href='{$this->host}{$name}{$time}.css' rel='stylesheet' type='text/css'>";
		}
		return $str;
	}

	public function setCDNJs(string $src): void
	{
		$this->CDNjs[] = "<script src='{$src}'></script>";
	}

	public function getCDNJs(): string
	{
		$str = '';
		foreach ($this->CDNjs as $CDNjs) {
			$str .= $CDNjs;
		}
		return $str;
	}

	public function setCDNCss(string $src): void
	{
		$this->CDNcss[] = "<link href='{$src}' rel='stylesheet' type='text/css'>";
	}

	public function getCDNCss(): string
	{
		$str = '';
		foreach ($this->CDNcss as $CDNcss) {
			$str .= $CDNcss;
		}
		return $str;
	}

	public function unsetJs(string $name)
	{
		unset($this->js[$name]);
	}

	public function unsetCss($name)
	{
		unset($this->css[$name]);
	}


	public function setHost()
	{
		$this->host = $_ENV['MODE'] === 'development'
			? 'http://localhost:4000/'
			: '/public/dist/';;
	}

	public function getHost()
	{
		return $this->host;
	}

	public function setCache(bool $cache = true): void
	{
		echo $_ENV['MODE'];
		echo $this->cache;
		if ($_ENV['MODE'] === 'development') {
			$this->cache = $cache;
		}else{
			$this->cache = true;
		}
	}

	public function getCache(): bool
	{
		return $this->cache;
	}

}