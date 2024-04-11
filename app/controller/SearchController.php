<?php

namespace app\controller;

use app\Actions\SearchAction;

class SearchController extends AppController
{
	protected $actions;

	public function __construct()
	{
		parent::__construct();
		$this->actions = new SearchAction();
	}


	public function actionIndex()
	{
		if (!$this->ajax) exit();
		$res = $this->actions->index($this->ajax['text']);
		$this->exitJson(['found' => $res]);
	}
}
