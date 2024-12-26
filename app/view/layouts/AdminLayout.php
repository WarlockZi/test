<?php

namespace app\view\layouts;

use app\controller\Controller;
use app\core\Auth;
use app\core\FS;
use app\core\Route;
use app\view\Assets\AdminAssets;
use app\view\Assets\Assets;
use app\view\Header\Admin\AdminHeader;
use Exception;

class AdminLayout extends Layout
{
    protected string $view;
    protected FS $viewFs;
    protected string $layout;
    protected FS $layoutFs;
    protected array $content;

    public function __construct(
        protected Route $route,
        Controller      $controller,
    )
    {
        $this->setView($controller);
        $this->layout   = "layouts/admin";
        $this->layoutFs = new FS(dirname(__DIR__));
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
            if (!file_exists($path.$this->view.'.php')) {
                $path =ROOT.'/app/view';
                $this->view = 'default';
            }
        }
        $this->viewFs = new FS($path);
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
        $fs = new FS(ROOT . '/app/view/Footer');
        return $fs->getContent('footerView',compact('vars'));
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

    public function render(): void
    {
        echo $this->layoutFs->getContent($this->layout, $this->content);
    }

}