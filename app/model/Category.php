<?php

namespace app\model;


use app\Services\SlugService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = [
        'name',
        'slug',
        '1s_category_id',
        '1s_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = ['shortLink', 'href'];

    public function productsNotInStore()
    {
        return $this->hasMany(Product::class,
            '1s_category_id',
            '1s_id')
            ->where('instore', 0)
            ->with('mainImages')
            ->orderBy('name');
    }

    public function productsNotInStoreInMatrix(): HasMany
    {
        return $this->hasMany(Product::class,
            '1s_category_id',
            '1s_id')
            ->where('instore', 0)
            ->where('name', 'regexp', '\\s?\\*\\s?$')
            ->with('mainImages')
            ->with('ownProperties')
            ->with('shippableUnits')
            ->with('inactivepromotions')
            ->with(['activepromotions' => function ($q) {
                $q->whereNull('active_till');
            }])
            ->orderBy('name');
    }

    public function productsInStore()
    {
        $pInStore = $this->hasMany(Product::class,
            '1s_category_id',
            '1s_id')
            ->where('instore', '<>', 0)
            ->with('mainImages')
            ->with('order.orderitems')
            ->with('shippableUnits')
            ->with('inactivepromotions')
            ->with(['activepromotions' => function ($q) {
                $q->whereNull('active_till');
            }])
            ->with('compare')
            ->with('like')
            ->with('units')
            ->with('ownProperties')

//            ->with('prices')
//            ->select(['products.*', 'prices.price as product_price'])
//            ->join('prices', 'prices.1s_id', '=', 'products.1s_id')
//            ->orderBy('product_price')
        ;

        return $pInStore;
    }

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
            $this->childrenRecursive->flatMap(function ($q) {
                return $q->flatSelfAndChildren ?? collect([$this->id, $this->name, $this['1s_category_id']]);
            })
        );
    }

    protected function getHrefAttribute(): string
    {
        return !$this->ownProperties
            ? ""
            : "/catalog/{$this->ownProperties->path}";
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

    public function ownProperties(): HasOne
    {
        return $this->hasOne(CategoryProperty::class,
            '1s_category_id',
            '1s_id');
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
        return $this->hasMany(Product::class,
            "1s_category_id",
            '1s_id'
        )
            ->orderByDesc('name');
    }


    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class,
            '1s_category_id',
            '1s_id'
        );
    }

    public function parentRecursive(): BelongsTo
    {
        return $this->parent()->with('parentRecursive');
    }

    public function childrenRecursive(): HasMany
    {
        return $this->childrenNotDeleted()->with('childrenRecursive');
    }

    public function childrenNotDeleted(): HasMany
    {
        return $this->hasMany(Category::class,
            '1s_category_id',
            '1s_id',
        );
    }

    public function childrenDeleted()
    {
        return $this
            ->hasMany(Category::class,
                '1s_category_id',
                '1s_id')
            ->whereNotNull('deleted_at');
    }
//    public function cat(): BelongsTo
//    {
//        return $this->belongsTo(Category::class,
//            '1s_category_id',
//            '1s_id',
//        );
//    }
//
//    public function parents(): BelongsTo
//    {
//        return $this->cat()->with('parents');
//    }

}
