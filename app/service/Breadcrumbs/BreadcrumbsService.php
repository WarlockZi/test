<?php

namespace app\service\Breadcrumbs;


use app\service\Cache\Redis\Cache;

class BreadcrumbsService
{
    private $strategy;
    public function __construct(array|object $category, bool $lastItemLink = false)
    {
        $this->strategy = is_array($category)
            ? new BreadcrumbsArray($category, $lastItemLink)
            : new BreadcrumbsObj($category, $lastItemLink);
    }

    public static function generate(object|array $category, bool $lastItemLink = false): array
    {
        $breadcrumbs = Cache::remember('breadcrumbs_'.$category['slug'], function () use ($category, $lastItemLink) {
            $self = new self($category, $lastItemLink);
            return $self->strategy->generate();
        }, 20);
        return $breadcrumbs;
    }
}