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
        'seo_h1',
        'seo_h2',
        'seo_full_name',
        'seo_article',
        'seo_path',
        'new',
        'leader',
        'show_front',
        'sort',
        'category_1s_id',
        'path',
    ];

    protected $attributes = [];

    public function category()
    {
        return $this->belongsTo(Category::class,
            'category_1s_id',
            '1s_id');
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