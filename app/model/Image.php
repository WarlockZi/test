<?php

namespace app\model;

use app\Repository\ImageRepository;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

	public $timestamps = false;

	protected $fillable = [
		'hash',
		'path',
		'name',
		'tag',
		'size',
		'type',
		'fullpath',
	];

	public function getPath(){
		$ext = ImageRepository::getExt($this->type);
		return "/pic/{$this->path}/{$this->hash}.{$ext}";
	}

	public function productMainImage()
	{
		return $this->morphTo();
	}

	public function products()
	{
		return $this->morphedByMany(Product::class,'imageable');
	}

	public function product()
	{
		return $this->belongsTo(Image::class,);
	}

	public function tags()
	{
		return $this->morphToMany(Tag::class, 'taggable');
	}

	public function bigPack($query)
	{
		return $query->where('tag')->name === 'ddf';
	}

	public function category(){
		return $this->morphedByMany(Category::class,'imageable');
	}


}
