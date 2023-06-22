<?php


namespace app\view\Assets;


use Illuminate\Database\Eloquent\Model;

class Assets
{
	protected $host;
	protected $cache = false;

	protected $js = [];
	protected $css = [];
	protected $CDNjs = [];
	protected $CDNcss = [];

	protected $title;
	protected $desc;
	protected $keywords;

	public function __construct()
	{
		$this->setCache();
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
		$this->title = $item->seo? $item->seo->title : $item->name;
		$this->desc = $item->seo? $item->seo->description : $item->name;
		$this->keywords = $item->seo? $item->seo->keywords : $item->name;
	}

	public function setMeta(string $title, string $desc = '', string $keywords = '')
	{
		$this->title = $title ? $title : 'Медицинкские перчатки';
		$this->desc = $desc ? $desc : 'Медицинкские перчатки';
		$this->keywords = $keywords ? $keywords : 'Медицинкские перчатки';
	}

	public function setJs(string $name)
	{
		$this->js[] = $name;
	}

	public function setCDNJs(string $src, bool $defer = false, bool $async = false): void
	{
		$this->CDNjs[] = ['src' => $src, 'defer' => $defer ? 'defer' : '', 'async' => $async ? 'async' : ''];
	}

	public function getCDNJs(): string
	{
		$str = '';
		foreach ($this->CDNjs as $CDNjs) {
			$str .= "<script {$CDNjs['defer']} {$CDNjs['async']}  src='{$CDNjs['src']}'></script>";
		}
		return $str;
	}

	public function setCDNCss(string $src): void
	{
		$this->CDNcss[] = $src;
	}

	public function getCDNCss(): string
	{
		$str = '';
		foreach ($this->CDNcss as $CDNcss) {
			$str .= "<link href='{$CDNcss}' rel='stylesheet' type='text/css'>";
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

	public function setCss(string $name)
	{
		$this->css[] = $name;
	}

	protected function getTime()
	{
		return ($this->cache) ? "?" . time() : "";
	}

	public function getJS(string $str = ''): string
	{
		foreach ($this->js as $name) {
			$str .= "<script src='{$this->host}{$name}.js{$this->getTime()}'></script>";
		}
		return $str;
	}

	public function getCss(string $str = '')
	{
		foreach ($this->js as $name) {
			$str .= "<link href='{$this->host}{$name}.css{$this->getTime()}' rel='stylesheet' type='text/css'>";
		}
		return $str;
	}

	public function getCssArray()
	{
		return $this->css;
	}

	public function getJsArray()
	{
		return $this->js;
	}

	public function getCDNCssArray()
	{
		return $this->CDNcss;
	}

	public function getCDNJsArray()
	{
		return $this->CDNjs;
	}

	public function setCache(): void
	{
		if ($_ENV['MODE'] === 'development') {
			$this->cache = false;
		} else {
			$this->cache = false;
		}
	}

	public function getCache(): bool
	{
		return $this->cache;
	}

	public function setQuill()
	{
//		$this->setCDNJs("https://cdn.quilljs.com/1.3.6/quill.bubble.css");
		$this->setCDNJs("https://cdn.quilljs.com/1.3.6/quill.js");
		$this->setCDNCss("https://cdn.quilljs.com/1.3.6/quill.snow.css");
	}

	public function setProduct()
	{
		$this->setJs('product');
		$this->setCss('product');
	}

	public function setAuth()
	{
		$this->setJs('auth');
		$this->setCss('auth');
	}

	public function merge(Assets $assets)
	{
		foreach ($assets->getJsArray() as $js) {
			$this->setJs($js);
		}
		foreach ($assets->getCssArray() as $css) {
			$this->setCss($css);
		}
		foreach ($assets->getCDNJsArray() as $js) {
			$this->setCDNJs($js['src'], $js['defer'], $js['async'],);
		}
		foreach ($assets->getCDNCssArray() as $css) {
			$this->setCDNCss($css);
		}
		$this->title = $this->title . $assets->title . ' | VITEX';
		$this->desc = $this->desc . $assets->desc;
		$this->keywords = $this->keywords . $assets->keywords;

	}

}