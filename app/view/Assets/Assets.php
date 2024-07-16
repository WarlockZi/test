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
    protected $port;
    protected $path;

    public function __construct()
    {
        $this->setCache();
        $this->setHost(1);
    }

    public function setHost($host = 1): void
    {
        $this->host = $_ENV['DEV']
            ? $this->setLocalhost($host === 1 ? 'webpack' : 'vite')
            : '/public/dist/';
    }

    protected function getWebpack()
    {
        return [
            's' => '',
            'port' => 4000,
            'path' => '/',
            'h1' => 'localhost',
        ];
    }

    protected function getVite()
    {
        return [
            's' => '',
//        $s = 's';
//        $port = 4173;
            'port' => 5173,
//        $path = '';
            'path' => '/dist/',
//        $path = '/';
//        $h1 = 'localhost';
            'h1' => '127.0.0.1',
//        $h1 = 'vi-prod';
        ];
    }

    protected function setLocalhost($type): string
    {
        if ($type === 'webpack') {
            extract($this->getWebpack());
        } else {
            extract($this->getVite());
        }

        $protocol = "http{$s}://";
        $str      = "{$protocol}{$h1}:{$port}{$path}";
        return $str;
    }

    public function getJS(string $str = ''): string
    {
        foreach ($this->js as $name) {
            $str .= "<script type='module' src='{$this->host}{$this->path}{$name}.js{$this->getTime()}'></script>";
        }
        return $str;
    }

    public function getCss(string $str = '')
    {
        foreach ($this->css as $name) {
            $str .= "<link href='{$this->host}{$this->port}{$this->path}{$name}.css{$this->getTime()}' rel='stylesheet' type='text/css'>";
        }
        return $str;
    }

    public function getMeta()
    {
        return "<title>{$this->title}</title>" .
            "<meta name = 'description' content = '{$this->desc}'>" .
            "<meta name = 'keywords' content = '{$this->keywords}'>";
    }

    public function setItemMeta(Model $item)
    {
        $this->title    = $item->ownProperties->seo_title ?? $item->name;
        $this->desc     = $item->ownProperties->seo_description ?? $item->name;
        $this->keywords = $item->ownProperties->seo_keywords ?? $item->name;
    }

    public function setMeta(string $title, string $desc = '', string $keywords = '')
    {
        $this->title    = $title ? $title : 'Медицинкские перчатки';
        $this->desc     = $desc ? $desc : 'Медицинкские перчатки';
        $this->keywords = $keywords ? $keywords : 'Медицинкские перчатки';
    }

    public function setJs(string $name)
    {
        $this->js[] = $name;
    }

    /**
     * @param string $src
     * @param bool $defer
     * @param bool $async
     */
    public function setCDNJs(string $src, bool $defer = false, bool $async = false): void
    {
        $this->CDNjs[] = ['src' => $src, 'defer' => $defer ? 'defer' : '', 'async' => $async ? 'async' : ''];
    }

    public function setCDNCss(string $src): void
    {
        $this->CDNcss[] = $src;
    }

    public function getCDNJs(): string
    {
        $str = '';
        foreach ($this->CDNjs as $CDNjs) {
            $str .= "<script {$CDNjs['defer']} {$CDNjs['async']}  src='{$CDNjs['src']}'></script>";
        }
        return $str;
    }

    public function getCDNCss(): string
    {
        $str = '';
        foreach ($this->CDNcss as $CDNcss) {
            $str .= "<link href='{$CDNcss}' rel='stylesheet' type='text/css'>";
        }
        return $str;
    }

    public function setCss(string $name)
    {
        $this->css[] = $name;
    }

    protected function getTime()
    {
        return ($this->cache) ? "?" . time() : "";
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
        if ($_ENV['DEV']) {
            $this->cache = false;
        } else {
            $this->cache = false;
        }
    }

    public function unsetJs(string $name)
    {
        unset($this->js[$name]);
    }

    public function unsetCss($name)
    {
        unset($this->css[$name]);
    }

    public function setQuill(): void
    {
//		$this->setCDNJs("https://cdn.quilljs.com/1.3.6/quill.bubble.css");
        $this->setCDNJs("https://cdn.quilljs.com/1.3.6/quill.js");
        $this->setCDNCss("https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css");
    }

    public function setProduct()
    {
        $this->setJs('product');
        $this->setCss('product');
    }

    public function setAuth(): void
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
            $this->setCDNJs($js['src'], $js['defer'] === 'defer', $js['async'] === 'async',);
        }
        foreach ($assets->getCDNCssArray() as $css) {
            $this->setCDNCss($css);
        }
        $this->title    = $this->title . $assets->title . '  VITEX';
        $this->desc     = $this->desc . $assets->desc;
        $this->keywords = $this->keywords . $assets->keywords;

    }

}