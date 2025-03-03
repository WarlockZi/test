<?php

namespace app\view\Assets;

class AssetsCDN
{
    protected array $CDNjs = [];
    protected array $CDNCss = [];

    public function setCDNJs(string $src, bool $defer = false, bool $async = false): void
    {
        $this->CDNjs[] = ['src' => $src, 'defer' => $defer ? 'defer' : '', 'async' => $async ? 'async' : ''];
    }

    public function setCDNCss(string $src): void
    {
        $this->CDNcss[] = $src;
    }

    public function getCDNJs(): string
    {
        $str = '';
        foreach ($this->CDNjs as $CDNjs) {
            $str .= "<script {$CDNjs['defer']} {$CDNjs['async']}  src='{$CDNjs['src']}'></script>";
        }
        return $str;
    }

    public function getCDNCss(): string
    {
        $str = '';
        foreach ($this->CDNcss as $CDNcss) {
            $str .= "<link href='{$CDNcss}' rel='stylesheet' type='text/css'>";
        }
        return $str;
    }
}