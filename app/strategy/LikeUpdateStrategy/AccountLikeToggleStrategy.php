<?php

namespace app\strategy\LikeUpdateStrategy;

use app\model\Product;
use app\service\AuthService\AuthService;
use Illuminate\Database\Eloquent\Collection;

class AccountLikeToggleStrategy implements ILikeToggleStrategy
{
    private int $account_id;

    public function __construct()
    {
        $this->account_id = AuthService::accountId();
    }


    public function index(): Collection|array
    {
        $products = Product::query()
            ->whereHas('like')
            ->get();
//        $products        = $products->toArray();
        return $products;
    }

    public function toggleLike(array $req): bool
    {
        $account_id = AuthService::accountId();
        $product    = Product::where('1s_id', $req['product_1s_id'])
            ->with('like', function ($q) use ($account_id) {
                return $q->where('account_id', $account_id);
            })
            ->first();
        if ($product->like) {
            $product->like->delete();
            return false;
        }

        $product->like()->create(['account_id' => $account_id,
            'product_1s_id' => $req['product_1s_id']]);

        return true;

    }
}