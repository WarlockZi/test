<?php

namespace app\service\Meta;

use Illuminate\Database\Eloquent\Model;

class MainMetaService extends MetaService
{

    public function __construct()
    {
        parent::__construct();
    }

    public function setMeta(
        string|null $title,
        string|null $description,
        string|null $keywords):self
    {

        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;

        return $this;
    }

}