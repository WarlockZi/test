<?php

namespace app\model;

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

	public function getFullPath(){
		$ext = $this->getExt();
		$path = $this->path?$this->path.'/':'';
		return '/'.$this->imagePath.'/'.$path.$this->hash.'.'.$ext;
	}

	public function getExt(){
//		$name = $this->name;
//		$pos = strpos($name,'.');
//		$res = substr($name,$pos+1, strlen($name));
//		return $res;
		return $this->type;
	}

	public function getPath(){
		return '/'.$this->imagePath.'/'.$this->path.'/';
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
		return $this->morphedByMany(Category::class,'imageable')
			->withPivot('slug');
	}


}
