<?php

namespace app\service\Sync\Load;


use app\model\Product;
use app\model\ProductProperty;
use app\service\ShortLink\ShortlinkService;
use app\service\Slug\SlugService;
use Carbon\Carbon;
use Throwable;

class LoadProducts extends LoadService
{
    private array $existing = [];
    private array $deleted = [];
    private array $created = [];

    public function __construct()
    {
        parent::__construct();
        $this->setImportFile();
    }

    private function setImportFile(): void
    {
        $file = ROOT
            . env('SYNC_PATH')
            . 'loaded/'
            . env('SYNC_IMPORT_FILE');
        $this->logger->write("--- xml file - $file ---");
        $xml        = simplexml_load_file($file);
        $importData = json_decode(json_encode($xml), true);
        $this->productData = $importData['Каталог']['Товары']['Товар'];
    }

    public function load(): void
    {
        try {
            $this->updateOrCreateProducts();
            $this->deleteNonexisted();
        } catch (Throwable $exception) {
            $exc = $exception;
        }
    }


    private function deleteNonexisted(): void
    {
        $toDelete        = Product::whereNotIn('1s_id', $this->existing)->pluck('1s_id')->toArray();
        $this->deleted[] = $toDelete;
        $products        = Product::whereIn('1s_id', $toDelete)->get();
        $products->each(function ($product) {
            $product->delete();
        });
    }

    private function updateOrCreateProducts(): void
    {
        foreach ($this->productData as $good) {
            $this->existing[$good['Ид']] = $good['Ид'];
            $product                     = Product::withTrashed()
                ->updateOrCreate(
                    ['1s_id' => $good['Ид']],
                    $this->fillProduct($good)
                );
            $this->setProductOwnProps($good);

            if ($product->wasRecentlyCreated) {
                $this->created[] = $product['name'];
            }
        }
    }

    private function setProductOwnProps(array $good): void
    {
        $prodProps = ProductProperty::where('product_1s_id', $good['Ид'])
            ->first();
        if (!$prodProps) {
            $ownProps = ProductProperty::create([
                'product_1s_id' => $good['Ид'],
                'short_link' => ShortlinkService::getValidShortLink(),
                'txt' => $good['Описание']
                    ? preg_replace('/\n/', '<br>', $good['Описание'])
                    : '',
            ]);
            if ($prodProps && !$prodProps->short_link) {
                $prodProps->short_link = ShortlinkService::getValidShortLink();
                $prodProps->save();
            }
        }
    }

    private function fillProduct(array $good): array
    {
        $g['1s_id']          = $good['Ид'];
        $g['category_1s_id'] = $good['Группы']['Ид'];
        $g['art']            = $good['Артикул'] ? trim($good['Артикул']) : '';
        $g['name']           = $good['Наименование'];
        $g['print_name']     = $good['ЗначенияРеквизитов']['ЗначениеРеквизита'][3]['Значение'];
        $g['slug']           = $this->setSlug($g);
        $g['deleted_at']     = null;
        $g['updated_at']     = Carbon::now()->toDateTimeString();
        return $g;
    }

    private function fillProductProperties($good): array
    {
        $g['1s_id']          = $good['Ид'];
        $g['category_1s_id'] = $good['Группы']['Ид'];
        $g['art']            = $good['Артикул'] ? trim($good['Артикул']) : '';
        $g['name']           = $good['Наименование'];
        $g['print_name']     = $good['ЗначенияРеквизитов']['ЗначениеРеквизита'][3]['Значение'];
        $g['slug']           = $this->setSlug($g);
        $g['deleted_at']     = null;
        $g['updated_at']     = Carbon::now()->toDateTimeString();
        return $g;
    }

    private function setSlug($g): string
    {
        return SlugService::getValidProductSlug($g);
    }

}