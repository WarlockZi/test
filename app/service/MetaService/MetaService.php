<?php

namespace app\service\MetaService;

use app\model\Category;

class MetaService
{

    public function __construct(
        public string $title = '',
        public string $desc = '',
        public string $keywords = '',
    )
    {
    }

    public function getMeta(): string
    {
        return "<title>{$this->title}</title>" .
            "<meta name = 'description' content = '{$this->desc}'>" .
            "<meta name = 'keywords' content = '{$this->keywords}'>";
    }
    public function setCategoriesMeta(): void
    {
        $this->title    = 'Категории';
        $this->desc     = 'Категории:VITEX';
        $this->keywords = 'Категории: перчатки медицинские, инструмент для стаматолога, одноразовая одежда, одноразовый инструмент';
    }
    public function setCategoryMeta(Category $category): void
    {
        $this->title    = $category->seo_title() ?? 'Медицинкские перчатки оптом';
        $this->desc     = $category->seo_description() ?? 'Медицинкские перчатки оптом';
        $this->keywords = $category->seo_keywords() ?? 'Медицинкские перчатки оптом';
    }

    public function setMeta(string $title = 'Медицинкские перчатки оптом', string $desc = 'Медицинкские перчатки оптом', string $keywords = 'Медицинкские перчатки оптом'): void
    {
        $this->title    = $title;
        $this->desc     = $desc;
        $this->keywords = $keywords;
    }

}