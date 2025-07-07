<?php

namespace app\action;

use app\service\Meta\MainMetaService;
use app\service\Meta\MetaService;

class MainAction
{
    public function __construct(
        private MainMetaService       $meta,
    )
    {}
    public function setMeta($title, $description, $keywords): MetaService
    {
        return $this->meta->setMeta(
            $title, $description, $keywords
        );
    }

}