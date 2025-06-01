<?php

namespace app\blade;

use app\service\Router\IRequest;
use app\view\layouts\ILayout;
use Exception;

class View implements IView
{
    public function __construct(
        private Blade $blade
    )
    {
        $this->blade
            ->share('request', APP->get(IRequest::class))
            ->share('layout', APP->get(ILayout::class))
            ->share('orderItemsCount', APP->get('orderItemsCount'))
        ;
    }

    /**
     * @throws Exception
     */
    public function render(string $template, array $data = []): string
    {
        $s = DIRECTORY_SEPARATOR;
        if (str_starts_with($template, 'admin.')) {
            $this->blade->setLayout("layouts{$s}admin{$s}admin");
        } else {
            $this->blade->setLayout("layouts{$s}main{$s}main");
        }
        return $this->blade->run($template, $data);
    }
}