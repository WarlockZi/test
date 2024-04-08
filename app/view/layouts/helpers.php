<?php

namespace app\vite;

class Vite
{
	protected $VITE_HOST;
	protected $MANIFEST;
	protected string $entry;
	protected bool $isDev;

//const VITE_HOST = 'http://localhost:4000/public/build/assets';

	protected function __construct(string $entry, $host )
	{
		$this->entry = $entry;
		$this->VITE_HOST = $host;
		$this->MANIFEST = $this->getManifest(ROOT . '/public/dist/.vite/manifest.json');
		$this->isDev = $this->isDev();
	}

	public static function serve(string $entry, $host= 'http://localhost:5133')
	{
		$vite = new self($entry, $host);
		return $vite->vite();
	}

	function vite(): string
	{
		$js = $this->jsTag();
		$preImport = $this->jsPreloadImports();
		$css = $this->cssTag();
		return "\n" . $js
			. "\n" . $preImport
			. "\n" . $css;
	}


	function isDev(): bool
	{
		static $exists = null;
		if ($exists !== null) {
			return $exists;
		}

		$h1 = $this->h1($this->VITE_HOST);
//		$h2 = $this->h1('https://localhost:5133');
//		$h3 = $this->h1('https://172.25.240.1:5133');
//		$h4 = $this->h1('https://192.168.1.212:5133');

		return !$h1;
	}

	function h1($host)
	{
		$handle = curl_init($host . '/' . $this->entry);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_NOBODY, true);

		curl_exec($handle);
		$error = curl_errno($handle);
		curl_close($handle);
		return $error;
	}

	function jsTag(): string
	{
		$url = $this->isDev
			? $this->VITE_HOST . '/' . $this->entry
			: $this->assetUrl();

		if (!$url) {
			return '';
		}
		if ($this->isDev) {
			return '<script type="module" src="' . $this->VITE_HOST . '/@vite/client"></script>' . "\n"
				. '<script type="module" src="' . $url . '"></script>';
		}
		return '<script type="module" src="' . $url . '"></script>';
	}

	function jsPreloadImports(): string
	{
		if ($this->isDev) {
			return '';
		}

		$res = '';
		foreach ($this->importsUrls() as $url) {
			$res .= '<link rel="modulepreload" href="'
				. $url
				. '">';
		}
		return $res;
	}

	function cssTag(): string
	{
		// not needed on dev, it's inject by Vite
		if ($this->isDev) {
			return '';
		}

		$tags = '';
		foreach ($this->cssUrls() as $url) {
			$tags .= '<link rel="stylesheet" href="'
				. $url
				. '">';
		}
		return $tags;
	}


	function getManifest($path): array
	{
		$content = file_get_contents($path);
		return json_decode($content, true);
	}

	function assetUrl(): string
	{

		return isset($this->MANIFEST[$this->entry])
			? '/dist/' . $this->MANIFEST[$this->entry]['file']
			: '';
	}

	function importsUrls(): array
	{
		$urls = [];

		if (!empty($this->MANIFEST[$this->entry]['imports'])) {
			foreach ($this->MANIFEST[$this->entry]['imports'] as $imports) {
				$urls[] = '/dist/' . $this->MANIFEST[$imports]['file'];
			}
		}
		return $urls;
	}

	function cssUrls(): array
	{
		$urls = [];

		if (!empty($this->MANIFEST[$this->entry]['css'])) {
			foreach ($this->MANIFEST[$this->entry]['css'] as $file) {
				$urls[] = '/dist/' . $file;
			}
		}
		return $urls;
	}
}
