<?php


namespace app\view\Header\Admin;


use app\core\FS;
use app\model\User;

class AdminHeader
{
	protected string $header;
	protected array $user;
	protected string $templates;
	protected string $commonTemplates;
	protected string $blueRibbonTemplates;

	public function __construct(User $user)
	{
		$this->user = $user->toArray();
		$this->templates = __DIR__ . '/templates/';
		$this->commonTemplates = dirname(__DIR__ ). '/templates/';
		$this->blueRibbonTemplates = dirname(__DIR__ ). '/BlueRibbon/templates/';

        $logo = FS::getFileContent($this->templates.'logo_VITEX_grey.php');
        $chips = $user->can()
            ? FS::getFileContent($this->templates.'chips.php')
            : '';
        $searchPanel = FS::getFileContent($this->blueRibbonTemplates . 'searchPanel.php');
        $searchButton = FS::getFileContent($this->blueRibbonTemplates . 'searchButton.php');
        $user_menu = FS::getFileContent(ROOT . '/app/view/Header/templates/user_menu.php');

        $vars = compact('user', 'logo', 'chips', 'user_menu', 'searchPanel','searchButton');
        $adminSidebar = FS::getFileContent($this->templates .'admin_menu__accordion.php', $vars);
        $adminHeader = FS::getFileContent($this->templates .'admin_header.php', $vars);
        $this->header = $adminSidebar . $adminHeader;
	}

	public function getHeader()
	{
		return $this->header;
	}
}