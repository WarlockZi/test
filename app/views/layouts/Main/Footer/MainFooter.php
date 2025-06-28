<?php
namespace app\views\layouts\Main\Footer;
use app\repository\CategoryRepository;
use app\view\components\Footer\Footer;
use JetBrains\PhpStorm\NoReturn;


class MainFooter extends Footer
{

    #[NoReturn] public function __construct()
    {
        $rootCategories = CategoryRepository::rootCategories();

//        $this->footer   =
//            view(
//                'layouts.main.footer.footer',
//                compact('rootCategories')
//            );
    }
}