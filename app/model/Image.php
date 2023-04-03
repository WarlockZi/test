<?php

namespace app\model;

use app\core\FS;
use app\Repository\ImageRepository;
use app\view\Image\ImageView;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

	public $timestamps = false;
	public $imagePath = 'pic';

	protected $fillable = [
		'hash',
		'path',
		'name',
		'tag',
		'size',
		'type',
		'fullpath',
	];

	public function getRepo()
	{
		return new ImageRepository;
	}

	public function getFullPath()
	{
		$ext = $this->getExt();
		$path = $this->path ? $this->path . '/' : '';
		if (is_file(ROOT . '$path')) {
			return '/' . $this->imagePath . '/' . $path . $this->hash . '.' . $ext;
		}
		return "/pic/srvc/nophoto-min.jpg";
//		return ImageView::noImage();
	}

	public function getExt()
	{
		return $this->type;
	}

	public function getPath()
	{
		return '/' . $this->imagePath . '/' . $this->path . '/';
	}

	public function products()
	{
		return $this->morphedByMany(Product::class,
			'imageable');
	}

	public function categories()
	{
		return $this->morphedByMany(Category::class,
			'imageable');
	}

	public function product()
	{
		return $this->belongsTo(Image::class,);
	}

	public function tags()
	{
		return $this->morphToMany(Tag::class, 'taggable');
	}

}
