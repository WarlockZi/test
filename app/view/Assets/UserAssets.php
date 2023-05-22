<?php


namespace app\view\Assets;


class UserAssets extends Assets
{
	public function __construct(){
		parent::__construct();

		$this->setJs('main');
		$this->setJs('mainHeader');
		$this->setJs('cookie');
		$this->setJs('product');

		$this->setCss('main');
		$this->setCss('mainHeader');
		$this->setCss('cookie');
		$this->setCss('product');

		$this->setCDNJs("https://cdn.quilljs.com/1.3.6/quill.js");
		$this->setCDNCss("https://cdn.quilljs.com/1.3.6/quill.snow.css");

		return $this;
	}
}