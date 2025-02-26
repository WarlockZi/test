<?php

namespace app\view\layouts;

use app\controller\Controller;
use app\core\FS;
use app\core\Route;
use app\Repository\CategoryRepository;
use app\Services\AssetsService\Assets;
use app\Services\AssetsService\UserAssets;
use app\view\Footer\Footer;
use app\view\Footer\UserFooter;
use app\view\Header\UserHeader;

class UserLayout extends Layout
{
    protected string $view = '';
    protected UserHeader $header;
    protected UserFooter $footer;
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
        $rootCategories = CategoryRepository::rootCategories();
        $this->header   = new UserHeader($this->route, $rootCategories);
        $this->footer   = new UserFooter($rootCategories);

        $this->view    = $this->controller->view ?? $this->route->getView() ?? $this->route->getAction() ?? 'default';
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
        $this->content['footer']  = $this->footer->getFooter();
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


    public function render(): void
    {
        echo $this->layoutFs->getContent($this->layout, $this->content);
    }


}
