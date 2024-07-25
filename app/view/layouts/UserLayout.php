<?php

namespace app\view\layouts;

use app\controller\Controller;
use app\core\FS;
use app\core\Route;
use app\view\Assets\Assets;
use app\view\Assets\UserAssets;
use app\view\Header\UserHeader;

class UserLayout extends Layout
{
    protected Assets $assets;
    protected UserHeader $header;
    protected string $view = '';
    protected FS $viewFs;
    protected string $layout = '';
    protected FS $layoutFs;
    protected array $content = [];

    public function __construct(
        protected Route $route,
        Controller      $controller,
    )
    {
        $this->assets = new UserAssets();
        $this->header = new UserHeader($this->route);

        $this->view     = $this->route->getView() ?? $this->route->getAction() ?? 'default';
        $this->viewFs   = new FS(dirname(__DIR__) . DIRECTORY_SEPARATOR . ucfirst($this->route->getControllerName()));
        $this->layout   = "layouts/vitex";
        $this->layoutFs = new FS(dirname(__DIR__));
        $this->setErrors();
        $this->setContent($controller);
    }

    protected function getView(): string
    {
        return $this->view;
    }

    public function setContent(Controller $controller): void
    {
        $this->content['header'] = $this->header->getHeader();
        $this->assets->merge($controller->getAssets());
        $this->content['assets']  = $this->assets;
        $this->content['content'] = $this->prepareContent($controller->vars);
        $this->content['footer']  = FS::getFileContent(ROOT . '/app/view/Footer/footerView.php');
    }

    private function prepareContent($vars): string
    {
        try {
            return $this->viewFs->getContent($this->getView(), $vars);
        } catch (\Exception $exception) {
            ob_get_clean();
            ob_flush();
            $this->route->setError("В файле вида произошла ошибка");
            if ($_ENV['DEV'] === '1') {
                $this->route->setError($exception);
            } else {
                $this->route->setError($exception->getMessage());
            }

            return $this->layoutFs->getContent('default', ['errors' => $this->route->getErrors()]);
        }
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
