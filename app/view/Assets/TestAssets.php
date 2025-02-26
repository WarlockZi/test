<?php


namespace app\view\Assets;


class TestAssets extends Assets
{
	public function __construct(){
		parent::__construct();

		$this->setCDNJs("https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js");
		$this->setCDNCss("https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css");
		$this->setCDNCss("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css");

		return $this;
	}
}