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
        'seo_title',
        'seo_desc',
        'seo_keywords',
        'seo_h1',
        'seo_h2',
        'seo_article',
        'seo_path',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = ['shortLink', 'href'];

    public function seo_title()
    {
        return $this->ownProperties->seo_title ?? $this->name . " - купить оптом недорого в интернет-магазине VITEX в Вологде";
    }
    public function seo_description()
    {
        return $this->ownProperties->seo_description ?? $this->name . ". Интернет-магазин медицинских перчаток, одноразового инструмента и расходников VITEX в Вологде. Оперативный ответ менеджера, быстрая доставка, доступные оптовые цены. Звоните и заказывайте прямо сейчас или на сайте онлайн";
    }

    public function seo_article()
    {
        return $this->ownProperties->seo_article ?? $this->description ?? $this->name;
    }

    public function InactivePromotions()
    {
        return $this->products->activepromotions();
    }

    protected function getShortLinkAttribute(): string
    {
        if (!$this->ownProperties) {
            return '';
        }
        $link   = $this->ownProperties->short_link;
        $scheme = $_SERVER['REQUEST_SCHEME'] ?? '';
        $host   = $_SERVER['HTTP_HOST'] ?? '';
        return "{$scheme}://{$host}/short/{$link}";
    }
    public function getFlatSelfAndChildrenAttribute()
    {
        return collect([$this])->merge(
            $this->childrenRecursive->flatMap(function($q){
                return $q->flatSelfAndChildren ?? collect([$this->id, $this->name, $this->category_id]);
            })
        );
    }
    protected function getHrefAttribute(): string
    {
        if (!$this->ownProperties) return '';

        $path = $this->ownProperties->path;
        return "/catalog/{$path}";
    }

    public function ActivePromotions()
    {
        return $this->products->activepromotions();
    }

    protected static function booted()
    {
        static::Updating(function ($category) {
            if (!$category->slug) {
                $category->slug = SlugService::slug($category->name);
            }
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

    public function ownProperties()
    {
        return $this
            ->hasOne(CategoryProperty::class, 'category_1s_id', '1s_id')

            ;
    }

    public function scopeWithWhereHas($query, $relation, $constraint)
    {
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }

    public function properties()
    {
        return $this->morphToMany(Property::class, 'propertable');
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
            ->with('like')
            ->with('ownProperties')
            ->select(['products.*','prices.price as product_price'])
            ->join('prices', 'prices.1s_id', '=', 'products.1s_id')
            ->orderBy('product_price')
//            ->paginate('3')
        ;
        ;
//            ->with(['ownProperties'=>function ($q) {
//                $q->orderBy('price');
//            }])
//            ->orderBy('ownProperties.price');
            ;
//            ->orderBy('ownProperties.price');

        return $pInStore;
    }

    public function cat()
    {
        return $this->belongsTo(Category::class);
    }

    public function category()
    {
        return $this->parent()->with('parentRecursive');
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
