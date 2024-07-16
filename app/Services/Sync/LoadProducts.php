<?php

namespace app\Services\Sync;


use app\model\Category;
use app\model\Product;
use app\Services\ShortlinkService;
use app\Services\Slug;
use Carbon\Carbon;

class LoadProducts extends Load
{

    protected $logger;

    public function __construct($file)
    {
        parent::__construct($file, 'product');
        $this->run();
    }

    protected function run(): void
    {
        $this->updateOrCreateProducts();
        $this->setShortLink();
    }

    protected function setShortLink(): void
    {
        Product::with('ownProperties')->get()->each(function (Product $product) {
            $product->ownProperties()->updateOrCreate(
                ['product_1s_id' => $product['1s_id']],
                ['product_1s_id' => $product['1s_id'],
                    'short_link' => ShortlinkService::getValidShortLink(),
                ]
            );
        });
    }

    private function updateOrCreateProducts(): void
    {
        foreach ($this->data as $good) {
            $foundProduct = Product::withTrashed()
                ->updateOrCreate(
                    ['1s_id' => $good['Ид']],
                    $this->fillNewProduct($good)
                );
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

    protected function ech($item, $id, $sameSlug = ''): void
    {
        echo "{$id}  - {$sameSlug} {$item['name']}<br>";
    }
}