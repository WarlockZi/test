<?php

namespace app\service\Vite;

// For a real-world example check here:
// https://github.com/wp-bond/bond/blob/master/src/Tooling/Vite.php
// https://github.com/wp-bond/boilerplate/tree/master/app/themes/boilerplate

// you might check @vitejs/plugin-legacy if you need to support older browsers
// https://github.com/vitejs/vite/tree/main/packages/plugin-legacy

use app\service\Nonce\Nonce;

class ViteCompiler
{
    public function __construct(
        private string $entry = '',
        private string $devHost = '',
        private array  $manifest = [],
        private string $manifestPath = '',
        private string $productionPath = '',
        private string $js = '',
        private string $css = '',

    )
    {
        $protocol = env('VITE_PROTOCOL', 'http://');
        $host     = env('VITE_HOST', '127.0.0.1');
        $port     = env('VITE_PORT', 5173);
        $path     = env('VITE_PRODUCTION_PATH', '/build/');

        $this->manifestPath   = ROOT . env('VITE_MANIFEST_PATH');
        $this->productionPath = $path;
        $this->devHost        = "$protocol://$host:$port/";
        $this->manifest       = $this->getManifest();
    }

    public function getAsset(string $entry): string
    {
        $this->entry = $entry;
        return $this->getAssets();
    }

    public function getAssets(): string
    {
//        $nonce = Nonce::getInstance();
        $nonce = Nonce::getNonce();
        $this->js  = "\n" . $this->jsTag($nonce)
            . "\n" . $this->jsPreloadImports($nonce);
        $this->css = "\n" . $this->cssTag($nonce);
        return $this->js . $this->css;
    }
//    function vite_asset($entry) {
//        if (is_dev_server_running()) {
//            return '
//            <script type="module" src="http://localhost:3000/@vite/client" nonce="' . generate_nonce() . '"></script>
//            <script type="module" src="http://localhost:3000/resources/js/app.js" nonce="' . generate_nonce() . '"></script>
//        ';
//        }
//    }
//
//    function is_dev_server_running() {
//        return file_exists(__DIR__ . '/hot');
//    }
    function client(string $nonce): string
    {
        return DEV
            ? "<script nonce='$nonce' type='module' src='$this->devHost@vite/client'></script>"
            : "";
    }

    function jsTag(string $nonce): string
    {
         if (DEV) return "<script nonce='$nonce' type='module' src='{$this->devHost}{$this->entry}'></script>";

        $url = $this->productionPath . $this->manifest[$this->entry]['file'];
        return !empty($url)
            ? "<script nonce='{$nonce}' type='module' src='$url'></script>"
            : '';
    }

    function cssTag(string $nonce): string
    {
        // not needed on dev, it's inject by Vite
        if (DEV) return '';
        $tags = '';
        foreach ($this->cssUrls() as $url) {
            $tags .= "<link nonce='{$nonce}' rel='stylesheet' href='$url'>";
        }
        return $tags;
    }

    function jsPreloadImports(): string
    {
        if (DEV) return '';
        $res = '';
        foreach ($this->importsUrls() as $url) {
            $res .= "<link rel='modulepreload' href='$url'>";
        }
        return $res;
    }

    function importsUrls(): array
    {
        $urls = [];
        if (!empty($this->manifest[$this->entry]['imports'])) {
            foreach ($this->manifest[$this->entry]['imports'] as $imports) {
                $urls[] = $this->productionPath . $this->manifest[$imports]['file'];
            }
        }
        if (!empty($this->manifest[$this->entry]['dynamicImports'])) {
            foreach ($this->manifest[$this->entry]['dynamicImports'] as $imports) {
                $urls[] = $this->productionPath . $this->manifest[$imports]['file'];
            }
        }
        return $urls;
    }

    function cssUrls(): array
    {
        $urls = [];
        if (!empty($this->manifest[$this->entry]['css'])) {
            foreach ($this->manifest[$this->entry]['css'] as $file) {
                $urls[] = $this->productionPath . $file;
            }
        }
        return $urls;
    }

    function getManifest(): array
    {
        if (is_readable($this->manifestPath)) {
            $content = file_get_contents($this->manifestPath);
            return json_decode($content, true) ?? [];
        }
        return [];
    }

}







