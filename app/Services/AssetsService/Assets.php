<?php


namespace app\Services\AssetsService;

class Assets
{
    public function __construct(
        protected bool $isAdmin = false,

        protected Compiler     $compiler = new AssetsVite(),
//        protected Compiler     $compiler = new AssetsWebpack(),
        public AssetsSEO      $seo = new AssetsSEO(),
        public AssetsCDN      $CDN = new AssetsCDN(),
        public AssetsCache    $cache = new AssetsCache(),
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

    public function setJs(string $name): void
    {
        $this->compiler->setJs($name);
    }

    public function setCss(string $name):void
    {
        $this->compiler->setCss($name);
    }

    public function getJS(): string
    {
        return $this->compiler->getJs();
    }

    public function getCss(string $str = ''):string
    {
        return $this->compiler->getCss();
    }

    public function getMeta():string
    {
        return $this->seo->getMeta();
    }
    public function setMeta(string $title, string $desc='', string $keywords=''):void
    {
        $this->seo->setMeta($title, $desc, $keywords);
    }

}