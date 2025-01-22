<?php


namespace app\Repository;

use app\core\Auth;
use app\model\Compare;
use Throwable;

class CompareRepository
{
    public static function all()
    {
        list($field, $value) = Auth::getCartFieldValue();
        $compares = Compare::where($field, $value)
            ->with('product')
            ->get();
        return $compares;
    }

    public static function updateOrCreate($req): bool
    {
        list($field, $value) = Auth::getCartFieldValue();
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
        list($field, $value) = Auth::getCartFieldValue();
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