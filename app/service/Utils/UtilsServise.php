<?php

namespace app\service\Utils;

use app\model\Product;

class UtilsServise
{
    public static function cleanUnitsFromIs(): void
    {
        $processed = 0;
        Product::has('units', '>', 3)
            ->chunk(100, function ($products) use (&$processed) {
                $processed += 1;
                foreach ($products as $product) {
                    $id = [];
                    foreach ($product->units as $unit) {
                        if (count($id)) {
                            $unit->pivot->delete();
                        }
                        if ($unit->pivot->is_from_1s = 1) {
                            $id[] = $unit->id;
                        }
                    }
                }
            });
        $d         = $processed;
    }

    public static function checkExtendion(string $extendion)
    {
        if (extension_loaded($extendion)) {
            $res = "{$extendion} OK";
        } else {
            $res = "{$extendion} UNAVAILABLE";
        }
//        echo $res;
//        exit($res);
    }

}