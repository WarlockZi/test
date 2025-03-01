<?php

namespace app\model;

use app\view\Image\ImageView;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

	public $timestamps = true;
	public $imagePath = 'pic';

	protected $fillable = [
		'hash',  // ds11f1789w7g9a7f89  255
		'load_name',  // load_name      400
		'size', //6854                  11
		'path',  //21-08-12             255
		'type', // jpeg                 20
	];

	public function getFullPath()
	{
		$ext = $this->getExt();
		$path = $this->path ? "{$this->path}/" : "";
		if (is_file(ROOT . $path)) {
			return "/{$this->imagePath}/{$path}{$this->hash}.{$ext}";
		}
		return ImageView::noImageSrc();
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
