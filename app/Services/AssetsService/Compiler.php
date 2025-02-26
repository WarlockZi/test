<?php

namespace app\Services\AssetsService;

interface Compiler
{
    public function getJs(): string;
    public function getCss(): string;
    public function setJs(string $name): void;
    public function setCss(string $name): void;
    public function getConfig(): array;

}