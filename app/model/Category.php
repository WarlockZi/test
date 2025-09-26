<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model
{
    use SoftDeletes;
    use HasRecursiveRelationships;

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

    protected $appends = [
//        'shortLink',
//        'href'
    ];

    public function meta(): hasOne
    {
        $self = $this;
        return $this->hasOne(
            CategoryProperty::class,
            '1s_category_id',
            '1s_id'
        )
            ->select(['seo_title', 'seo_desc', 'seo_keywords'])
            ->withDefault(function ($properties, $category) {
                $properties->seo_title    = $properties->seo_title
                    ?? $category->name . " - купить оптом недорого в интернет-магазине VITEX в Вологде";
                $properties->seo_desc     = $properties->seo_desc
                    ?? $category->name . ". Интернет-магазин медицинских перчаток, одноразового инструмента и расходников VITEX в Вологде. Оперативный ответ менеджера, быстрая доставка, доступные оптовые цены. Звоните и заказывайте прямо сейчас или на сайте онлайн";
                $properties->seo_keywords = $properties->seo_keywords
                    ?? $category->name;
            });
    }
    public function getParentKeyName(): string
    {
        return '1s_category_id';
    }
    public function getLocalKeyName(): string
    {
        return '1s_id';
    }
    public function productsInStore(): hasMany
    {
      return $this->hasMany(Product::class,
            '1s_category_id',
            '1s_id',
        )
            ->where('instore', '<>', 0)
            ->with('inactivepromotions')
            ->with('activepromotions')
            ->with('compare')
            ->with('like')
            ->with('units')
            ->with('ownProperties')
            ->orderBy('name')
;
    }

    public function productsNotInStoreInMatrix(): HasMany
    {
        return $this->hasMany(Product::class,
            '1s_category_id',
            '1s_id',
        )
            ->where('instore', 0)
            ->where('name', 'regexp', '\\s?\\*\\s?$')
            ->with('inactivepromotions')
            ->with(['activepromotions' => function ($q) {
                $q->whereNull('active_till');
            }])
            ->with('compare')
            ->with('like')
            ->with('units')
            ->with('ownProperties')
            ->orderBy('name')
            ;
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

    protected static function booted(): void
    {
//        static::Updating(function ($category) {
//            if (!$category->slug) {
//                $category->slug = SlugService::slug($category->name);
//            }
//            return $category;
//        });
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

    public function products(): hasMany
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
        return $this->hasMany(Category::class,
                '1s_category_id',
                '1s_id')
            ->whereNotNull('deleted_at');
    }

}
