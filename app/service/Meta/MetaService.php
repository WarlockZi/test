<?php

namespace app\service\Meta;

class MetaService
{

    public function __construct(
        public string $title = 'Медицинкские перчатки оптом',
        public string $description = 'Медицинкские перчатки оптом',
        public string $keywords = 'Медицинкские перчатки оптом',
    )
    {
    }

    public function setMeta(
        string|null $title,
        string|null $description,
        string|null $keywords,
    ): array
    {
        $this->title       = $title;
        $this->description = $description;
        $this->keywords    = $keywords;
        return get_object_vars($this);
    }
}