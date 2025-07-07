<?php

namespace app\service\Meta;

class CategoryMetaService extends MetaService
{

    public function __construct(
    )
    {
        parent::__construct();
    }

    public function setMeta(
        string|null $title,
        string|null $description,
        string|null $keywords,
    ): self
    {
        $this->title = $title ?? $this->title;
        $this->description = $description ?? $this->description;
        $this->keywords = $keywords ?? $this->keywords;

        return $this;
    }

}