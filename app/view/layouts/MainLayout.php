<?php

namespace app\view\layouts;

use app\Services\FS;
use app\Services\Router\Route;
use app\view\components\Footer\UserFooter;
use app\view\components\Header\UserHeader;

class MainLayout extends Layout
{
   protected string $content;

    public function __construct(
        protected UserHeader $userHeader,
        protected UserFooter $userFooter,
        protected Route $route,
    )
    {
        $r = $route;
    }

    public function getHeader(): array
    {
        return $this->userHeader->getHeader();
    }
    public function getFooter(): string
    {
        return  $this->userFooter->getFooter();
    }
    public function getRoute(): Route
    {
        return  $this->route;
    }
    private function prepareContent($vars): string
    {
        try {
            if ($this->view === '404') {
                return (new FS(ROOT . '/app/view'))->getContent('404', $vars);
            }
            if (file_exists($this->viewFs->getAbsPath() . $this->view . '.php'))
                return $this->viewFs->getContent($this->view, $vars);
            return (new FS(ROOT . '/app/view'))->getContent('default', $vars);
        } catch (\Exception $exception) {
            ob_get_clean();
            ob_flush();
            $this->route->setError("В файле вида произошла ошибка");
            if (DEV) {
                $this->route->setError($exception);
            } else {
                $this->route->setError($exception->getMessage());
            }

            return $this->layoutFs->getContent('default', ['errors' => $this->route->getErrors()]);
        }
    }


}
