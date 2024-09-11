<?php


namespace app\view\Assets;




use app\view\layouts\Helpers;

class Assets
{
    public function __construct(
        protected string $host = '',
        protected bool   $cache = false,

        protected array  $js = [],
        protected array  $css = [],
        protected array  $CDNjs = [],
        protected array  $CDNCss = [],

        protected string $title = '',
        protected string $desc = '',
        protected string $keywords = '',

        protected string $port = '',
        protected string $path = '',
        protected string|Helpers $compiler = 'vite',
//        protected ?string|Helpers $compiler = 'webpack',

    )
    {
        $this->setCache();
        $this->setHost();
    }

    public function setHost(): void
    {
        $this->host = $_ENV['DEV']
            ? $this->setLocalhost($this->compiler)
            : '/public/dist/';
    }

    protected function getWebpack()
    {
        if ($_ENV['DEV'] === "1") {
            return [
                'protocol' => 'http://',
                'h1' => 'localhost',
                'port' => ":4000",
                'path' => '/',
            ];
        } else {
            return [
                'protocol' => 'https://',
                'h1' => 'vi-prod',
                'port' => '',
                'path' => '/public/dist/',
            ];
        }

    }

    protected function getVite()
    {
        $this->compiler = new Helpers();
        return [
            'protocol' => 'http://',
            'port' => 5173,
            'path' => '/dist/',
            'h1' => '127.0.0.1',
        ];
    }

    protected function setLocalhost($type): string
    {
        $type === 'webpack'
            ? extract($this->getWebpack())
            : extract($this->getVite());
        $str =  "{$protocol}{$h1}{$port}{$path}";
        return $str;
    }

    private function getWebpackJs(string $str = ''): string
    {
        foreach ($this->js as $name) {
            $str .= "<script type='module' src='{$this->host}{$this->path}{$name}.js{$this->getTime()}'></script>";
        }
        return $str;
    }

    private function getViteJs(): string
    {
        return '';
    }

    private function getWebpackCss(string $str = ''): string
    {
        foreach ($this->css as $name) {
            $str .= "<link href='{$this->host}{$this->port}{$this->path}{$name}.css{$this->getTime()}' rel='stylesheet' type='text/css'>";
        }
        return $str;
    }

    private function getViteCss(): string
    {
        $str = $this->compiler->client();
        $str .= $this->compiler->vite('Admin/admin.js');
        $str .= $this->compiler->vite('Main/main.js');
        $str .= $this->compiler->vite('Auth/auth.js');
        return $str;
    }

    public function getJS(): string
    {
        if ($this->compiler === 'webpack') {
            return $this->getWebpackJs();
        }
        return $this->getViteJs();
    }

    public function getCss(string $str = '')
    {
        if ($this->compiler === 'webpack') {
            return $this->getWebpackCss();
        }
        return $this->getViteCss();

    }

    public function getMeta()
    {
        return "<title>{$this->title}</title>" .
            "<meta name = 'description' content = '{$this->desc}'>" .
            "<meta name = 'keywords' content = '{$this->keywords}'>";
    }

    public function setMeta(string $title, string $desc = '', string $keywords = '')
    {
        $this->title    = $title ?? 'Медицинкские перчатки оптом';
        $this->desc     = $desc ?? 'Медицинкские перчатки оптом';
        $this->keywords = $keywords ?? 'Медицинкские перчатки оптом';
    }

    public function setJs(string $name): void
    {
        $this->js[] = $name;
    }

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

    public function setCache(): void
    {
        $this->cache = $_ENV['DEV'] ? false : false;
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
        foreach ($assets->js as $js) {
            $this->setJs($js);
        }
        foreach ($assets->css as $css) {
            $this->setCss($css);
        }
        foreach ($assets->CDNjs as $js) {
            $this->setCDNJs($js['src'], $js['defer'] === 'defer', $js['async'] === 'async',);
        }
        foreach ($assets->CDNCss as $css) {
            $this->setCDNCss($css);
        }
        $this->title    = $this->title . $assets->title . '  VITEX';
        $this->desc     = $this->desc . $assets->desc;
        $this->keywords = $this->keywords . $assets->keywords;

    }

}