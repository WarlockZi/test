<?php

namespace app\controller\Admin;


use app\service\Response;

class CacheController extends AdminscController
{

    public function __construct(
        private readonly string $cachePath = ROOT.'/storage/framework/caches/*.txt',
        private readonly string $bladePath = ROOT.'/storage/framework/caches/blade*.txt',
        private readonly string $containerFile = ROOT.'/storage/framework/caches/blade*.txt',
    )
    {
        parent::__construct();

    }

    public function actionClear(): void
    {
        $this->clearAppCache();
        $this->clearBladeCache();
        $this->clearContanerCache();
    }

    private function clearAppCache(): void
    {
        array_map("unlink", glob($this->cachePath));
        response()->exitWithPopup('Кэш очищен');
    }
    private function clearContanerCache(): void
    {
        array_map("unlink", glob($this->cachePath));
        response()->exitWithPopup('Кэш очищен');
    }
    private function clearBladeCache(): void
    {
        array_map("unlink", glob($this->cachePath));
        response()->exitWithPopup('Кэш очищен');
    }

}


