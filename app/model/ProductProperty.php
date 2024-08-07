<?php


namespace app\model;


use Illuminate\Database\Eloquent\Model;

class ProductProperty extends Model
{

	public $timestamps = false;
	protected $fillable = [
		'product_1s_id',
		'seo_title',
		'seo_description',
		'seo_keywords',
		'short_link',
        'new',
        'leader',
	];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_1s_id');
    }

	public function property()
	{
		return $this->hasOne(Property::class);
	}

	public function val()
	{
		return $this->hasOne(Val::class, 'propertable');
	}



}