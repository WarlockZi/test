<?php

namespace app\view\blade;

use app\Services\AssetsService\UserAssets;
use app\Services\Router\Route;
use app\view\layouts\MainLayout;
use JetBrains\PhpStorm\NoReturn;


class View implements IView
{
    private $blade;

    public function __construct(Blade $blade)
    {
        $this->blade = $blade;
        try {
            $this->blade
                ->share('assets', APP->get(UserAssets::class))
                ->share('logo', APP->get('logo'))
                ->share('route', APP->get(Route::class))
                ->share('mainLayout', APP->get(MainLayout::class));
        } catch (\Exception $exception) {
            $e = $exception->getMessage();
        }
    }

    #[NoReturn] public function render(string $template, array $data = []): void
    {
        exit($this->blade->run($template, $data));
    }
}