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
//
//		<script src="/docs/5.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
//<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
//      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
//
//<link rel="stylesheet" href="./style.css">
	}
}