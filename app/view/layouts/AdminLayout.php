<?php

namespace app\view\layouts;

use app\controller\Controller;
use app\core\Auth;
use app\core\FS;
use app\core\Route;
use app\view\Assets\AdminAssets;
use app\view\Assets\Assets;
use app\view\Header\Admin\AdminHeader;

class AdminLayout extends Layout
{
    protected Route $route;
    protected string $viewPath;
    protected string $layout;
    protected array $content;
    protected FS $layoutFs;
    protected FS $viewFs;

    public function __construct(Route $route, Controller $controller)
    {
        $this->route    = $route;
        $this->setFs();
        $this->setView();
        $this->setErrors();
        $this->setLayout("layouts/admin");
        $this->setContent($controller);
    }
    protected function setErrors()
    {
        if ($this->route->isNotFound()) {
            $this->route->setError('Такого адреса нет');
        }
        if (!class_exists($this->route->getController())) {
            $this->route->setError('Контроллер не найден');
        }
        if (!is_readable($this->viewFs->getAbsPath() . $this->getView() . '.php')) {
            $this->route->setError('Файл вида не найден');
        }
    }
    public function setFs(): void
    {
        $this->layoutFs = new FS(dirname(__DIR__));
        $controller     = ucfirst($this->route->getControllerName());
        $this->viewFs   = new FS(dirname(__DIR__) . DIRECTORY_SEPARATOR . $controller);
    }
    protected function setView(): void
    {
        $this->view = $this->route->getView() ?? $this->route->getAction() ?? 'default';
    }
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    public function setContent($controller): void
    {
        $this->content['header']  = $this->setHeader();
        $this->content['assets']  = $this->setAssets($controller);
        $this->content['content'] = $this->prepareContent($controller->vars);
        $this->content['errors'] = $this->route->getErrorsHtml();
        $this->content['footer']  = FS::getFileContent(ROOT . '/app/view/Footer/footerView.php');
    }

    protected function setAssets($controller): Assets
    {
        $assets = new AdminAssets();
        $assets->merge($controller->getAssets());
        return $assets;
    }

    protected function setHeader(): string
    {
        return (new AdminHeader(Auth::getUser()))->getHeader();
    }

    private function prepareContent($vars): string
    {
        try {
            $content = $this->viewFs->getContent($this->getView(), $vars);
            return $content;
        } catch (\Exception $exception) {
            ob_get_clean();
//            ob_clean();
            $this->route->setError("В файле вида произошла ошибка");
            $this->route->setError($exception->getMessage());
            return $this->layoutFs->getContent('default', ['errors' => $this->route->getErrors()]);
        }

    }

    protected function getView(): string
    {
        return 'Admin/'.$this->view;
    }

    public function render()
    {
        echo $this->getLayout();
    }

    public function getContent(): array
    {
        return $this->content;
    }
    protected function getLayout(): string
    {
        return $this->layoutFs->getContent($this->layout, $this->getContent());
    }
}