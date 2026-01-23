<?php

namespace app\action;

use app\service\Meta\MainMetaService;

class MainAction
{
    public function __construct(
        private MainMetaService       $meta,
    )
    {}
    public function setMeta($title, $description, $keywords): array
    {
        return $this->meta->setMeta(
            $title, $description, $keywords
        );
    }

}