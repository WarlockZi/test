<?php


namespace app\repository;

use app\formRequest\CompareRequest;
use app\model\Compare;
use app\service\AuthService\Auth;
use Illuminate\Database\Eloquent\Collection;
use LaravelIdea\Helper\app\model\_IH_Compare_C;
use Throwable;

class CompareRepository
{
    public static function all(): Collection|_IH_Compare_C|array
    {
        list($field, $value) = Auth::getCartFieldValue();
        $compares = Compare::where($field, $value)
            ->with('product.units')
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