<?php

namespace app\model;


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
		'imageable_type',
		'imageable_id'
	];

	public function productMainImage()
	{
		return $this->morphTo();
	}

	public function products()
	{
		return $this->morphedByMany(Product::class,'imageable');
	}

//	public function categories()
//	{
//		return $this->morphedByMany(Category::class,'imageable');
//	}

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


}
