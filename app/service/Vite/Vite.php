<?php

namespace app\service\Vite;

use app\service\Nonce\Nonce;

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

        $nonce = Nonce::getInstance();
        $nonce = $nonce->getNonce();

        if (DEV) {
            $jsCss = $this->compiler->client($nonce);
        }
        foreach ($assets as $asset) {
            $jsCss .= $this->compiler->getAsset($asset);
        }

        return $jsCss;
    }
}