<?php


namespace app\Repository;


use app\core\Auth;
use app\model\Like;
use Throwable;

class LikeRepository
{
    public static function all()
    {
        $user  = Auth::getUser();
        $field = $user ? 'user_id' : 'sess';
        $value = $user ? Auth::getUser()->getId() : session_id();
        $likes = Like::where($field, $value)
            ->with('product')
            ->get();
        return $likes;
    }

    public static function updateOrCreate($req): bool
    {
        $user  = Auth::getUser();
        $field = $user ? 'user_id' : 'sess';
        $value = $user ? Auth::getUser()->getId() : session_id();
        try {
            Like::updateOrCreate([
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
        $user  = Auth::getUser();
        $field = $user ? 'user_id' : 'sess';
        $value = $user ? Auth::getUser()->getId() : session_id();
        try {
            $like = Like::where($field, $value)
                ->where('product_id', $req['fields']['product_id'])
                ->delete();
            return true;
        } catch (Throwable $exception) {
            return false;
        }
    }

}