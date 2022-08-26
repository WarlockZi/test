<?php

namespace app\model\Illuminate;


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

	public function product()
	{
		return $this->belongsTo(Image::class,);
	}



//	public function imageables()
//	{
//		return $this->morphTo();
//	}

//	public function imageables()
//	{
//		return $this->morphedByMany();
//	}

//	public function product()
//	{
//		return $this->belongsTo(Product::class);
//	}

//	public function productsMorph()
//	{
//		return $this->belongsToMany(Product::class, 'imageable');
//	}

//	public function create(){
//		parent::create();
//		$fname = substr($file['name'], 0, strlen($file['name']) - 4);
//		foreach ($sizes as $size) {
//			if (!$size) {
//				$ps = $this->createImgPaths($alias, $fname, null, null, $isOnly);
//				move_uploaded_file($file['tmp_name'], $ps['to']);
//			} else {
//				$pX = $this->createImgPaths($alias, $fname, $size, $toExt, $isOnly);
//				$new_image = new picture($ps['to']);
//				$new_image->autoimageresize($size, $size);
//				$new_image->imagesave($toExt, $pX['to'], $quality, 0777);
//			}
//		}
//	}
}
