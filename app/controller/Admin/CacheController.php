<?php

namespace app\controller\Admin;

use app\blade\Blade;
use app\service\Response;
use JetBrains\PhpStorm\NoReturn;

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

    #[NoReturn] public function actionClear(): void
    {
        $this->clearAppCache();
        $this->clearBladeCache();
        $this->clearContanerCache();
        Response::exitWithPopup('Кэш очищен');
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
        ob_start();
        APP->get(Blade::class)->clearcompile();
        ob_end_clean();
    }
}