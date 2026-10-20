<?php

namespace app\strategy\CompareToggleStrategy;

use app\model\Product;
use app\service\AuthService\AuthService;
use Illuminate\Database\Eloquent\Collection;

class AccountCompareToggleStrategy implements ICompareToggleStrategy
{
    private int $account_id;

    public function __construct()
    {
        $this->account_id = AuthService::accountId();
    }


    public function index(): Collection|array
    {
        $products = Product::query()
            ->whereHas('compare')
            ->get();
//        $products        = $products->toArray();
        return $products;
    }

    public function toggleCompare(array $req): bool
    {
        $account_id = AuthService::accountId();
        $product    = Product::where('1s_id', $req['product_1s_id'])
            ->with('compare', function ($q) use ($account_id) {
                return $q->where('account_id', $account_id);
            })
            ->first();
        if ($product->compare) {
            $product->compare->delete();
            return false;
        }

        $product->compare()->create(['account_id' => $account_id,
            'product_1s_id' => $req['product_1s_id']]);

        return true;

    }
}