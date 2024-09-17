<?php

namespace app\Repository;

use app\model\Settings;
use Illuminate\Database\Eloquent\Model;

class SettingsRepository
{
	protected $model;
	protected $array;

	public function __construct()
	{
		$this->model = new Settings;
		$this->array = $this->all()->toArray();
	}

	public function all()
	{
		return $this->model->all();
	}

	public function initial(){
		return $this->all()->keyBy('name')->toArray();
	}

	public function edit(int $id):Model{
			return $this->model->query()->find($id);
	}

	public function getMainPhone():string {
		return $this->array['mainPhone']??'';
	}

	public function getDopPhones():array {
		return $this->array['dopPhones']??[];
	}

}
