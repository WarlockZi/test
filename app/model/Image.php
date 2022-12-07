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
		return '/'.$this->imagePath.'/'.$this->path.'/'.$this->hash.'.'.$this->type;
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
