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
        'category_1s_id',
        's_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [];
    public function childrenNotDeleted(): HasMany
    {
        return $this->hasMany(Category::class,
            'category_1s_id',
            's_id',
        );
    }
    public function childrenRecursive(): HasMany
    {
        return $this->childrenWithOwnProps()
            ->with('childrenRecursive');
    }
    public function childrenRecursiveWithOwnProps(): HasMany
    {
        return $this
            ->childrenWithOwnProps()
            ->with('childrenRecursiveWithOwnProps');
    }

    public function childrenWithOwnProps(): HasMany
    {
        return $this->hasMany(Category::class,
            'category_1s_id',
            's_id',
        )
            ->with('ownProperties');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class,
            'category_1s_id',
            's_id',
        );
    }

    public function ownProperties(): HasOne
    {
        return $this->hasOne(CategoryProperty::class,
            'category_1s_id',
            's_id');
    }

    public function meta(): hasOne
    {
//        $self = $this;
        return $this->hasOne(
            CategoryProperty::class,
            'category_1s_id',
            's_id'
        )
            ->select(['seo_title', 'seo_desc', 'seo_keywords'])
            ->withDefault(function ($properties, $category) {
                $prop = $category->ownProperties;
                $titleTail = " - купить оптом недорого в интернет-магазине VITEX в Вологде";
                $descTail = ". Интернет-магазин медицинских перчаток, одноразового инструмента и расходников VITEX в Вологде. Оперативный ответ менеджера, быстрая доставка, доступные оптовые цены. Звоните и заказывайте прямо сейчас или на сайте онлайн";
                $seoFullName = $prop->seo_full_name??$category->name;
                $descHead = "Купить ".$seoFullName." оптом";

                $properties->seo_title    = $prop->seo_title.$titleTail
                    ?? $category->name . $titleTail;
                $properties->seo_desc     = $descHead.$prop->seo_desc.$descTail
                    ?? $descHead. $descTail;
                $properties->seo_keywords = $prop->seo_keywords
                    ?? $seoFullName;
            });
    }

    public function getParentKeyName(): string
    {
        return 'category_1s_id';
    }

    public function getLocalKeyName(): string
    {
        return 's_id';
    }

    public function productsInStore(): hasMany
    {
        $product =  $this->hasMany(Product::class,
            'category_1s_id',
            's_id',
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

        return $product;
    }

    public function productsNotInStoreInMatrix(): HasMany
    {
        $product=  $this->hasMany(Product::class,
            'category_1s_id',
            's_id',
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
             ->orderBy('name');

        return $product;
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
                return $q->flatSelfAndChildren ?? collect([$this->id, $this->name, $this['category_1s_id']]);
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

    public function mainImages()
    {
        return $this->morphToMany(
            Image::class,
            'imageable',
        )->where('slug', '=', 'main');
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
            "category_1s_id",
            's_id'
        )
            ->orderByDesc('name');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class,
            'category_1s_id',
            's_id'
        );
    }

    public function parentRecursive(): BelongsTo
    {
        return $this->parent()->with('parentRecursive');
    }

    public function childrenDeleted()
    {
        return $this->hasMany(Category::class,
            'category_1s_id',
            's_id')
            ->whereNotNull('deleted_at');
    }

}
