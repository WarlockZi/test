<?php


namespace app\repository;


use app\model\Product;
use app\service\AuthService\AuthService;
use app\service\Cache\Redis\Cache;
use Illuminate\Database\Eloquent\Collection;

class SearchRepository
{
    public function searchProducts(string $text): array
    {
        $queryString = $this->prepareSearchTerm($text);
        if ($queryString === '') {
            return [];
        }

        $isAdmin = AuthService::getUser()->isAdmin();

        $query = $isAdmin
            ? Product::withTrashed()->select('name', 'slug', 'art', 'id', 'instore', 'deleted_at')
            : Product::select('name', 'slug', 'art', 'id', 'instore', '1s_id')->take(20);
        Cache::enabled(true);
        $products = Cache::remember("search:{$queryString}:{$isAdmin}", fn () =>$this->new($query, $queryString), 60);

        return $products;
    }

      private function new($query, string $queryString)
    {
        $like     = "%{$queryString}%";
        $products = $query->where(function ($builder) use ($like) {
            $builder->where('name', 'LIKE', $like)
                ->orWhere('art', 'LIKE', $like)
                ->orWhere('slug', 'LIKE', $like)
                ->orWhere('1s_id', 'LIKE', $like);
        })->get();

        return $products
            ->unique('id')
            ->map(fn(Product $product) => [
                'id' => $product->id,
                'name' => $product->name,
                'art' => $product->art,
                'slug' => $product->slug,
                'mainImage' => $product->mainImage,
            ])
            ->values()
            ->toArray();
    }


    private function prepareSearchTerm(string $text): string
    {
        $term = trim($text);
        if ($term === '') {
            return '';
        }
        $term = addcslashes($term, '%_');
        return mb_strtolower($term);
    }


}