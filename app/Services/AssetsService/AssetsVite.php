<?php

namespace app\Services\AssetsService;

use app\Services\Vite\Helpers;

class AssetsVite implements Compiler
{
    protected array $js = [];
    protected array $css = [];

    public function __construct(
        protected $compiler = new Helpers()
    ){}

    public function setJs(string $name): void
    {
        $this->js[] = $name;
    }

    public function setCss(string $name): void
    {
        $this->css[] = $name;
    }

    public function getConfig(): array
    {
        return [
            'protocol' => 'http://',
            'port' => 5173,
            'path' => '/build/',
            'h1' => '127.0.0.1',
        ];
    }

    public function getJs(): string
    {
        return '';
    }

    public function getCss(): string
    {
        $admin = str_contains($_SERVER['REQUEST_URI'], 'adminsc');

        $assets = $admin
            ?
            $this->compiler->client() .
            $this->compiler->vite('Admin/admin.js')
            :
            $this->compiler->client() .
            $this->compiler->vite('Main/main.js') .
            $this->compiler->vite('Auth/auth.js');

        return $assets;

    }
}