<?php

namespace app\model;


use app\Services\SlugService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = [
        '1s_id',
        'name',
        'description',
        'sort',
        'slug',
        'img',
        'category_id',
        'show_front',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function InactivePromotions()
    {
        return $this->products->activepromotions();
    }

    public function ActivePromotions()
    {
        return $this->products->activepromotions();
    }

    protected static function booted()
    {
        static::Updating(function ($category) {
            $category->slug = SlugService::slug($category->name);
            return $category;
        });
    }


    public function mainImages()
    {
        return $this->morphToMany(
            Image::class,
            'imageable',
        )->where('slug', '=', 'main');
    }

//    public function seo()
//    {
//        return $this
//            ->hasOne(Seo::class, 'product_category_1sid', '1s_id');
//    }

    public function ownProperties()
    {
        return $this->hasOne(CategoryProperty::class, 'category_1s_id', '1s_id');
    }

    public function properties()
    {
        return $this->morphToMany(Property::class, 'propertable');
    }

    public function category()
    {
        return $this->parent()->with('parentRecursive');
    }

    public function products()
    {
        return $this->hasMany(Product::class)
            ->orderByDesc('name')//->groupBy('instore')
            ;
    }

    public function productsNotInStore()
    {
        return $this->hasMany(Product::class)
            ->where('instore', 0)
            ->with('mainImages')
            ->orderBy('name');
    }

    public function productsNotInStoreInMatrix(): HasMany
    {
        return $this->hasMany(Product::class)
            ->where('instore', 0)
            ->where('name', 'regexp', '\\s?\\*\\s?$')
            ->with('mainImages')
            ->with('ownProperties')
            ->orderBy('name');
    }

    public function productsInStore()
    {
        $pInStore = $this->hasMany(Product::class)
            ->where('instore', '<>', 0)
            ->with('mainImages')
            ->with('promotions')
            ->with('units')
            ->with('ownProperties')
            ->orderBy('name');

        return $pInStore;
    }

    public function cat()
    {
        return $this->belongsTo(Category::class);
    }


    public function parents()
    {
        return $this->cat()->with('parents');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function parentRecursive()
    {
        return $this->parent()->with('parentRecursive');
    }


    public function childrenRecursive()
    {
        return $this->childrenNotDeleted()->with('childrenRecursive');
    }

    public function childrenNotDeleted()
    {
        return $this
            ->hasMany(Category::class, 'category_id')
            ->whereNull('deleted_at');
    }

    public function childrenDeleted()
    {
        return $this
            ->hasMany(Category::class, 'category_id')
            ->whereNotNull('deleted_at');
    }

}
