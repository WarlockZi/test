<?php

namespace app\view\layouts;

use app\controller\Controller;
use app\core\FS;
use app\core\Route;
use app\view\Assets\UserAssets;
use app\view\Header\UserHeader;

class UserLayout extends Layout
{
    protected Route $route;

    protected string $layout;
    protected string $view;
    protected array $content;
    protected FS $viewFs;
    protected FS $layoutFs;

    public function __construct(Route $route, Controller $controller)
    {
        $this->route = $route;
        $this->setFs();
        $this->setLayout("layouts/vitex");
        $this->setView();
        $this->setErrors();
        $this->setContent($controller);
    }

    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    protected function getView(): string
    {
        return $this->view;
    }

    protected function setView(): void
    {
        $this->view = $this->route->getView() ?? $this->route->getAction() ?? 'default';
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

    public function setContent(Controller $controller): void
    {
        $this->content['header'] = (new UserHeader($this->route))->getHeader();
//        $uv                         = new UserView($route);
//        $this->content['canonical'] = $uv->getCanonical();
        $ass = new UserAssets();
        $ass->merge($controller->getAssets());
        $this->content['assets']  = $ass;
        $this->content['content'] = $this->prepareContent($controller->vars);
        $this->content['footer']  = FS::getFileContent(ROOT . '/app/view/Footer/footerView.php');
    }

    private function prepareContent($vars): string
    {
        try {
            $content = $this->viewFs->getContent($this->getView(), $vars);
            return $content;
        } catch (\Exception $exception) {
            ob_get_clean();
            $this->route->setError("В файле вида произошла ошибка");
            $this->route->setError($exception->getMessage());
            return $this->layoutFs->getContent('default', ['errors' => $this->route->getErrors()]);
        }
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
