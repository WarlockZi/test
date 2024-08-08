<?php

namespace app\Services\Sync;


use app\model\Category;
use app\model\Product;
use app\Services\ShortlinkService;
use app\Services\Slug;
use Carbon\Carbon;

class LoadProducts
{
    public function __construct(
        readonly private string $file,
        private array           $data = [],
        private array           $existing = [],
        private array           $created = [],
        private array           $deleted = [],
    )
    {
        $xml        = simplexml_load_file($this->file);
        $xmlObj     = json_decode(json_encode($xml), true);
        $this->data = $xmlObj['Каталог']['Товары']['Товар'];

        $this->run();
    }

    protected function run(): void
    {
        try {
            $this->updateOrCreateProducts();
//        $this->setShortLink();
            $this->deleteNonexisted();
        } catch (Throwable $exception) {
            $exc = $exception;
        }

    }

    protected function deleteNonexisted(): void
    {
        $toDelete        = Product::whereNotIn('1s_id', $this->existing)->pluck('1s_id')->toArray();
        $this->deleted[] = $toDelete;
        $products        = Product::whereIn('1s_id', $toDelete)->get();
        $products->each(function ($product) {
            $product->delete();
        });
    }

    protected function setShortLink(): void
    {
        Product::with('ownProperties')->get()->each(function (Product $product) {
            $prodProps = $product
                ->ownProperties()
                ->where('product_1s_id', $product['1s_id'])
                ->first();
            if ($prodProps && !empty($prodProps->short_link)) {
                $prodProps->update(['short_link' => ShortlinkService::getValidShortLink()]);
            }
        });
    }

    private function updateOrCreateProducts(): void
    {
        foreach ($this->data as $good) {
            $this->existing[$good['Ид']] = $good['Ид'];
            $product                     = Product::withTrashed()
                ->updateOrCreate(
                    ['1s_id' => $good['Ид']],
                    $this->fillNewProduct($good)
                );
            if ($product->wasRecentlyCreated) {
                $this->created[] = $product['name'];
            }
        }
    }

    protected function fillNewProduct($good): array
    {
        $g['1s_id']          = $good['Ид'];
        $g['art']            = $good['Артикул'] ? trim($good['Артикул']) : '';
        $g['txt']            = $good['Описание'] ? preg_replace('/\n/', '<br>', $good['Описание']) : '';
        $g['name']           = $good['Наименование'];
        $g['print_name']     = $good['ЗначенияРеквизитов']['ЗначениеРеквизита'][3]['Значение'];
        $g['1s_category_id'] = $good['Группы']['Ид'];
        $g                   = $this->setSlug($g);
        $g                   = $this->setCategory($good, $g);
        $g['deleted_at']     = null;
        $g['created_at']     = Carbon::now()->toDateTimeString();
        return $g;
    }

    private function setSlug($g): array
    {
        $g['slug'] = Slug::slug($g['print_name']);
        if (Product::where('slug', $g['slug'])->first()) {
            $g['slug'] = $g['slug'] . '_' . Slug::slug($g['art']);
        }
        return $g;
    }

    private function setCategory($good, $g): array
    {
        $g['category_id'] = Category::where('1s_id', $good['Группы']['Ид'])
            ->first()->id;
        return $g;
    }

}