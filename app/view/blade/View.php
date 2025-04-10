<?php

namespace app\view\blade;

use app\Services\AssetsService\UserAssets;
use app\Services\Router\Route;
use app\Services\Router\Router;
use app\view\layouts\MainLayout;
use Throwable;


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
                ->share('mainLayout', APP->get(MainLayout::class))
            ;
        } catch (\Exception $exception) {
            $e = $exception->getMessage();
        }
    }

    public function render($template, $data = []): string
    {
        try {
            exit($this->blade->run($template, $data));
        } catch (Throwable $exception) {

            exit($exception);
        }
    }
}