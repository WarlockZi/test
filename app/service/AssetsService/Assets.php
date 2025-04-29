<?php


namespace app\service\AssetsService;

use app\model\Category;

class Assets
{
    public function __construct(
        protected bool     $isAdmin = false,

        protected Compiler $compiler = new AssetsVite(),
        public AssetsSEO   $seo = new AssetsSEO(),
        public AssetsCDN   $CDN = new AssetsCDN(),

    )
    {
        $this->setCompiler();
    }

    public function icon(): string
    {
        $link = DEV ? PIC_SERVICE."logo-square-dev.svg" : PIC_SERVICE."logo-square.svg";
        return "<link rel='icon' href='{$link}' type='image/svg+xml'>";
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
//    public function setMeta(Category $category): void
//    {
//        $this->seo->setMeta($category);
//    }
    public function setMeta(string $title, string $desc = '', string $keywords = ''): void
    {
        $this->seo->setMeta($title, $desc, $keywords);
    }

}