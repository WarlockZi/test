<?php
use eftec\bladeone\BladeOne;

$views = __DIR__ . '/views'; // Папка для шаблонов
$cache = __DIR__ . '/cache'; // Папка для кэша

$blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);