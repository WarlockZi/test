<?php


namespace app\model;


use Illuminate\Database\Eloquent\Model;

class CategoryProperty extends Model
{

	public $timestamps = false;
	protected $fillable = [
		'category_1s_id',
		'seo_title',
		'seo_description',
		'seo_keywords',
		'short_link',
        'new',
        'leader',
	];

    public function product()
    {
        return $this->belongsTo(Category::class, 'category_1s_id');
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