<?php

namespace app\service\AssetsService;

use app\service\Vite\Helpers;

class AssetsVite implements Compiler
{
    protected array $js = [];
    protected array $css = [];

    public function __construct(
        protected $compiler = new Helpers()
    )
    {
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

    public function getCss(): string
    {
        $admin  = str_contains($_SERVER['REQUEST_URI'], 'adminsc');
        $assets = '';

        if (DEV) {
            $assets = $this->compiler->client();
        }

        $assets = $admin
            ? $assets . $this->compiler->vite('Admin/admin.js')
            : $assets . $this->compiler->vite('Main/main.js')
            . $this->compiler->vite('Auth/auth.js');

        return $assets;
    }

    public function getJs(): string
    {
        return '';
    }
    public function setJs(string $name): void
    {
        $this->js[] = $name;
    }

    public function setCss(string $name): void
    {
        $this->css[] = $name;
    }
}