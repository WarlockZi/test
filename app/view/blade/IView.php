<?php

namespace app\view\blade;

interface IView
{
    public function render(string $template, $data = []):string;

}