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
        $this->view     = $controller->view ?? $this->route->getActionName() ?? 'default';
        $this->viewFs   = new FS(dirname(__DIR__) . DIRECTORY_SEPARATOR . ucfirst($this->route->getControllerName()));
        $this->layout   = "layouts/admin";
        $this->layoutFs = new FS(dirname(__DIR__));
        $this->setErrors();
        $this->setContent($controller);
    }

    public function setContent($controller): void
    {
        $this->content['header']  = $this->setHeader();
        $this->content['assets']  = $this->setAssets($controller);
        $this->content['content'] = $this->prepareContent($controller->vars);
        $this->content['errors']  = $this->route->getErrorsHtml();
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
            return $content = $this->viewFs->getContent($this->getView(), $vars);
        } catch (Exception $exception) {
            ob_get_clean();
            $this->route->setError("В файле вида произошла ошибка");
            $this->route->setError($exception->getMessage());
            return $this->layoutFs->getContent('default', ['errors' => $this->route->getErrors()]);
        }
    }

    protected function getView(): string
    {
        return 'Admin/' . $this->view;
    }

    public function render(): void
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