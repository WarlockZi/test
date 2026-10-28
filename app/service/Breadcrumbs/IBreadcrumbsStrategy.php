<?php

namespace app\service\Breadcrumbs;

interface IBreadcrumbsStrategy
{
    public function generate() : array;
}