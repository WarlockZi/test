<?php

namespace app\Actions;

use app\core\Response;
use app\model\Product;
use app\model\ProductUnit;
use app\model\Unitable;
use app\Services\Logger\FileLogger;

class Helpers
{
    //copy from unitables to ProductUnit
    public static function copyUnits()
    {
        $unitables = Product::all();
//        ProductUnit::query()
////            ->whereNull('product_1s_id')
//            ->whereNull('unit_id')
//            ->delete();
        foreach ($unitables as $unitable) {
            $prodUnit = ProductUnit::query()
                ->where('product_1s_id', $unitable['1s_id'])
                ->where('unit_id')
                ->whereNull('multiplier')
                ->get();
            if (!$prodUnit->count()) {
                $model = [
                    'product_1s_id' => $unitable['1s_id'],
                    'unit_id' => $unitable['base_unit'],
                    'is_base' => 1,
                ];
                ProductUnit::create($model);
            } else {
                $f = 1;
            }
        }
        Response::exitWithPopup('конец');
    }

    public static function clean()
    {
        $products = Product::with('units')
            ->select('id', '1s_id')
            ->get()
            ->toArray();
        foreach ($products as $product) {
            $arr   = [];
            $units = $product['units'];
            foreach ($units as $unit) {
                if ($unit['pivot']['is_base']) continue;
                if (!array_key_exists($unit['id'], $arr,)) {
                    $arr[$unit['id']] = $unit;
                } else {
                    $pu = ProductUnit::where('product_1s_id', $unit['pivot']['product_1s_id'])
                        ->where('id', $unit['pivot']['id'])
                        ->delete();
                }
            }
        }
        Response::exitWithPopup('конец');
    }

    public static function cleanBase()
    {
        $products = Product::with('units')
            ->select('id', '1s_id')
            ->get()
            ->toArray();
        foreach ($products as $product) {
            $arr   = [];
            $units = $product['units'];
            foreach ($units as $unit) {
                if (!$unit['pivot']['is_base']) continue;
                if (!array_key_exists($unit['id'], $arr,)) {
                    $arr[$unit['id']] = $unit;
                } else {
                    $pu = ProductUnit::where('product_1s_id', $unit['pivot']['product_1s_id'])
                        ->where('id', $unit['pivot']['id'])
                        ->delete();
                }
            }
        }
        Response::exitWithPopup('конец');
    }

    public static function makeBaseUnitsShippable()
    {
        $products = Product::with('units')
            ->select('id', '1s_id')
            ->get()
            ->toArray();
        foreach ($products as $product) {
            if (count($product['units']) === 1) {
                $unit = $product['units'][0];
                if ($unit['pivot']['is_base']===1) {
                    $pu = ProductUnit::query()
                        ->where('product_1s_id', $unit['pivot']['product_1s_id'])
                        ->where('id', $unit['pivot']['id'])
                        ->first();
                    $pu->update(['is_shippable' => 1]);
                }
            }
        }
        Response::exitWithPopup('конец');
    }

    public static function makeUnitsShippable()
    {
        $unitables = ProductUnit::all();
        foreach ($unitables as $unitable) {
            $unitable->is_shippable = 1;
            $unitable->save();
        }
    }


    private function copyBaseUnits()
    {
        $p = Product::all()->toArray();
        foreach ($p as $pr) {
            $model = [
                'product_1s_id' => $pr['1s_id'],
                'unit_id' => $pr['base_unit'],
                'multiplier' => 1,
                'is_base' => 1,
            ];
            ProductUnit::create($model);
        }
    }
    private function cleanBaseUnits()
    {
        $duplicates = ProductUnit::select('product_1s_id', 'unit_id', 'multiplier', 'is_base')
            ->groupBy('product_1s_id', 'unit_id', 'multiplier', 'is_base')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $logger = new FileLogger();
        $logger->write('duplicates->count -'.$duplicates->count());
        if (!$duplicates->count()) return null;
        foreach ($duplicates as $duplicate) {
            $res = ProductUnit::where('product_1s_id', $duplicate->product_1s_id)
                ->where('unit_id', $duplicate->unit_id)
                ->where('multiplier', $duplicate->multiplier)
                ->where('is_base', $duplicate->is_base)
                ->orderBy('unit_id', 'asc')
                ->skip(1)
                ->delete();
        }
        return true;
    }
// clean ports and start port 4000
    public function serve()
    {
        $host = '127.0.0.1';
//		$host = 'localhost';
        $ports = [4000];
        $self  = new self;

        foreach ($self->ports as $port) {
            $errno  = null;
            $errstr = null;

            $connection = @fsockopen($self->host, $port, $errno, $errstr);

            if (is_resource($connection)) {
//				$command = "npx kill-port $port";
//				$output = exec($command);
//				fclose($connection);
////				echo '<p>' . $self->host . ':' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</p>' . "\n";
//				$output = shell_exec('npm run serve');

            } else {
//				$output = shell_exec('npm run serve');
//				$output = shell_exec('npm run serve');
//				echo "<p>{$self->host}:{$port} is not responding. Error {$errno}: {$errstr} </p>" . "\n";
            }
        }
    }
}