<?php


namespace app\view\Assets;


class AdminAssets extends Assets
{
	public function __construct()
	{
		parent::__construct();

		$this->setJs('admin');
		$this->setJs('list');
		$this->setJs('common');
		$this->setJs('product');

		$this->setCss('admin');
		$this->setCss('list');
		$this->setCss('common');
		$this->setCss('product');

//		$this->setCDNJs("https://cdn.quilljs.com/1.3.6/quill.js");
//		$this->setCDNCss("https://cdn.quilljs.com/1.3.6/quill.snow.css");

		$this->setCss('product');
	}
}