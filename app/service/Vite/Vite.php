<?php

namespace app\service\Vite;

class Vite
{
    public function __construct(
        protected ViteCompiler $compiler,
    )
    {
    }

    public function vite(array $assets): string
    {
        $jsCss   = '';

        if (DEV) {
            $jsCss = $this->compiler->client();
        }
        foreach ($assets as $asset) {
            $jsCss .= $this->compiler->getAsset($asset);
        }

        return $jsCss;
    }
}