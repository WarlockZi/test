<?php

namespace app\view\layouts;

// For a real-world example check here:
// https://github.com/wp-bond/bond/blob/master/src/Tooling/Vite.php
// https://github.com/wp-bond/boilerplate/tree/master/app/themes/boilerplate

// you might check @vitejs/plugin-legacy if you need to support older browsers
// https://github.com/vitejs/vite/tree/main/packages/plugin-legacy

class Helpers
{
    public function __construct(
        readonly private string $entry = '',
        private array           $manifest = [],
        private bool            $serverStarted = false,
//        readonly private string $viteHost = 'https://localhost:5133/',
//        readonly private string $viteHost = 'https://vi-prod:5133/public/build/',
        readonly private string $viteHost = 'https://localhost:5173/',
        readonly private string $viteAssets = 'assets/',
        readonly private string $manifestPath = ROOT . '/public/build/.vite/manifest.json',
        readonly private string $publicPath = '/public/build/',
        private string          $js = '',
        private string          $css = '',

    )
    {

//        $this->serverStarted = $this->loadedFromDevServer($this->entry);

        $this->manifest = $this->getManifest();
    }

    public function vite(string $entry): string
    {
        $vite = new helpers($entry);
        return $vite->getAssets();
    }

    public function getCss(): string
    {
        return $this->css;
    }

    public function getJs(): string
    {
        return $this->js;
    }

    public function getAssets(): string
    {
        $this->js  = "\n" . $this->jsTag()
            . "\n" . $this->jsPreloadImports();
        $this->css = "\n" . $this->cssTag();
        return $this->js . $this->css;
    }

    private function loadedFromDevServer(string $entry): bool
    {
        if (empty($entry)) return false;
        static $exists = null;
        if ($exists !== null) {
            return $exists;
        }
        $url = "$this->viteHost{$this->publicPath}{$entry}";
        $url = "$this->viteHost{$entry}";
//        $url = $this->VITE_HOST . '/' . $entry;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CAINFO, "D:/ospanel/userdata/config/cacert.pem");
        curl_setopt($ch, CURLOPT_NOBODY, true);


        curl_exec($ch);
        $error = curl_errno($ch);
        curl_close($ch);

        return $exists = !$error;
    }

    function client(): string
    {
        $url = $this->serverStarted
            ? $this->viteHost . "{$this->publicPath}" . $this->entry
            : $this->assetUrl();

//        if (!$url) return '';
        $public = '/public/build';
        $public = '';
//        $public = '/public/build/.vite';

        return DEV
            ? "\n<script type='module' src='$this->viteHost{$public}@vite/client'></script>"
//            ? "\n<script type='module' src='$this->VITE_HOST{$this->publicPath}@vite/client'></script>"
            : "";
    }

    function jsTag(): string
    {
        $first = $this->viteHost . "{$this->publicPath}" . $this->entry;
        $first = $this->viteHost  . $this->entry;
        $url = DEV
            ? $first
            : $this->assetUrl();

        return !empty($url)
            ? "<script type='module' src='$url'></script>"
            : '';
    }

    function jsPreloadImports(): string
    {
        if (!$this->serverStarted) return '';

        $res = '';
        foreach ($this->importsUrls() as $url) {
            $res .= "<link rel='modulepreload' href='$url'>";
        }
        return $res;
    }

    function cssTag(): string
    {
        // not needed on dev, it's inject by Vite
        if ($this->serverStarted) return '';

        $tags = '';
        foreach ($this->cssUrls() as $url) {
            $tags .= "<link rel='stylesheet' href='$url'>";
        }
        return $tags;
    }

    function assetUrl(): string
    {
        return isset($this->manifest[$this->entry])
            ? $this->publicPath . $this->manifest[$this->entry]['file']
            : '';
    }

    function importsUrls(): array
    {
        $urls = [];
        if (!empty($this->manifest[$this->entry]['imports'])) {
            foreach ($this->manifest[$this->entry]['imports'] as $imports) {
                $urls[] = $this->publicPath . $this->manifest[$imports]['file'];
            }
        }
        if (!empty($this->manifest[$this->entry]['dynamicImports'])) {
            foreach ($this->manifest[$this->entry]['dynamicImports'] as $imports) {
                $urls[] = $this->publicPath . $this->manifest[$imports]['file'];
            }
        }
        return $urls;
    }

    function cssUrls(): array
    {
        $urls = [];
        if (!empty($this->manifest[$this->entry]['css'])) {
            foreach ($this->manifest[$this->entry]['css'] as $file) {
                $urls[] = $this->publicPath . $file;
            }
        }
        return $urls;
    }

    function getManifest(): array
    {
        $content = file_get_contents($this->manifestPath);
        return json_decode($content, true);
    }
}






