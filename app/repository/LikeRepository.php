<?php


namespace app\repository;


use app\model\Like;
use app\service\Auth\Auth;
use Throwable;

class LikeRepository
{
    public static function all()
    {
        list($field, $value) = Auth::getCartFieldValue();
        $likes = Like::where($field, $value)
            ->with('product')
            ->get();
        return $likes;
    }

    public static function updateOrCreate($req): bool
    {
        list($field, $value) = Auth::getCartFieldValue();
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
        list($field, $value) = Auth::getCartFieldValue();
        try {
            $like = Like::find($req['id'])->delete();
            return true;
        } catch (Throwable $exception) {
            return false;
        }
    }

}