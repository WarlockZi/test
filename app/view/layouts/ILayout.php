<?php

namespace app\view\layouts;


interface ILayout
{
    public function vite(array $assets):string;
}