<?php


namespace app\view;


use app\controller\Controller;
use app\core\Error;
use app\core\FS;
use app\core\Route;
use app\view\Assets\UserAssets;
use app\view\Header\UserHeader;

class UserView extends View
{
    protected $layout = "/layouts/vitex";
    protected static $noViewError = ROOT . '/app/view/404/index.php';
    protected $canonical;

    public function __construct(Route $route)
    {
        parent::__construct($route);
    }

    public function setContent(Controller $controller): void
    {
        $this->content = $this->fs->getContent($controller->getRoute()->getControllerFullName().'/'.$this->view, $controller->vars);
    }

//    public function setCanonical(Route $route, $vars)
//    {
//        if ($route->getControllerFullName() == "Short") {
//            $slug            = $vars['product']->slug;
//            $href            = "$route->protocol://$route->host/product/{$slug}";
//            $this->canonical = "<link rel='canonical' href={$href}>";
//        } else {
//            $this->canonical = '';
//        }
//    }
//
    public function getCanonical()
    {
        return $this->canonical;
    }

}