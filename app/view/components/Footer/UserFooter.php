<?php


namespace app\view\components\Footer;


use app\Services\FS;


class UserFooter extends Footer
{

    public function __construct(
    )
    {
        $this->setFooter();
    }

    public function setFooter(): void
    {
        $rootCategories = APP->get('rootCategories');
        $this->footer   = FS::getFileContent(ROOT . '/app/view/components/Footer/footerView.php', compact('rootCategories'));
    }

}