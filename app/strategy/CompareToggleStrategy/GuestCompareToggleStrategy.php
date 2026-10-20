<?php

namespace app\strategy\CompareToggleStrategy;

use app\model\Product;

class GuestCompareToggleStrategy implements ICompareToggleStrategy
{
    private const SESSION_KEY = 'compares';

    public function index()
    {
        $ids        = session()->get(self::SESSION_KEY, []);
        $productIds = array_keys($ids);

        if (!empty($ids)) {
            $products = Product::query()
                ->whereIn('1s_id', $productIds)
                ->get();
            $product = $products->toArray();

            return $products;

        }
        return [];
    }

    public function toggleCompare(array $req): bool
    {
        $compares = session()->get(self::SESSION_KEY, []);

        $product_id = $req['product_1s_id'];
        if (in_array($product_id, $compares, true)) {

            $compares = array_values(array_filter($compares,
                    fn($id) => $id !== $product_id)
            );
            session()->put(self::SESSION_KEY, $compares);
            return false;
        }

        $compares[$product_id] = $product_id;
        session()->put(self::SESSION_KEY, $compares);
        return true;
    }
}