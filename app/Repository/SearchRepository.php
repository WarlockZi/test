<?php


namespace app\Repository;


use app\model\Product;
use Illuminate\Database\Eloquent\Collection;

/**
 * @method static index()
 */
class SearchRepository
{
    public function index(string $text): array
    {
        $queryString = '%' . stripslashes(mb_strtolower(trim($text))) . '%';

        $admin = in_array('/adminsc', parse_url($_SERVER['HTTP_REFERER']));

        $art  = $this->getProductsByField($this->getQuery($admin), $queryString, 'art');
        $name = $this->getProductsByField($this->getQuery($admin), $queryString, 'name');
        $sId  = $this->getProductsByField($this->getQuery($admin), $queryString, '1s_id');

        $collection = $art->merge($name);
        return $collection->merge($sId)
            ->map(function ($product) {
                return [
                    "name" => $product->name,
                    "art" => $product->art,
                    "mainImage" => $product->mainImage,
                    "slug" => $product->slug,
                ];
            })->toArray();
    }

    public function getQuery($admin)
    {
        return $admin
            ? Product::withTrashed()->select('name', 'slug', 'art', 'id', 'instore', 'deleted_at')
            : Product::select('name', 'slug', 'art', 'id', 'instore', '1s_id')->take(20);
    }

    private function getProductsByField($query, string $queryString, string $field): Collection
    {
        return $query
            ->where($field, 'LIKE', $queryString)
            ->get();
    }


}