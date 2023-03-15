<?php

namespace app\model;

use app\core\FS;
use app\Repository\ImageRepository;
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
		return '/' . $this->imagePath . '/' . $path . $this->hash . '.' . $ext;
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
