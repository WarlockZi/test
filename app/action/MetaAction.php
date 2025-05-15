<?php

namespace app\action;

use app\service\MetaService\MetaService;

class MetaAction
{
public function __construct(
    public MetaService $seo,
)
{
}

    public function getMeta(): string
    {
        return $this->seo->getMeta();
    }

    public function setMeta(string $title, string $desc = '', string $keywords = ''): void
    {
        $this->seo->setMeta($title, $desc, $keywords);
    }
}