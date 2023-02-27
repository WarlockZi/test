<?php


namespace app\view\Assets;


use app\controller\Controller;

class UserAssets extends Assets
{

	public function __construct(Controller $controller){
		parent::__construct();

		$controller->getAssets()->setJs('main');
		$controller->getAssets()->setJs('mainHeader');
		$controller->getAssets()->setJs('cookie');
		$controller->getAssets()->setJs('product');

		$controller->getAssets()->setCss('main');
		$controller->getAssets()->setCss('mainHeader');
		$controller->getAssets()->setCss('cookie');
		$controller->getAssets()->setCss('product');

		$controller->getAssets()->setCDNJs("https://cdn.quilljs.com/1.3.6/quill.js");
		$controller->getAssets()->setCDNCss("https://cdn.quilljs.com/1.3.6/quill.snow.css");


		return $this;
//		return $controller->getAssets();

//    View::setJs('card.js');
//    View::setJs('list.js');
//    View::setCss('list.css');
//    View::setCDNCss("https://cdn.quilljs.com/1.3.6/quill.bubble.css");
//		View::setJs('list.css');
//		View::setJs('breadcrumbs.js');
//		View::setCss('breadcrumbs.css');
	}


}