<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Settings;
use app\Repository\SettingsRepository;
use app\view\Settings\Admin\SettingsFormView;


class SettingsController Extends AppController
{
	public string $model = Settings::class;
	public function __construct()
	{
		parent::__construct();
	}
    public function actionIndex(): void
    {
        $settings = $this->model::all();
        $list = SettingsFormView::list($settings);
        $this->set(compact('list'));
    }
	public function actionList()
	{
		$settings = (new SettingsRepository)->all();
		$list = SettingsFormView::list($settings);
		$this->set(compact('list'));
	}

	public function actionEdit()
	{
		$id = $this->route->id;
//		$setting = (new SettingsRepository)->edit($id);
//		if ($setting) {
//			$setting = SettingsFormView::edit($setting);
//		}
//		$this->set(compact('setting'));
//		$this->assets->setProduct();
	}
}
