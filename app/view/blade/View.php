<?php

namespace app\view\blade;

use app\service\AssetsService\UserAssets;
use app\service\Router\IRequest;
use app\service\Router\Request;
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
//                ->share('assets', APP->get(UserAssets::class))
//                ->share('logo', APP->get('logo'))
                ->share('request', APP->get(IRequest::class))
                ->share('mainLayout', APP->get(MainLayout::class));
        } catch (\Exception $exception) {
            $e = $exception->getMessage();
        }
    }

    public function render(string $template, array $data = []): string
    {
        return $this->blade->run($template, $data);
    }
}