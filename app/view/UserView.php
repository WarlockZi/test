<?php


namespace app\view;


use app\controller\Controller;
use app\core\Error;
use app\core\FS;
use app\model\User;
use app\view\Assets\UserAssets;
use app\view\components\Builders\SelectBuilder\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectNewBuilder;
use app\view\Header\UserHeader;

class UserView extends View
{
    protected $layout = "/layouts/vitex";
    protected static $noViewError = ROOT . '/app/view/404/index.php';
    protected $canonical;

    public function __construct(Controller $controller)
    {
        parent::__construct($controller);
        $this->setCanonical($controller);
        $this->setAssets();
        $this->header = new UserHeader();
        $this->setFooter();
    }

    public function get404(): string
    {
        return FS::getFileContent(self::$noViewError);
    }

    public function setContent(Controller $controller): void
    {
        $this->content = $this->fs->getContent($controller->getRoute()->getControllerFullName().'/'.$this->view, $controller->vars);
    }

    public function setHeader($user, $settings)
    {
        $this->header = new UserHeader();
    }

    public function setFooter()
    {
        $this->footer = FS::getFileContent(ROOT . '/app/view/Footer/footerView.php');
    }

    public function getFooter()
    {
        return $this->footer;
    }

    protected function setAssets()
    {
        $this->assets = new UserAssets();
        $this->assets->merge($this->controller->getAssets());
    }

    public function setCanonical(Controller $controller)
    {
        $route = $controller->getRoute();
        if ($route->getControllerFullName() == "Short") {
            $slug            = $controller->vars['product']->slug;
            $href            = "$route->protocol://$route->host/product/{$slug}";
            $this->canonical = "<link rel='canonical' href={$href}>";
        } else {
            $this->canonical = '';
        }
    }

    public function getCanonical()
    {
        return $this->canonical;
    }

    function getErrors()
    {
        if (Error::getErrorHtml()) {
            include self::get404();
        }
    }

    function getHeader()
    {
        return $this->header->getHeader();
    }

    function getLayout()
    {
        return $this->layout;
    }
}