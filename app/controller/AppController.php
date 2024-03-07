<?php

namespace app\controller;

use app\Actions\CRUDAction;
use app\controller\Interfaces\IModelable;
use app\Repository\SettingsRepository;
use Exception;
use ReflectionClass;

class AppController extends Controller implements IModelable
{
	protected $model;
	public array $settings;
	private CRUDAction $crud;

	public function __construct()
	{
		parent::__construct();
		$this->crud = new CRUDAction();
		$this->settings = (new SettingsRepository())->initial();
	}

	public function setView()
	{
		$view = $this->getView();
		$view->render();
	}

	public function actionDelete()
	{
		$this->crud->delete($this->ajax, $this->model);
	}

	public function actionAttach()
	{
		$this->crud->attach($this->ajax);
	}

	public function actionDetach()
	{
		$this->crud->dettach($this->ajax);
	}

	/**
	 * @throws Exception
	 */
	public function actionUpdateOrCreate()
	{
		$this->crud->updateOrCreate($this->ajax,$this->model);
	}

	public static function shortClassName($object)
	{
		return lcfirst((new ReflectionClass($object))->getShortName());
	}

	public function getModel()
	{
		return $this->model;
	}

	public function setModel($model)
	{
		$this->model = $model;
	}

}
