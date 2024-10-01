<?php

namespace app\view\layouts;

// For a real-world example check here:
// https://github.com/wp-bond/bond/blob/master/src/Tooling/Vite.php
// https://github.com/wp-bond/boilerplate/tree/master/app/themes/boilerplate

// you might check @vitejs/plugin-legacy if you need to support older browsers
// https://github.com/vitejs/vite/tree/main/packages/plugin-legacy
function vite(string $entry): string
{
    $vite = new helpers($entry);
    return $vite->getAssets();
}

class Helpers
{
    public function __construct(
        readonly private string $entry = '',
        private array           $manifest = [],
        private bool            $isDev = false,
        readonly private string $VITE_HOST = 'http://localhost:5133',
        readonly private string $manifestPath = ROOT . '/public/build/.vite/manifest.json',
        readonly private string $publicPath = '/public/build/',
    )
    {
        $this->isDev    = $this->isDev($entry);
        $this->manifest = $this->getManifest();
    }

    public function vite(string $entry): string
    {
        $vite = new helpers($entry);
        return $vite->getAssets();
    }

    public function getAssets(): string
    {
        return "\n" . $this->jsTag()
            . "\n" . $this->jsPreloadImports()
            . "\n" . $this->cssTag();
    }

    function isDev(string $entry): bool
    {
        static $exists = null;
        if ($exists !== null) {
            return $exists;
        }
        $handle = curl_init($this->VITE_HOST . '/' . $entry);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_NOBODY, true);

        curl_exec($handle);
        $error = curl_errno($handle);
        curl_close($handle);

        return $exists = !$error;
    }

    function client(): string
    {
        $url = $this->isDev
            ? $this->VITE_HOST . "{$this->publicPath}" . $this->entry
            : $this->assetUrl();

        if (!$url) return '';
        if ($this->isDev) {
            return "\n<script type='module' src='$this->VITE_HOST{$this->publicPath}@vite/client'></script>";
        }
        return "";
    }

    function jsTag(): string
    {
        $url = $this->isDev
            ? $this->VITE_HOST . "{$this->publicPath}" . $this->entry
            : $this->assetUrl();

        if (!$url) return '';
        if ($this->isDev) {
            return "<script type='module' src='$url'></script>";
        }
        return "<script type='module' src='$url'></script>";
    }

    function jsPreloadImports(): string
    {
        if ($this->isDev) return '';

        $res = '';
        foreach ($this->importsUrls() as $url) {
            $res .= "<link rel='modulepreload' href='$url'>";
        }
        return $res;
    }

    function cssTag(): string
    {
        // not needed on dev, it's inject by Vite
        if ($this->isDev) return '';

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






