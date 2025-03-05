<?php


namespace app\model;


use Illuminate\Database\Eloquent\Model;

class ProductProperty extends Model
{
	public $timestamps = true;
	protected $fillable = [
		'product_1s_id',
		'short_link',
        'sort',
		'seo_title',
		'seo_description',
		'seo_keywords',
        'new',
        'leader',
        'created_at',
        'updated_at',
        'deleted_at',
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