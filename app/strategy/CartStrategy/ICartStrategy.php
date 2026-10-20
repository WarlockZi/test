<?php

namespace app\strategy\CartStrategy;

interface ICartStrategy
{
    public function updateOrCreate(array $req): void;
}