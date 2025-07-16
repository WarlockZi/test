<?php


namespace app\view\components\Footer;


use app\service\Fs\FS;

class AdminFooter extends Footer
{
    public function __construct()
    {
        $this->setFooter();
    }

    public function setFooter()
    {
        $this->footer = FS::getFileContent(ROOT . '/app/view/Footer/footerView.php');
    }

}