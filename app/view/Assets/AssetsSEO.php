<?php

namespace app\view\Assets;

class AssetsSEO
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

    public function setMeta(string $title = 'Медицинкские перчатки оптом', string $desc = 'Медицинкские перчатки оптом', string $keywords = 'Медицинкские перчатки оптом'): void
    {
        $this->title    = $title;
        $this->desc     = $desc;
        $this->keywords = $keywords;
    }

}