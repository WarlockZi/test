<?php


namespace app\view\Image;


use app\model\Image;
use app\Repository\ImageRepository;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use Illuminate\Database\Eloquent\Collection;


class ImageView
{

	public $model = Image::class;


	public static function list(Collection $items): string
	{
		$view = new self;
//		$items = Image::all()->toArray();
		return MyList::build($view->model)
			->items($items)
			->pageTitle('Картинки')
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get()
			)
			->column(
				ListColumnBuilder::build('name')
					->name('Наименование')
					->contenteditable()
					->search()
					->width('1fr')
					->get()
			)
			->column(
				ListColumnBuilder::build('type')
					->name('Тип')
					->width('150px')
					->get()
			)
			->column(
				ListColumnBuilder::build('hash')
					->name('Картинка')
					->width('150px')
					->function(ImageRepository::class, 'getImgByHash')
					->get()
			)
			->column(
				ListColumnBuilder::build('tags')
					->name('Тэги')
					->width('150px')
					->function(ImageRepository::class, 'getImgTags')
					->get()
			)


			->get();
	}

}