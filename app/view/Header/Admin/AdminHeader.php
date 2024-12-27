<?php


namespace app\view\Header\Admin;


use app\core\FS;
use app\core\IUser;
use app\Repository\FeedbackRepository;

class AdminHeader
{
    protected string $header;

    public function __construct(IUser $user)
    {
        $fs = new FS(dirname(__DIR__));

//        $logo         = $fs->getContent('/Admin/templates/logo_VITEX_grey');
        $searchPanel  = $fs->getContent('/BlueRibbon/templates/search_panel');
        $searchButton = $fs->getContent('/BlueRibbon/templates/search_button');
        $feedbackCount = FeedbackRepository::getCount();
        $feedback     = $fs->getContent('/BlueRibbon/templates/feedback',compact('feedbackCount'));
        $userMenu     = $fs->getContent('/templates/user_menu');

        $vars         = compact('user',  'userMenu', 'searchPanel', 'feedback','searchButton');
        $adminSidebar = $fs->getContent('/Admin/templates/admin_menu_accordion', $vars);
        $adminHeader  = $fs->getContent('/Admin/templates/admin_header', $vars);
        $this->header = $adminSidebar . $adminHeader;
    }

    public function getHeader()
    {
        return $this->header;
    }
}