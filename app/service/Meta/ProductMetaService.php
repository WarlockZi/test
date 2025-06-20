<?php

namespace app\service\Meta;

use Illuminate\Database\Eloquent\Model;

class ProductMetaService extends MetaService
{

    public function __construct(
    )
    {
        parent::__construct();
    }

    public function setMeta(Model $product):self
    {
        $this->title = $product['own_properties']['seo_title']
            ?? $product['name']
            ?? $this->title
        ;
        $this->description = $product['own_properties']['seo_desc']
            ?? $product['name']
            ?? $this->description
        ;
        $this->keywords = $product['own_properties']['seo_keywords']
            ?? $product['name']
            ?? $this->keywords
        ;

        return $this;
    }

}