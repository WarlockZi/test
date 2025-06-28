<?php

namespace app\blade;


use app\service\Router\IRequest;
use app\view\layouts\Admin\AdminLayout;
use app\view\layouts\Main\MainLayout;
use Exception;

class View implements IView
{
    public function __construct(
        private readonly Blade    $blade,
        private readonly IRequest $request,
    )
    {
        if ($this->request->isAdmin()) {
            $layout = APP->get(AdminLayout::class);
        } else {
            $layout = APP->get(MainLayout::class);
        }
        $this->blade
            ->share('request', $request)
            ->share('layout', $layout)
        ;
    }

    /**
     * @throws Exception
     */
    public function render(string $template, array $data = []): string
    {
        return $this->blade->run($template, $data);
    }
}