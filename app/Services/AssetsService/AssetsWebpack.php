<?php

namespace app\Services\AssetsService;

class AssetsWebpack implements Compiler
{
    protected array $js = [];
    protected array $css = [];

    public function getConfig(): array
    {
        if (DEV) {
            return [
                'protocol' => 'http://',
                'h1' => 'localhost',
                'port' => ":4000",
                'path' => '/',
            ];
        } else {
            return [
                'protocol' => 'https://',
                'h1' => 'vi-prod',
                'port' => '',
                'path' => '/public/dist/',
            ];
        }

    }

    public function getJs(string $str = ''): string
    {
        foreach ($this->js as $name) {
            $str .= "<script type='module' src='{$this->host}{$this->path}{$name}.js{$this->getTime()}'></script>";
        }
        return $str;
    }

    public function getCSS(string $str = ''): string
    {
        foreach ($this->css as $name) {
            $str .= "<link href='{$this->host}{$this->port}{$this->path}{$name}.css{$this->getTime()}' rel='stylesheet' type='text/css'>";
        }
        return $str;
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