<?php

namespace app\action;

use app\service\Vite\ViteCompiler;

class ViteAction
{
    public function __construct(
        private readonly ViteCompiler $compiler,
    )
    {
    }


    public function getJsCss(array $assets): string
    {
        $jsCss   = '';
        $compiler = $this->compiler;

        if (DEV) {
            $jsCss = $compiler->client();
        }
        foreach ($assets as $asset) {
            $jsCss .= $compiler->getAsset($asset);
        }

        return $jsCss;
    }

}