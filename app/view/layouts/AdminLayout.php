<?php

namespace app\view\layouts;

use app\core\Auth;
use app\core\FS;
use app\core\Route;
use app\view\Assets\AdminAssets;
use app\view\Header\Admin\AdminHeader;

class AdminLayout extends Layout
{
    protected Route $route;
    protected string $viewPath;
    protected string $layout;
    protected array $content;
    protected FS $fs;

    public function __construct(Route $route, array $vars)
    {
        $this->route    = $route;
        $this->viewPath = dirname(__DIR__);
//        if (User::can(Auth::getUser(), ['role_employee'])) http_redirect('/', 301);
        $this->setFs();
        $this->setLayout("layouts/admin");
        $this->setContent($vars);
    }

    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    public function setFs(): void
    {
        $this->fs = new FS($this->viewPath . '/');
    }

    public function setContent($vars): void
    {
        $this->content['header'] = (new AdminHeader(Auth::getUser()))->getHeader();
        $this->content['assets'] = new AdminAssets();

        $this->content['content'] = $this->prepareContent();
        $this->content['footer']  = FS::getFileContent(ROOT . '/app/view/Footer/footerView.php');
    }

    private function prepareContent()
    {
        $view = $this->getView();
        $route =  $this->route;
        $fs = new FS($view);
        return $fs->getContent($route->getActionName(), ['route' =>$route, 'vars'=>$vars]);
    }

    protected function getView():string
    {
        if ($this->route->isNotFound()) {
            $this->route->setError('Такого адреса нет');
            return 'default';
        }
        $controller = ucfirst($this->route->getControllerName());
        return FS::resolve(
            $this->viewPath,
            $controller,
            'Admin',
        );
    }

    public function render()
    {
        echo $this->getLayout();
    }

    public function getContent(): array
    {
        return $this->content;
    }

    protected function getLayout()
    {
        echo $this->fs->getContent($this->layout, $this->getContent());
    }

//    protected function vite($en)
//    {
//        $v = new \app\view\Vite($en);
////		vite();
//    }

//    protected function setTestAssets()
//    {
//        $this->assets = new TestAssets();
//    }
}