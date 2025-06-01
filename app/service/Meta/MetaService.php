<?php

namespace app\service\Meta;

use app\model\Product;

class MetaService
{

    public function __construct(
        public string $title = 'Медицинкские перчатки оптом',
        public string $description = 'Медицинкские перчатки оптом',
        public string $keywords = 'Медицинкские перчатки оптом',
    )
    {
    }

    public function setMeta(string $title,string $description,string $keywords): self
    {
        $this->title       = $title;
        $this->description = $description;
        $this->keywords    = $keywords;
        return $this;
    }

}