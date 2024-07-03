<?php


namespace app\Repository;


use app\model\Product;

/**
 * @method static index()
 */
class SearchRepository
{
    public function prepareQuryString($query): string
    {
      return '%' . stripslashes(mb_strtolower(trim($query))) . '%';
    }

    public function index(string $text): array
    {
        $queryString = $this->prepareQuryString($text);

        $admin = in_array('/adminsc', parse_url($_SERVER['HTTP_REFERER']));

        $art = $this->getArtQuery($this->getQuery($admin), $queryString);
        $name = $this->getNameQuery($this->getQuery($admin), $queryString);
        $sId = $this->getSIdQuery($this->getQuery($admin), $queryString);

        $collection = $art->merge($name);
        $collection = $collection->merge($sId);
        return $collection->map(function ($product) {
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
        $query = Product::query();
        if ($admin) {
            $query->withTrashed();
            $query->select('name', 'slug', 'art', 'id', 'instore', 'deleted_at');
            return $query;
        }
        return $query->select('name', 'slug', 'art', 'id', 'instore', '1s_id');
    }

    public function getArtQuery($query, $queryString)
    {
        $res = $query
            ->where('art', 'LIKE', $queryString)
            ->where('instore', '>', 0)
            ->take(20)
            ->get();

        return $res;
    }

    public function getNameQuery($query, $queryString)
    {
        $res = $query
            ->where('name', 'LIKE', $queryString)
            ->where('instore', '>', 0)
            ->take(20)
            ->get();
        return $res;
    }

    public function getSIdQuery($query, $queryString)
    {
        return $query
            ->where('1s_id', 'LIKE', $queryString)
            ->take(20)
            ->get();
    }

}