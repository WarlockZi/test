<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Promotion;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;

class PromotionController Extends AppController
{
	public $model = Promotion::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionEdit()
	{
		$id = $this->route->id;
		$promotion = Promotion::with('product')->find($id);
		$promotion = ItemBuilder::build($promotion, 'promotion')
			->field(
				ItemFieldBuilder::build('id', $promotion)
					->get()
			)
			->field(
				ItemFieldBuilder::build('count', $promotion)
					->name('количество')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('new_price', $promotion)
					->contenteditable()
					->name('новая цена')
					->get()

			)
			->toList("adminsc/product/edit/{$promotion->product['id']}",'К списку')
			->get();
		$this->set(compact('promotion'));

	}

}
