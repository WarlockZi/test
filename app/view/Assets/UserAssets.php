<?php


namespace app\view\Assets;


use app\controller\Controller;

class UserAssets extends Assets
{

	public function __construct(Controller $controller){
		parent::__construct($controller);

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

//    View::setJs('card.js');
//    View::setJs('list.js');
//    View::setCss('list.css');
//    View::setCDNCss("https://cdn.quilljs.com/1.3.6/quill.bubble.css");
//		View::setJs('list.css');
//		View::setJs('breadcrumbs.js');
//		View::setCss('breadcrumbs.css');
	}


}