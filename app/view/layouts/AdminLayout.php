<?php

namespace app\view\layouts;

use app\controller\Controller;
use app\service\AssetsService\AdminAssets;
use app\service\AssetsService\Assets;
use app\service\AuthService\Auth;
use app\service\FS;
use app\service\Router\Request;
use app\view\components\Header\Admin\AdminHeader;
use Exception;

class AdminLayout extends Layout
{
    protected string $view;
    protected FS $viewFs;
//    protected string $layout;
//    protected FS $layoutFs;
//    protected array $content;

    public function __construct(
        protected Request $route,
        Controller        $controller,
    )
    {
        $this->setView($controller);
        $this->layout   = "layouts/admin";
        $this->layoutFs = new FS();
        $this->setErrors();
        $this->setContent($controller);
    }

    protected function setView(Controller $controller): void
    {
        $view = $controller->view ?? 'default';
        if ($view === 'table') {
            $this->view = $view;
            $path       = dirname(__DIR__) . DIRECTORY_SEPARATOR;
        } else {
            $this->view = '/Admin/' . $view;
            $path       = dirname(__DIR__) . DIRECTORY_SEPARATOR . ucfirst($this->route->getControllerName());
            if (!file_exists($path . $this->view . '.php')) {
                $path       = ROOT . '/app/view';
                $this->view = 'default';
            }
        }
        $this->viewFs = new FS();
    }

    public function setContent($controller): void
    {
        $this->content['header']  = $this->setHeader();
        $this->content['assets']  = $this->setAssets($controller);
        $this->content['content'] = $this->prepareContent($controller->vars);
        $this->content['errors']  = $this->route->getErrorsHtml();
//        $this->content['footer']  = $this->setFooter($controller->vars);
    }

    private function prepareContent($vars): string
    {
        try {
            $view = $this->view;
            return $content = $this->viewFs->getContent($view, $vars);
        } catch (Exception $exception) {
            ob_get_clean();
            $this->route->setError("В файле вида произошла ошибка");
            $this->route->setError($exception->getMessage());
            return $this->layoutFs->getContent('default', ['errors' => $this->route->getErrors()]);
        }
    }

    protected function setFooter($vars): string
    {
        $fs = new FS();
        return $fs->getContent('footerView', compact('vars'));
    }

    protected function setAssets($controller): Assets
    {
        $assets = new AdminAssets();
        return $assets;
    }

    protected function setHeader(): string
    {
        return (new AdminHeader(Auth::getUser()))->getHeader();
    }

//    public function render(): void
//    {
//        echo $this->layoutFs->getContent($this->layout, $this->content);
//    }

}