<?php


namespace app\view\Assets;


class BotAssets extends Assets
{
	public function __construct()
	{
		parent::__construct();

		$this->setCss('bot');
		$this->setJs('bot');
	}
}