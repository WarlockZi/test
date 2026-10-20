<?php


namespace app\repository;

use app\model\Compare;
use app\model\Product;
use app\service\AuthService\AuthService;
use app\service\Cart\CartService;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class CompareRepository
{
    public function addCompare(mixed $account_id, mixed $product_1s_id): void
    {
        $like = Compare::updateOrCreate(
            ['account_id' => $account_id,
                'product_1s_id' => $product_1s_id,
            ], []
        );
    }

    public static function all()
    {
        $products = Product::query()
            ->isCompared()
            ->with(['shippableUnits'])
            ->get()
            ->append(['is_compared', 'is_liked', 'cart_items'])
            ->toArray();

        return $products;
    }

    public static function updateOrCreate($req): bool
    {
        list($field, $value) = CartService::getCartFieldValue();
        try {
            Compare::updateOrCreate([
                $field => $value,
                'product_id' => $req['fields']['product_id'],
            ], [
                $field => $value,
                'product_id' => $req['fields']['product_id'],
            ]);
            return true;
        } catch (Throwable $exception) {
            return false;
        }
    }

    public static function del($req): bool
    {
        list($field, $value) = CartService::getCartFieldValue();
        try {
            $compare = Compare::where($field, $value)
                ->where('product_id', $req['fields']['product_id'])
                ->delete();
            return true;
        } catch (Throwable $exception) {
            return false;
        }
    }

}