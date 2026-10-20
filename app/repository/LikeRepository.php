<?php


namespace app\repository;


use app\formRequest\LikeRequest;
use app\model\Like;
use app\model\Product;
use app\service\AuthService\AuthService;
use app\service\Cart\CartService;
use Throwable;

class LikeRepository
{
    public function addLikes(mixed $account_id, mixed $product_id): void
    {
        $like = Like::updateOrCreate(
            [
                'account_id' => $account_id,
                'product_id' => $product_id,
            ],
            [
            ]
        );
    }

   public static function updateOrCreate(array $req): bool
    {
        $account_id = AuthService::accountId();

        list($field, $value) = CartService::getCartFieldValue();
        try {
            $like = Like::updateOrCreate([
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
            $like = Like::find($req['id'])->delete();
            return true;
        } catch (Throwable $exception) {
            return false;
        }
    }

}