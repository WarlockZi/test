<?php


namespace app\view\Image;


use app\core\FS;
use app\model\Image;
use app\Repository\ImageRepository;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class ImageView
{
	public static $noPhotoRelative = '/pic/srvc/nophoto-min.jpg';

	public string $model = Image::class;

	public static function noImage(){
		$src = self::$noPhotoRelative;
		return "<img src={$src}>";
	}

	public static function noImageSrc(){
		return self::$noPhotoRelative;
	}

	public static function catMainImage(string $image){
		return "<img src='{$image}'>";
	}
	public static function productMainImage(Image $image){
		return "<img src='{$image->getFullPath()}'>";
	}

	public static function morphImages(Model $model, string $relation): string
	{
		if (!$model->$relation->count()||!$model->$relation) return '';
		ob_start();
		$str = '';
		foreach ($model->$relation as $item) {
				$str.= include ROOT.'/app/view/Image/Admin/morphImages.php';
		}
		return ob_get_clean();
	}

	protected static function getDetach(Model $item)
	{
		return FS::getFileContent(ROOT.'/app/view/components/Builders/Morph/detach.php',compact('item'));
	}

	public static function index(): string
	{
		return Table::build(Image::all())
			->pageTitle('Картинки')
			->column(
				ColumnBuilder::build('id')
					->name('ID')
					->get()
			)
			->column(
				ColumnBuilder::build('name')
					->name('Наименование')
					->contenteditable()
					->search()
					->width('1fr')
					->get()
			)
			->column(
				ColumnBuilder::build('type')
					->name('Тип')
					->width('150px')
					->get()
			)
			->column(
				ColumnBuilder::build('hash')
					->name('Картинка')
					->width('150px')
					->function(ImageRepository::class, 'getImgByHash')
					->get()
			)
			->column(
				ColumnBuilder::build('tags')
					->name('Тэги')
					->width('150px')
					->function(ImageRepository::class, 'getImgTags')
					->get()
			)
			->get();
	}

}