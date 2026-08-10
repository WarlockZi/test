<?php

namespace app\service;

use app\model\Product;
use app\model\ProductUnit;
use app\service\Fs\FS;
use app\service\Image\BaseImage;
use app\service\Image\ProductMainImage;
use app\service\Logger\FileLogger;
use JetBrains\PhpStorm\NoReturn;

class HelpersService
{

    public static function setMainImages(): void
    {
        $products = Product::with('ownProperties')->get();
        foreach ($products as $product) {
            $name      = ProductMainImage::getFileNameFromArt($product);

            $pmi       = new BaseImage();
            $mainImage = $pmi->getImageFile('product', $name, null);

            $product->ownProperties->main_image = $mainImage;
            $product->ownProperties->save();
        }
    }

    private function getArt(string $ar): string
    {
        $art = str_replace(['/', '//', '\\', '\\\\'], '_', $ar);
        return trim(strip_tags($art));
    }

    #[NoReturn] public function saveProductImages(): void
    {
        $products = Product::all();
        $exts     = ['jpg', 'jpeg', 'png', 'webp'];

        foreach ($products as $product) {
            $art = $this->getArt($product->art);
            foreach ($exts as $ext) {
                $path     = FS::resolve(ROOT, env(PIC_PRODUCT));
                $imgName  = $art . '.' . $ext;
                $fullPath = $path . $imgName;
                if (is_readable($fullPath)) {
                    $product->txt = $imgName;
                    $product->save();
                }
            }
        }
    }

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
                ->whereNull('divider')
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
                if ($unit['pivot']['is_base'] === 1) {
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


    public static function profile()
    {
        echo xdebug_time_index() . ' сек. <br>';
    }

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

    private function copyBaseUnits()
    {
        $p = Product::all()->toArray();
        foreach ($p as $pr) {
            $model = [
                'product_1s_id' => $pr['1s_id'],
                'unit_id' => $pr['base_unit'],
                'divider' => 1,
                'is_base' => 1,
            ];
            ProductUnit::create($model);
        }
    }

// clean ports and start port 4000

    private function cleanBaseUnits()
    {
        $duplicates = ProductUnit::select('product_1s_id', 'unit_id', 'divider', 'is_base')
            ->groupBy('product_1s_id', 'unit_id', 'divider', 'is_base')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $logger = new FileLogger();
        $logger->write('duplicates->count -' . $duplicates->count());
        if (!$duplicates->count()) return null;
        foreach ($duplicates as $duplicate) {
            $res = ProductUnit::where('product_1s_id', $duplicate->product_1s_id)
                ->where('unit_id', $duplicate->unit_id)
                ->where('divider', $duplicate->divider)
                ->where('is_base', $duplicate->is_base)
                ->orderBy('unit_id', 'asc')
                ->skip(1)
                ->delete();
        }
        return true;
    }

}