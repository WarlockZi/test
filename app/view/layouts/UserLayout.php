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
    protected string $view = '';
    protected UserHeader $header;
    protected FS $viewFs;
    protected string $layout = '';
    protected FS $layoutFs;
    protected array $content = [];

    public function __construct(
        protected Route   $route,
        public Controller $controller,
        protected Assets  $assets = new UserAssets(),

    )
    {
        $this->header = new UserHeader($this->route);

        $this->view     = $this->controller->view ?? $this->route->getView() ?? $this->route->getAction() ?? 'default';
        $this->viewFs   = new FS(dirname(__DIR__) . DIRECTORY_SEPARATOR . ucfirst($this->route->getControllerName()));
        $this->layout   = "layouts/vitex";
        $this->layoutFs = new FS(dirname(__DIR__));
        $this->setErrors();
        $this->setContent($controller);
    }

    public function setContent(Controller $controller): void
    {
        $this->content['header']  = $this->header->getHeader();
        $this->content['assets']  = $controller->assets;
        $this->content['content'] = $this->prepareContent($controller->vars);
        $this->content['footer']  = FS::getFileContent(ROOT . '/app/view/Footer/footerView.php');
    }

    private function prepareContent($vars): string
    {
        try {
            if ($this->view === '404') {
                return(new FS(ROOT.'/app/view'))->getContent('404');
            }
            return $this->viewFs->getContent($this->view, $vars);
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
        echo $this->layoutFs->getContent($this->layout, $this->content);
    }


}
