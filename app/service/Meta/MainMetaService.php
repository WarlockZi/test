<?php

namespace app\service\Meta;

class MainMetaService extends MetaService
{

    public function __construct()
    {
        parent::__construct();
    }

    public function setMeta(
        string|null $title,
        string|null $description,
        string|null $keywords):array
    {

        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;

        return get_object_vars($this);
    }
}