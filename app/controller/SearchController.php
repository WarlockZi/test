<?php

namespace app\controller;

use app\Actions\SearchAction;
use app\core\Response;
use app\Repository\SearchRepository;

class SearchController extends AppController
{
	private SearchRepository $service;

	public function __construct()
	{
		parent::__construct();
		$this->service = new SearchRepository();
	}

	public function actionIndex():void
	{
		if (!$this->ajax) exit();
		$res = $this->service->index($this->ajax['text']);
		Response::exitJson(['found' => $res]);
	}
}
