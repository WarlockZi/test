<?php


namespace app\model;


use Illuminate\Database\Eloquent\Model;

class CategoryProperty extends Model
{

	public $timestamps = false;
	protected $fillable = [
		'slug',
		'short_link',
		'seo_title',
		'seo_description',
		'seo_keywords',
		'seo_article',
        'new',
        'leader',
        'show_front',
        'sort',
		'category_1s_id',
		'path',
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