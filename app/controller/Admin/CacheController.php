<?php

namespace app\controller\Admin;



use app\blade\Blade;

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
        response()->exitWithPopup('Кэш очищен');
    }

    private function clearAppCache(): void
    {
        array_map("unlink", glob($this->cachePath));
    }
    private function clearContanerCache(): void
    {
        array_map("unlink", glob($this->cachePath));

    }
    private function clearBladeCache(): void
    {
        $blade = APP->get(Blade::class);
        $blade->clearCache();
    }
}


