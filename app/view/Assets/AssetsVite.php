<?php

namespace app\view\Assets;

use app\view\layouts\Helpers;

class AssetsVite implements Compiler
{
    protected array $js = [];
    protected array $css = [];

    public function __construct(
        protected $compiler = new Helpers(),
    )
    {
    }

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
//        $this->host = $_ENV['DEV']
//            ? $this->setLocalhost($this->compiler)
//            : '/public/dist/';
        return [
            'protocol' => 'http://',
            'port' => 5173,
            'path' => '/dist/',
            'h1' => '127.0.0.1',
        ];
    }

    public function getJs(): string
    {
        return '';
    }

    public function getCss(): string
    {
        $str = $this->compiler->client();
        $str .= $this->compiler->vite('Admin/admin.js');
        $str .= $this->compiler->vite('Main/main.js');
        $str .= $this->compiler->vite('Auth/auth.js');
        return $str;
    }


}