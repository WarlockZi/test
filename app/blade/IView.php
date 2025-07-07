<?php

namespace app\blade;

interface IView
{
    public function render(string $template, array $data = []);

}