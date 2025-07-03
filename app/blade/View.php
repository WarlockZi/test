<?php

namespace app\blade;


use app\service\Router\IRequest;
use app\view\layouts\Admin\AdminLayout;
use Exception;

class View implements IView
{
    public function __construct(
        private readonly Blade    $blade,
        private readonly IRequest $request,
    )
    {
        $this->blade
            ->share('request', $request);
    }

    /**
     * @throws Exception
     */
    public function render(string $template, array $data = []): string
    {
        return $this->blade->run($template, $data);
    }
}