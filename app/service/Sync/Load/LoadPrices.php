<?php

namespace app\service\Sync\Load;

use app\model\Currency;
use app\model\Price;
use app\model\PriceType;
use app\model\Product;
use app\model\ProductUnit;
use app\model\Unit;
use app\traits\MeasureTime;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Throwable;

class LoadPrices extends LoadService
{
    use MeasureTime;
    use ChunkTrait;

    private array $offer;
    private $currency1s;
    private $unit;
    private $product;
    private $priceType1s;
    private $priceTypeComputed;
    private $price;
    private $productUnit;
    private $row;

    public function __construct()
    {
        parent::__construct();
    }
    private function exec(): void
    {
        $i = 0;
        foreach ($this->priceData as $offer) {
//            $i++;
//            if ($i>3) break;
            $this->prepareOffer($offer);
            $this->firstOrCreateUnit();
            $this->findProductUpdateInstore();

            $this->firstOrCreatePruductUnit();
        }
    }
    private function setOfferFile(): void
    {
        $file               = ROOT . env('SYNC_PATH') . env('SYNC_OFFER_FILE');
        $this->logger->write("--- xml file - $file ---");
        $xml                = simplexml_load_file($file);
        $offerData =  json_decode(json_encode($xml), true);
        $this->priceData = $offerData['ПакетПредложений']['Предложения']['Предложение'];
    }

    /**
     * @throws Exception|Throwable
     */
    #[NoReturn]
    public function load(): void
    {
        $this->setOfferFile();
        $this->exec();

        $this->logger->write('--- price     loaded ---');
    }

    protected function firstOrCreateUnit(): void
    {
        $this->unit = Unit::firstOrCreate(
            ['code' => $this->offer['unit_code']],
            [
                'name' => lcfirst(substr($this->offer['unit'], 0, 3)) ?? null,
                'international' => $this->offer['international'] ?? null,
                'full_name' => $this->offer['unit'],
            ]);
    }

    protected function cleanDoubleUnits(): void
    {
        $ids = [];
        foreach ($this->product->units as $unit) {
            if (in_array($unit->id, $ids)) {
                $unit->pivot->delete();
            } else {
                $ids[] = $unit->id;
            }
        }
    }

    /**
     * @throws Exception
     */
    protected function findProductUpdateInstore(): void
    {
        try {
            $this->product = Product::where('1s_id', $this->offer['1s_id'])
                ->with(['units.prices.type'])
                ->first();

//            $this->cleanDoubleUnits();

            $this->product->update(['instore' => $this->offer['instore']]);
        } catch (Throwable $exception) {
            throw new Exception('Load prices failed to find product'.$exception->getMessage());
        }
    }

    protected function firstOrCreatePruductUnit(): void
    {
        $this->productUnit = ProductUnit::where('price', '<>', null)
            ->firstOrCreate(
                ['product_1s_id' => $this->product['1s_id'],
                    'unit_id' => $this->unit->id,

                ],
                ['is_shippable' => null,
                    'multiplier' => null,
                    'price'=>$this->offer['price']
                ]);
    }

    protected function updateOrCreatePrice(): void
    {
        $this->price = Price::updateOrCreate(
            [
                'product_unit_id' => $this->productUnit->id,
                'price-type_id' => $this->priceType1s->id,
                'currency_id' => $this->currency1s->id,
            ],
            [
                'value' => $this->offer['price'] ?? '',
            ]);
    }

    private function prepareOffer(array $data): void
    {
        $this->offer = [
            '1s_id' => trim($data['Ид']),
            'art' => trim($data['Артикул']),
            'instore' => trim($data['Количество']),

            'price' => trim($data['Цены']['Цена']['ЦенаЗаЕдиницу'] ?? ''),
            'currency' => trim($data['Цены']['Цена']['Валюта']),

            'unit_code' => trim($data['БазоваяЕдиница']['@attributes']['Код'] ?? ''),
            'international' => trim($data['БазоваяЕдиница']['@attributes']['МеждународноеСокращение'] ?? null),
            'unit' => trim($data['БазоваяЕдиница']['@attributes']['НаименованиеПолное'] ?? null),
        ];

//        $this->measureTime($this, 'optimizedProcess');

    }

    private function firstOrCreatePriceType(): void
    {
        $this->priceType1s       = PriceType::firstOrCreate(
            ['type' => '1s',],
            ['type' => '1s',]
        );
        $this->priceTypeComputed = PriceType::firstOrCreate(
            ['type' => 'Computed',],
            ['type' => 'Computed',]
        );
    }

    private function firstOrCreateCurrency(): void
    {
        $currency1sName   = $this->pricesData[0]['Цены']['Цена']['Валюта'] ?? $this->pricesData[1]['Цены']['Цена']['Валюта'];
        $this->currency1s = Currency::firstOrCreate(
            [
                '1s_name' => $currency1sName],
            [
                '1s_name' => $currency1sName,
                'web_name' => '₽']
        );
    }

}