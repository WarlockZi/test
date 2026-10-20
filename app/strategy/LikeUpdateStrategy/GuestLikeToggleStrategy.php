<?php

namespace app\strategy\LikeUpdateStrategy;

use app\model\Product;

class GuestLikeToggleStrategy implements ILikeToggleStrategy
{
    private const SESSION_KEY = 'likes';

    public function index()
    {
        $ids        = session()->get(self::SESSION_KEY, []);
        $productIds = array_keys($ids);

//        return $query->whereIn('id', $productIds);
        if (!empty($ids)) {
            $products = Product::query()
//                ->whereHas('like')
                ->whereIn('1s_id', $productIds)
//            ->limit(10)
                ->get();
            $product = $products->toArray();

            return $products;

        }
        return [];
    }

    public function toggleLike(array $req): bool
    {
        $likes = session()->get(self::SESSION_KEY, []);

        $product_id = $req['product_1s_id'];
        if (in_array($product_id, $likes, true)) {

            $likes = array_values(array_filter($likes,
                    fn($id) => $id !== $product_id)
            );
            session()->put(self::SESSION_KEY, $likes);
            return false;
        }

        $likes[$product_id] = $product_id;
        session()->put(self::SESSION_KEY, $likes);
        return true;
    }
}