<?php
use app\view\components\CustomCatalogItem\CustomCatalogItem;

ob_start();
$t = new CustomCatalogItem([

]);
return $t->html;