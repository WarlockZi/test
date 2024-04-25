<?php

namespace app\view\layouts;

class UserLayout extends Layout
{
    protected string $layout;
    protected string $content;

    public function __construct()
    {
//        if (User::can(Auth::getUser(), ['role_employee'])) http_redirect('/', 301);
        $this->setLayout(__DIR__ . "/vitex");
    }

    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}