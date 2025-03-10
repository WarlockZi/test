<?php


namespace app\view\Assets;

class Assets
{
    public function __construct(
        protected bool     $isAdmin = false,

        protected Compiler $compiler = new AssetsVite(),
//        protected Compiler     $compiler = new AssetsWebpack(),
        public AssetsSEO   $seo = new AssetsSEO(),
        public AssetsCDN   $CDN = new AssetsCDN(),
        public AssetsCache $cache = new AssetsCache(),
    )
    {
        $this->cache->setCache();
        $this->setCompiler();
    }

    protected function setCompiler(): string
    {
        extract($this->compiler->getConfig());
        return "{$protocol}{$h1}{$port}{$path}";
    }

    public function setIsAdmin(): string
    {
        $this->isAdmin = true;
    }

    public function setJs(string $name): void
    {
        $this->compiler->setJs($name);
    }

    public function setCss(string $name): void
    {
        $this->compiler->setCss($name);
    }

    public function getJS(): string
    {
        return $this->compiler->getJs();
    }

    public function getCss(string $str = ''): string
    {
        return $this->compiler->getCss();
    }

    public function getMeta(): string
    {
        return $this->seo->getMeta();
    }

    public function setMeta(string $title, string $desc = '', string $keywords = ''): void
    {
        $this->seo->setMeta($title, $desc, $keywords);
    }
//    public function merge(Assets $controllerAssets): void
//    {
//        array_merge([$controllerAssets, $this->compiler->getJs()]);
//        foreach ($controllerAssets->js as $js) {
//            $this->setJs($js);
//        }
//        foreach ($controllerAssets->css as $css) {
//            $this->setCss($css);
//        }
//        foreach ($controllerAssets->CDNjs as $js) {
//            $this->setCDNJs($js['src'], $js['defer'] === 'defer', $js['async'] === 'async',);
//        }
//        foreach ($controllerAssets->CDNCss as $css) {
//            $this->setCDNCss($css);
//        }
//        $this->seo->merge($this);
//    }

}