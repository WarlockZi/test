<?php


namespace app\view\Footer;


use app\core\FS;
use Illuminate\Support\Collection;

class UserFooter extends Footer
{

    public function __construct(
        private Collection $rootCategories
    )
    {
        $this->setFooter();
    }

    public function setFooter(): void
    {
        $rootCategories = $this->rootCategories;
        $this->footer = FS::getFileContent(ROOT . '/app/view/Footer/footerView.php', compact('rootCategories'));
    }

}